<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\ObjectManagerInterface;
use Magento\ImportService\Api\Data\ImportConfigInterface;
use Magento\ImportService\Api\Data\ImportStartResponseInterface;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\ImportStartInterface;
use Magento\ImportService\Api\SourceRepositoryInterface;
use Magento\ImportService\Model\Import\SourceTypePool;
use Magento\ImportService\Model\Source\ReaderPool;
use Magento\ImportService\Model\Config\Converter as ImportServiceConverter;
use Magento\ImportService\Model\Source\RulesProcessorFactory;
use Magento\ImportService\Model\Storage\MagentoRest;
use Magento\ImportServiceCsv\Model\CsvPathResolver;
use Magento\ImportServiceCsv\Model\JsonPathResolver;
use Magento\ImportServiceXml\Model\XmlPathResolver;
use Magento\ImportService\Model\ConfigInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ImportStart
 */
class ImportStart implements ImportStartInterface
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;
    /**
     * @var ImportStartResponseFactory
     */
    private $importStartResponseFactory;
    /**
     * @var \Magento\ImportService\Api\SourceRepositoryInterface
     */
    private $sourceRepository;
    /**
     * @var \Magento\ImportService\Model\Import\SourceTypePool
     */
    private $sourceTypePool;
    /**
     * @var \Magento\ImportService\Model\Source\ReaderPool
     */
    private $readerPool;
    /**
     * @var \Magento\ImportService\Model\ConfigInterface
     */
    private $importConfig;
    /**
     * @var \Magento\ImportService\Model\Source\RulesProcessorFactory
     */
    private $rulesProcessorFactory;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * ImportStart constructor.
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\ImportService\Model\ConfigInterface $importConfig
     * @param \Magento\ImportService\Model\ImportStartResponseFactory $importStartResponseFactory
     * @param \Magento\ImportService\Api\SourceRepositoryInterface $sourceRepository
     * @param \Magento\ImportService\Model\Source\RulesProcessorFactory $rulesProcessorFactory
     * @param \Magento\ImportService\Model\Source\ReaderPool $readerPool
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ConfigInterface $importConfig,
        ImportStartResponseFactory $importStartResponseFactory,
        SourceRepositoryInterface $sourceRepository,
        RulesProcessorFactory $rulesProcessorFactory,
        ReaderPool $readerPool,
        LoggerInterface $logger
    ) {
        $this->objectManager = $objectManager;
        $this->importConfig = $importConfig;
        $this->importStartResponseFactory = $importStartResponseFactory;
        $this->sourceRepository = $sourceRepository;
        $this->readerPool = $readerPool;
        $this->rulesProcessorFactory = $rulesProcessorFactory;
        $this->logger = $logger;
    }

    /**
     *  {@inheritdoc}
     */
    public function execute($uuid, $type, ImportConfigInterface $importConfig)
    {
        $importStartResponse = $this->importStartResponseFactory->create();

        $source = $this->sourceRepository->getByUuid($uuid);
        $reader = $this->readerPool->getReader($source);

        //$config = $this->importConfig->getImportType($source->getImportType());
        $reader->rewind();
        $source->setData('config_type', $type);
        foreach ($reader as $sourceItem) {
            $mappingFrom = $this->processMappingFrom($sourceItem, $source);
            $mappingFrom = $this->applyProcessingRules($sourceItem, $mappingFrom, $source);
            $itemToImport = $this->buildItem($mappingFrom, $source);
            $result = $this->importToStorage($itemToImport, $source, $type, $importConfig);
        }

        $importStartResponse->setError('');
        $importStartResponse->setStatus('processing');
        $importStartResponse->setUuid($uuid);
        return $importStartResponse;
    }

    private function processMappingFrom($sourceItem, SourceInterface $source)
    {
        $processor = $this->importConfig->getMappingProcessorSource($source->getData('config_type'));
        if (!isset($processor)) {
            throw new NotFoundException(__('Mapping source processor not defined.'));
        }
        /** @var XmlPathResolver $pathResolver */
        $pathResolver = $this->objectManager->get($processor);

        $mappingSource = $source->getMapping();
        $mapping = [];
        foreach ($mappingSource as $fieldMappingSource) {
            $fieldMapping = clone $fieldMappingSource;
            if ($fieldMapping->getSourcePath() == null || $fieldMapping->getSourcePath() == '') {
                $value = $sourceItem;
            } else {
                $value = $pathResolver->get($sourceItem, $fieldMapping->getSourcePath());
            }
            $fieldMapping->setSourceValue($value);
            $mapping[] = $fieldMapping;
        }
        return $mapping;
    }

    /**
     * @param mixed $sourceItem
     * @param \Magento\ImportService\Model\Source\FieldMapping[] $mapping
     * @param SourceInterface $source
     * @return \Magento\ImportService\Model\Source\FieldMapping[]
     * @throws \Exception
     */
    private function applyProcessingRules($sourceItem, $mapping, $source)
    {
        $variables = [
            'custom_attributes' => []
        ];
        $rulesRecreated = [];
        foreach ($mapping as $fieldMapping) {
            $processingRules = $fieldMapping->getProcessingRules();
            $fieldName = $fieldMapping->getName();
            $value = $fieldMapping->getSourceValue();
            $targetValue = $fieldMapping->getTargetValue();
            if (isset($targetValue)) {
                $value = $targetValue;
            }
            if (!empty($processingRules)) {
                usort($processingRules, function ($a, $b) {
                    return (int)$a->getSort() - $b->getSort();
                });
                $fieldMapping->setProcessingRules($processingRules);

                /** @var \Magento\ImportService\Api\Data\ProcessingRulesRuleInterface $rule */
                foreach ($fieldMapping->getProcessingRules() as $rule) {
                    $forceCreate = false;
                    if (!in_array($rule->getFunction(), $rulesRecreated)) {
                        $forceCreate = true;
                        $rulesRecreated[] = $rule->getFunction();
                    }

                    $args = $rule->getArgs();
                    if (!isset($args)) {
                        $args = [];
                    }
                    foreach ($args as &$arg) {
                        if (!is_string($arg)) {
                            continue;
                        }
                        $searchResult = [];
                        preg_match('/{{([A-Za-z\-\_\.]+)}}/', $arg, $searchResult);
                        if (count($searchResult) > 1) {
                            if (!array_key_exists($searchResult[1], $variables)) {
                                throw new LocalizedException(__("Varibale %1 for import field %2 not defined yet. Check fields mapping order.", $arg, $fieldName));
                            }
                            $arg = $variables[$searchResult[1]];
                        }
                    }
                    /** @var \Magento\ImportService\Model\ProcessingRules\ProcessingRuleInterface $processor */
                    $processor = $this->rulesProcessorFactory->create($rule->getFunction(), [], $forceCreate);
                    $processor->setSource($source);
                    $processor->setArguments($args);
                    $processor->setValue($value);

                    $value = $processor->execute();//change to call_user_func_array
                }
            }
            $variables[$fieldMapping->getName()] = $value;
            $fieldMapping->setTargetValue($value);
        }
        return $mapping;
    }

    /**
     * @param \Magento\ImportService\Api\Data\FieldMappingInterface[] $mapping
     * @param SourceInterface $source
     * @return mixed
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    private function buildItem($mapping, $source)
    {
        $processor = $this->importConfig->getMappingProcessorTarget($source->getData('config_type'));
        if (!isset($processor)) {
            throw new NotFoundException(__('Mapping target processor not defined.'));
        }
        /** @var JsonPathResolver $pathResolver */
        $pathResolver = $this->objectManager->get($processor);

        $itemData = null;
        foreach ($mapping as $fieldMapping) {
            $itemData = $pathResolver->set($itemData, $fieldMapping->getTargetPath(), $fieldMapping->getTargetValue());
        }
        return $itemData;
    }

    /**
     * @param mixed $item
     * @param SourceInterface $source
     * @param string $type
     * @param \Magento\ImportService\Api\Data\ImportConfigInterface $importConfig
     * @return mixed
     */
    private function importToStorage($item, $source, $type, ImportConfigInterface $importConfig)
    {
        $storages = $this->importConfig->getStorages($type, $importConfig->getBehaviour());
        $result = [];
        foreach ($storages as $storage) {
            $constructArguments = [
                'data' => $storage['data']
            ];
            $method = $storage['method'];
            $storage = $this->objectManager->create($storage['class'], $constructArguments);
            try {
                //$arguments = [$item, $source];
                $result[] = $storage->execute($item, $source);
                //$result[] = call_user_func_array([$storage, $method], $arguments);
            } catch (\Exception $e) {
                $this->logger->error(sprintf("Import Uuid %s failed to save data to storage. %s", $source->getUuid(), $e->getMessage()));
            }
        }
        return $result;
    }
}

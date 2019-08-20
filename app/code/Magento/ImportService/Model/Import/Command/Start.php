<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Command;

use Magento\ImportServiceApi\Api\Data\ImportConfigInterface;
use Magento\ImportService\Model\Source\ReaderPool;
use Magento\ImportServiceSourceCsv\Model\Source\Resolver\CsvPath as CsvPathResolver;
use Magento\ImportService\Model\Import\Mapping\ProcessSourceItemMappingFactory as ItemMappingProcessorFactory;
use Magento\ImportService\Model\Import\Mapping\ApplyProcessingRules;
use Magento\ImportServiceApi\Model\ImportStartResponse;
use Magento\ImportServiceApi\Api\SourceRepositoryInterface;
use Magento\ImportService\Model\Import\ExchangeRepository;

/**
 * Class Start
 */
class Start implements StartInterface
{

    /**
     * @var ReaderPool
     */
    private $readerPool;

    /**
     * @var CsvPathResolver
     */
    private $csvPathResolver;

    /**
     * @var ItemMappingProcessor
     */
    private $itemMappingProcessor;

    /**
     * @var ApplyProcessingRules
     */
    private $applyProcessingRules;

    /**
     * @var SourceRepositoryInterface
     */
    private $sourceRepository;

    /**
     * @var ExchangeRepository
     */
    private $exchangeRepository;

    /**
     * Start constructor.
     *
     * @param ReaderPool $readerPool
     * @param CsvPathResolver $csvPathResolver
     * @param ItemMappingProcessorFactory $itemMappingProcessor
     * @param ApplyProcessingRules $applyProcessingRules
     * @param SourceRepositoryInterface $sourceRepository
     */
    public function __construct(
        ReaderPool $readerPool,
        CsvPathResolver $csvPathResolver,
        ItemMappingProcessorFactory $itemMappingProcessor,
        ApplyProcessingRules $applyProcessingRules,
        SourceRepositoryInterface $sourceRepository,
        ExchangeRepository $exchangeRepository
    ) {
        $this->readerPool = $readerPool;
        $this->itemMappingProcessor = $itemMappingProcessor;
        /**
         * @TODO we need to implement detecting of resolvers depends from source format
         */
        $this->csvPathResolver = $csvPathResolver;
        $this->applyProcessingRules = $applyProcessingRules;
        $this->sourceRepository = $sourceRepository;
        $this->exchangeRepository = $exchangeRepository;
    }

    public function execute(string $uuid, ImportConfigInterface $importConfig, ImportStartResponse $importResponse)
    {
        $source = $this->sourceRepository->getByUuid($uuid);

        $reader = $this->readerPool->getReader($source);
        $reader->rewind();

        $mappingItemsList = [];
        /** @var array $sourceItem */
        foreach ($reader as $sourceItem) {
            $processSourceItemFactory = $this->itemMappingProcessor->create([
                'data' => $sourceItem,
                'mapping' => $importConfig->getMapping(),
                'processor' => $this->csvPathResolver
            ]);
            $mappedItem = $processSourceItemFactory->process();
            $mappingItemsList[] = $this->applyProcessingRules->execute($mappedItem);
        }

        $exchangeProcessor = $this->exchangeRepository->getExchangeProcessor();
        $importResponse = $exchangeProcessor->process($mappingItemsList, $importConfig, $importResponse);
        return $importResponse;

    }
}
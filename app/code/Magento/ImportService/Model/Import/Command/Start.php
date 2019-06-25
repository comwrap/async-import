<?php

namespace Magento\ImportService\Model\Import\Command;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Model\Source\ReaderPool;
use Magento\Framework\Exception\NotFoundException;
use Magento\ImportService\Model\Import\Mapping\GetMappingProcessorSource;
use Magento\ImportService\Model\Import\Mapping\GetMappingProcessorTarget;
use Magento\ImportService\Model\Import\Mapping\ProcessSourceItemMappingFactory;
use Magento\ImportService\Model\Import\Mapping\ApplyProcessingRules;
use Magento\ImportService\Api\Data\ImportConfigInterface;
use Magento\ImportService\Model\Import\Mapping\BuildItemRequest;

class Start implements StartInterface
{

    /**
     * @var \Magento\ImportService\Model\Source\ReaderPool
     */
    private $readerPool;

    private $processSourceItemFactory;

    private $mappingProcessorSource;

    /**
     */
    public function __construct(
        ReaderPool $readerPool,
        GetMappingProcessorSource $mappingProcessorSource,
        GetMappingProcessorTarget $mappingProcessorTarget,
        ProcessSourceItemMappingFactory $processSourceItemMappingFactory,
        ApplyProcessingRules $applyProcessingRules,
        BuildItemRequest $buildItemRequest
    ) {
        $this->readerPool = $readerPool;
        $this->mappingProcessorSource = $mappingProcessorSource;
        $this->processSourceItemMappingFactory = $processSourceItemMappingFactory;
        $this->mappingProcessorTarget = $mappingProcessorTarget;
        $this->applyProcessingRules = $applyProcessingRules;
        $this->buildItemRequest = $buildItemRequest;
    }

    public function execute(SourceInterface $source, ImportConfigInterface $importConfig)
    {

        $reader = $this->readerPool->getReader($source);
        $reader->rewind();

        // Detect prodcessor based on a source type
        // Magento\ImportServiceXml\Model\XmlPathResolver
        // Magento\ImportServiceCsv\Model\CsvPathResolver
        /**
         * Factory OR we can do a DATA object
         */
        $mappingSourceProcessor = $this->mappingProcessorSource->get($source->getData("config_type"));

        $mappingItemsList = [];
        /** @var array $sourceItem */
        foreach ($reader as $sourceItem) {

            $processSourceItemFactory = $this->processSourceItemMappingFactory->create([
                'data' => $sourceItem,
                'mapping' => $source->getMapping(),
                'processor' => $mappingSourceProcessor
            ]);
            $mappedItem = $processSourceItemFactory->process();
            $mappingItemsList[] = $this->applyProcessingRules->execute($mappedItem);


        }
        $result = $this->importToStorage($mappingItemsList, $source->getData("config_type"), $importConfig, $source);

    }
    /**
     * @param mixed $item
     * @param SourceInterface $source
     * @param string $type
     * @param \Magento\ImportService\Api\Data\ImportConfigInterface $importConfig
     * @return mixed
     */
    private function importToStorage($requestItem, $type, ImportConfigInterface $importConfig)
    {

        // LOGIC TO EXPORT COMING HERE

//        $storages = $this->importConfig->getStorages($type, $importConfig->getBehaviour());
//        $result = [];
//        foreach ($storages as $storage) {
//            $constructArguments = [
//                'data' => $storage['data']
//            ];
//            $method = $storage['method'];
//            $storage = $this->objectManager->create($storage['class'], $constructArguments);
//            try {
//                $result[] = $storage->execute($requestItem, $source);
//            } catch (\Exception $e) {
//                $this->logger->error(sprintf("Import Uuid %s failed to save data to storage. %s", $source->getUuid(), $e->getMessage()));
//            }
//        }
//        return $result;
    }


}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\FileEntryInterface;

/**
 * Class ImportFile
 *
 * @package Magento\ImportService\Model
 */
class ImportFile implements \Magento\ImportService\Api\ImportFileInterface
{
    /**#@-*/
    private $entityAdapter;

    /**
     * @var \Magento\ImportExport\Model\ImportFactory
     */
    private $importModelFactory;
    /**
     * @var \Magento\ImportService\Model\Source\TypePool
     */
    private $typePool;
    /**
     * @var \Magento\ImportService\Model\Source\FileTypePool
     */
    private $fileTypePool;
    /**
     * @var \Magento\Framework\Filesystem\Directory\ReadFactory
     */
    private $readFactory;
    /**
     * @var \Magento\ImportService\Model\ConfigInterface
     */
    private $importServiceConfig;
    /**
     * @var \Magento\ImportService\Model\Entity\Factory
     */
    private $entityFactory;

    /**
     * @param \Magento\ImportExport\Model\ImportFactory $importModelFactory
     * @param \Magento\Framework\Filesystem\Directory\ReadFactory $readFactory
     * @param \Magento\ImportService\Model\Source\TypePool $typePool
     * @param \Magento\ImportService\Model\Source\FileTypePool $fileTypePool
     * @param \Magento\ImportService\Model\ConfigInterface $importServiceConfig
     * @param \Magento\ImportService\Model\Entity\Factory $entityFactory
     * @internal param \Magento\ImportService\Model\ConfigInterface $importService
     */
    public function __construct(
        \Magento\ImportExport\Model\ImportFactory $importModelFactory,
        \Magento\Framework\Filesystem\Directory\ReadFactory $readFactory,
        \Magento\ImportService\Model\Source\TypePool $typePool,
        \Magento\ImportService\Model\Source\FileTypePool $fileTypePool,
        \Magento\ImportService\Model\ConfigInterface $importServiceConfig,
        \Magento\ImportService\Model\Entity\Factory $entityFactory,
        \Magento\ImportService\Controller\Import\FilesProcessorPool $fileProcessorPool
    ) {
        $this->importModelFactory = $importModelFactory;
        $this->typePool = $typePool;
        $this->fileTypePool = $fileTypePool;
        $this->readFactory = $readFactory;
        $this->importServiceConfig = $importServiceConfig;
        $this->entityFactory = $entityFactory;
        $this->fileProcessorPool = $fileProcessorPool;
    }

    public function importFile(FileEntryInterface $fileEntry){

        $processor = $this->fileProcessorPool->getProcessor($fileEntry);
        echo get_class($processor);
        echo "import file is here";
        exit;



        try {

            $data = [
                'entity' => 'catalog_product',
                'behavior' => 'append',
                'validation_strategy' => 'validation-skip-errors',
                'allowed_error_count' => '10000',
                '_import_field_separator' => ',',
                '_import_multiple_value_separator' => ',',
                '_import_empty_attribute_value_constant' => '__EMPTY__VALUE__',
                'import_images_file_dir' => '',
            ];
            /** @var \Magento\ImportExport\Model\Import $importModel */

            //$importModel = $this->importModelFactory->create($data);
            //$importModel->importSource();

            /** @var \Magento\ImportService\Api\Data\ImportParamsInterface $importParams */
//            $importParams = $importEntry->getImportParams();
//            $entityType = $importParams->getEntityType();
//            $behaviour = $importParams->getBehavior();
//            $importServiceConfig = $this->importServiceConfig->getEntities();

            $fileProcessor = $this->getSource($importEntry);

            $source->rewind();
            while ($source->valid()) {
                $rowData = $source->current();



                $source->next();
            }
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }

    }

    /**
     * @param \Magento\ImportService\Api\Data\ImportEntryInterface $importEntry
     * @return \Magento\ImportExport\Model\Import\AbstractSource
     */
    private function getSource(ImportEntryInterface $importEntry)
    {
        $file = $this->typePool->getFileForType(
            $importEntry->getSource()->getType(),
            $importEntry->getSource()->getImportData()
        );
        $fileName = (string)$file;
        $path = pathinfo($fileName, PATHINFO_DIRNAME);
        $directory = $this->readFactory->create($path);
        $source = $this->fileTypePool->findAdapterFor(
            $importEntry->getSource()->getFileType(),
            $directory,
            $fileName,
            $importEntry->getImportParams()
        );
        $source->rewind();
        return $source;
    }
}

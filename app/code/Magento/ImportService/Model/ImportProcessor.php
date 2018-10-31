<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\ImportEntryInterface;
use Epfremme\Swagger\Factory\SwaggerFactory;

/**
 * Class ImportProcessor
 *
 * @package Magento\ImportService\Model
 */
class ImportProcessor implements \Magento\ImportService\Api\ImportProcessorInterface
{
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
     * @param \Magento\ImportExport\Model\ImportFactory $importModelFactory
     * @param \Magento\Framework\Filesystem\Directory\ReadFactory $readFactory
     * @param \Magento\ImportService\Model\Source\TypePool $typePool
     * @param \Magento\ImportService\Model\Source\FileTypePool $fileTypePool
     */
    public function __construct(
        \Magento\ImportExport\Model\ImportFactory $importModelFactory,
        \Magento\Framework\Filesystem\Directory\ReadFactory $readFactory,
        \Magento\ImportService\Model\Source\TypePool $typePool,
        \Magento\ImportService\Model\Source\FileTypePool $fileTypePool
    ) {
        $this->importModelFactory = $importModelFactory;
        $this->typePool = $typePool;
        $this->fileTypePool = $fileTypePool;
        $this->readFactory = $readFactory;
    }

    /**
     * @inheritdoc
     */
    public function executeImport(ImportEntryInterface $importEntry)
    {
        try {

            //$factory = new SwaggerFactory();
            //$swagger = $factory->build('/var/www/html/bulk-api/async-import/var/schema_swagger.json');
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

            $source = $this->getSource($importEntry);
            while ($source->valid()) {
                $rowData = $source->current();
                $p = 1;
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
        return $source;
    }
}

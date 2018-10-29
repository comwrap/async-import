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
     * @param \Magento\ImportExport\Model\ImportFactory $importModelFactory
     */
    public function __construct(
        \Magento\ImportExport\Model\ImportFactory $importModelFactory
    ) {
        $this->importModelFactory = $importModelFactory;
    }

    /**
     * @inheritdoc
     */
    public function executeImport(ImportEntryInterface $importEntry)
    {
        try {

            $factory = new SwaggerFactory();
            $swagger = $factory->build('/var/www/html/bulk-api/async-import/var/schema_swagger.json');
            $swagger->
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
            $importModel = $this->importModelFactory->create($data);
            $importModel->importSource();

            $importData = $this->prepareData($importEntry);
            $t = 1;
            //$importModel->processImport();
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param \Magento\ImportService\Api\Data\ImportEntryInterface $importEntry
     */
    private function prepareData(ImportEntryInterface $importEntry)
    {
        $importEncodedContent = $importEntry->getContent();
        $importContent = base64_decode($importEncodedContent->getBase64EncodedData());
        $csvContent = str_getcsv($importContent);
        return;
    }
}

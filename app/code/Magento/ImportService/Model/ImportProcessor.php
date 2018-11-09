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
        \Magento\ImportService\Model\Entity\Factory $entityFactory
    ) {
        $this->importModelFactory = $importModelFactory;
        $this->typePool = $typePool;
        $this->fileTypePool = $fileTypePool;
        $this->readFactory = $readFactory;
        $this->importServiceConfig = $importServiceConfig;
        $this->entityFactory = $entityFactory;
    }

    /**
     * @inheritdoc
     */
    public function processImport(ImportEntryInterface $importEntry)
    {
        try {
            $entityAdapter= $this->getEntityAdapter($importEntry);
            $entityAdapter->importData();

            //$factory = new SwaggerFactory();
            //$swagger = $factory->build('/var/www/html/bulk-api/async-import/var/schema_swagger.json');

            return true;

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
            $importParams = $importEntry->getImportParams();
            $entityType = $importParams->getEntityType();
            $behaviour = $importParams->getBehavior();
            $importServiceConfig = $this->importServiceConfig->getEntities();

            $source = $this->getSource($importEntry);
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
     * @return \Magento\ImportService\Model\Entity\AbstractEntity
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getEntityAdapter(ImportEntryInterface $importEntry)
    {
        if (!$this->entityAdapter) {
            /** @var \Magento\ImportService\Api\Data\ImportParamsInterface $importParams */
            $importParams = $importEntry->getImportParams();
            $fieldsMapping = $importEntry->getFieldsMapping();

            $entityType = $importParams->getEntityType();
            $entities = $this->importServiceConfig->getEntities();
            if (isset($entities[$entityType])) {
                try {
                    $this->entityAdapter = $this->entityFactory->create($entities[$entityType]['model']);
                } catch (\Exception $e) {
                    $t=1;
                    throw new \Magento\Framework\Exception\LocalizedException(
                        __('Please enter a correct entity model.')
                    );
                }
                if (!$this->entityAdapter instanceof \Magento\ImportService\Model\Entity\AbstractEntity) {
                    throw new \Magento\Framework\Exception\LocalizedException(
                        __(
                            'The entity adapter object must be an instance of %1 or %2.',
                            \Magento\ImportExport\Model\Import\Entity\AbstractEntity::class,
                            \Magento\ImportExport\Model\Import\AbstractEntity::class
                        )
                    );
                }

                // check for entity codes integrity
                if ($entityType != $this->entityAdapter->getEntityTypeCode()) {
                    throw new \Magento\Framework\Exception\LocalizedException(
                        __('The input entity code is not equal to entity adapter code.')
                    );
                }
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(__('Please enter a correct entity.'));
            }
            $this->entityAdapter->setParameters($importParams);
            $this->entityAdapter->setFieldsMapping($fieldsMapping);
            $source = $this->getSource($importEntry);
            $this->entityAdapter->setSource($source);
        }
        return $this->entityAdapter;
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

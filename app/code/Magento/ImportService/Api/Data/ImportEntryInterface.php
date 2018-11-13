<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface ImportEntryInterface extends ExtensibleDataInterface
{
    const ENTITY_TYPE = 'entity_type';
    const BEHAVIOR = 'behavior';

    /**
     * Import image archive.
     */
    const IMG_ARCHIVE_FILE = 'import_image_archive';

    /**
     * Import images file directory.
     */
    const IMG_FILE_DIR = 'import_images_file_dir';

    /**
     * Allowed errors count field name
     */
    const ALLOWED_ERROR_COUNT = 'allowed_error_count';

    /**
     * Validation startegt field name
     */
    const VALIDATION_STRATEGY = 'validation_strategy';

    /**
     * Import empty attribute value constant.
     */
    const EMPTY_ATTRIBUTE_VALUE_CONSTANT = 'empty_attribute_value_constant';

    /**
     * Import multiple value separator.
     */
    const MULTIPLE_VALUE_SEPARATOR = 'multiple_value_separator';

    /**
     * Import field separator.
     */
    const CSV_SEPARATOR = 'csv_separator';

    /**
     * Allow multiple values wrapping in double quotes for additional
     * attributes.
     */
    const CSV_ENCLOSURE = 'csv_enclosure';

    const CSV_DELIMITER = 'csv_delimeter';

    /**
     * default delimiter for several values in one cell as default for FIELD_FIELD_MULTIPLE_VALUE_SEPARATOR
     */
    const DEFAULT_GLOBAL_MULTI_VALUE_SEPARATOR = ',';

    /**
     * default empty attribute value constant
     */
    const DEFAULT_EMPTY_ATTRIBUTE_VALUE_CONSTANT = '__EMPTY__VALUE__';

    /**#@+
     * Import constants
     */
    const DEFAULT_SIZE = 50;
    const MAX_IMPORT_CHUNKS = 4;
    const IMPORT_HISTORY_DIR = 'import_history/';
    const IMPORT_DIR = 'import/';

    /**
     * Get entity type
     *
     * @return string|null
     */
    public function getEntityType();

    /**
     * Set entity type
     *
     * @param string $entityType
     * @return $this
     */
    public function setEntityType($entityType);

    /**
     * @return string
     */
    public function getBehaviour();

    /**
     * @param $behavior
     * @return string
     */
    public function setBehaviour($behavior);

    /**
     * @return string|null
     */
    public function getImportImageArchive();

    /**
     * @param $importImageArchive
     * @return string
     */
    public function setImportImageArchive($importImageArchive);

    /**
     * @return string|null
     */
    public function getImportImagesFileDir();

    /**
     * @param $importImagesFileDir
     * @return string
     */
    public function setImportImagesFileDir($importImagesFileDir);

    /**
     * @return integer|null
     */
    public function getAllowedErrorCount();

    /**
     * @param $allowedErrorCount
     * @return integer
     */
    public function setAllowedErrorCount($allowedErrorCount);

    /**
     * @return string|null
     */
    public function getValidationStrategy();

    /**
     * @param $validationStrategy
     * @return string
     */
    public function setValidationStrategy($validationStrategy);

    /**
     * @return string|null
     */
    public function getEmptyAttributeValueConstant();

    /**
     * @param $emptyAttributeValueConstant
     * @return string
     */
    public function setEmptyAttributeValueConstant($emptyAttributeValueConstant);

    /**
     * @return string|null
     */
    public function getCsvSeparator();

    /**
     * @param $csvSeparator
     * @return string
     */
    public function setCsvSeparator($csvSeparator);

    /**
     * @return string|null
     */
    public function getCsvEnclosure();

    /**
     * @param $csvEnclosure
     * @return string
     */
    public function setCsvEnclosure($csvEnclosure);

    /**
     * @return string|null
     */
    public function getCsvDelimiter();

    /**
     * @param $csvDelimiter
     * @return string
     */
    public function setCsvDelimiter($csvDelimiter);

    /**
     * @return string|null
     */
    public function getMultipleValueSeparator();

    /**
     * @param $multipleValueSeparator
     * @return string
     */
    public function setMultipleValueSeparator($multipleValueSeparator);
}

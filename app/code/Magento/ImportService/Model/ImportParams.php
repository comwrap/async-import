<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\DataObject;
use Magento\ImportService\Api\Data\ImportParamsInterface;

class ImportParams extends DataObject implements ImportParamsInterface
{

    /**
     * @inheritDoc
     */
    public function getBehavior()
    {
        return $this->getData(self::BEHAVIOR);
    }

    /**
     * @inheritDoc
     */
    public function setBehavior($behavior)
    {
        return $this->setData(self::BEHAVIOR, $behavior);
    }

    /**
     * @inheritDoc
     */
    public function getImportImageArchive()
    {
        return $this->getData(self::IMG_ARCHIVE_FILE);
    }

    /**
     * @inheritDoc
     */
    public function setImportImageArchive($importImageArchive)
    {
        return $this->setData(self::IMG_ARCHIVE_FILE, $importImageArchive);
    }

    /**
     * @inheritDoc
     */
    public function getImportImagesFileDir()
    {
        return $this->getData(self::IMG_FILE_DIR);
    }

    /**
     * @inheritDoc
     */
    public function setImportImagesFileDir($importImagesFileDir)
    {
        return $this->setData(self::IMG_FILE_DIR, $importImagesFileDir);
    }

    /**
     * @inheritDoc
     */
    public function getAllowedErrorCount()
    {
        return $this->getData(self::ALLOWED_ERROR_COUNT);
    }

    /**
     * @inheritDoc
     */
    public function setAllowedErrorCount($allowedErrorCount)
    {
        return $this->setData(self::ALLOWED_ERROR_COUNT, $allowedErrorCount);
    }

    /**
     * @inheritDoc
     */
    public function getValidationStrategy()
    {
        return $this->getData(self::VALIDATION_STRATEGY);
    }

    /**
     * @inheritDoc
     */
    public function setValidationStrategy($validationStrategy)
    {
        return $this->setData(self::VALIDATION_STRATEGY, $validationStrategy);
    }

    /**
     * @inheritDoc
     */
    public function getEmptyAttributeValueConstant()
    {
        return $this->getData(self::EMPTY_ATTRIBUTE_VALUE_CONSTANT);
    }

    /**
     * @inheritDoc
     */
    public function setEmptyAttributeValueConstant($emptyAttributeValueConstant)
    {
        return $this->setData(self::EMPTY_ATTRIBUTE_VALUE_CONSTANT, $emptyAttributeValueConstant);
    }

    /**
     * @inheritDoc
     */
    public function getCsvSeparator()
    {
        return $this->getData(self::CSV_SEPARATOR);
    }

    /**
     * @inheritDoc
     */
    public function setCsvSeparator($csvSeparator)
    {
        return $this->setData(self::CSV_SEPARATOR, $csvSeparator);
    }

    /**
     * @inheritDoc
     */
    public function getCsvEnclosure()
    {
        return $this->getData(self::CSV_ENCLOSURE);
    }

    /**
     * @inheritDoc
     */
    public function setCsvEnclosure($csvEnclosure)
    {
        return $this->setData(self::CSV_ENCLOSURE, $csvEnclosure);
    }

    /**
     * @inheritDoc
     */
    public function getCsvDelimiter()
    {
        return $this->getData(self::CSV_DELIMITER);
    }

    /**
     * @inheritDoc
     */
    public function setCsvDelimiter($csvDelimiter)
    {
        return $this->setData(self::CSV_DELIMITER, $csvDelimiter);
    }

    /**
     * @inheritDoc
     */
    public function getMultipleValueSeparator()
    {
        return $this->getData(self::MULTIPLE_VALUE_SEPARATOR);
    }

    /**
     * @inheritDoc
     */
    public function setMultipleValueSeparator($multipleValueSeparator)
    {
        return $this->setData(self::MULTIPLE_VALUE_SEPARATOR, $multipleValueSeparator);
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceSourceCsv\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvFormatInterface;

/**
 * Class SourceFormat
 */
class SourceCsvFormat extends AbstractModel implements SourceCsvFormatInterface
{
    /**
     * @inheritDoc
     */
    public function getCsvSeparator(): ?string
    {
        return $this->getData(self::CSV_SEPARATOR);
    }

    /**
     * @inheritDoc
     */
    public function setCsvSeparator(string $csvSeparator): SourceCsvFormatInterface
    {
        return $this->setData(self::CSV_SEPARATOR, $csvSeparator);
    }

    /**
     * @inheritDoc
     */
    public function getCsvEnclosure(): ?string
    {
        return $this->getData(self::CSV_ENCLOSURE);
    }

    /**
     * @inheritDoc
     */
    public function setCsvEnclosure(string $csvEnclosure): SourceCsvFormatInterface
    {
        return $this->setData(self::CSV_ENCLOSURE, $csvEnclosure);
    }

    /**
     * @inheritDoc
     */
    public function getCsvDelimiter(): ?string
    {
        return $this->getData(self::CSV_DELIMITER);
    }

    /**
     * @inheritDoc
     */
    public function setCsvDelimiter(string $csvDelimiter): SourceCsvFormatInterface
    {
        return $this->setData(self::CSV_DELIMITER, $csvDelimiter);
    }

    /**
     * @inheritDoc
     */
    public function getMultipleValueSeparator(): ?string
    {
        return $this->getData(self::MULTIPLE_VALUE_SEPARATOR);
    }

    /**
     * @inheritDoc
     */
    public function setMultipleValueSeparator(string $multipleValueSeparator): SourceCsvFormatInterface
    {
        return $this->setData(self::MULTIPLE_VALUE_SEPARATOR, $multipleValueSeparator);
    }

}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
declare(strict_types=1);

namespace Magento\ImportServiceSourceCsvApi\Api\Data;

/**
 * Interface SourceCsvFormatInterface
 */
interface SourceCsvFormatInterface
{
    public const CSV_SEPARATOR = 'csv_separator';
    public const CSV_ENCLOSURE = 'csv_enclosure';
    public const CSV_DELIMITER = 'csv_delimiter';
    public const MULTIPLE_VALUE_SEPARATOR = 'multiple_value_separator';

    public const DEFAULT_CSV_SEPARATOR = ',';
    public const DEFAULT_CSV_ENCLOSURE = '"';
    public const DEFAULT_CSV_DELIMITER = ',';
    public const DEFAULT_MULTIPLE_VALUE_SEPARATOR = '|';

    /**
     * @return string|null
     */
    public function getCsvSeparator(): ?string;

    /**
     * Set CSV Separator
     *
     * @param string $csvSeparator
     *
     * @return \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvFormatInterface
     */
    public function setCsvSeparator(string $csvSeparator): SourceCsvFormatInterface;

    /**
     * @return string|null
     */
    public function getCsvEnclosure(): ?string;

    /**
     * Set CSV Enclosure
     *
     * @param string $csvEnclosure
     *
     * @return \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvFormatInterface
     */
    public function setCsvEnclosure(string $csvEnclosure): SourceCsvFormatInterface;

    /**
     * @return string|null
     */
    public function getCsvDelimiter(): ?string;

    /**
     * Set CSV Delimiter
     *
     * @param string $csvDelimiter
     *
     * @return \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvFormatInterface
     */
    public function setCsvDelimiter(string $csvDelimiter): SourceCsvFormatInterface;

    /**
     * @return string|null
     */
    public function getMultipleValueSeparator(): ?string;

    /**
     * Set Multiple Value Separator
     *
     * @param string $multipleValueSeparator
     *
     * @return \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvFormatInterface
     */
    public function setMultipleValueSeparator(string $multipleValueSeparator): SourceCsvFormatInterface;

}
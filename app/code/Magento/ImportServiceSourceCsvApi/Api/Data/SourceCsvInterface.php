<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection,PhpFullyQualifiedNameUsageInspection
 */
declare(strict_types=1);

namespace Magento\ImportServiceSourceCsvApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface SourceCsvInterface
 */
interface SourceCsvInterface extends ExtensibleDataInterface
{

    /**
     * const CSV_SOURCE_TYPE
     */
    public const CSV_SOURCE_TYPE = 'csv';

    public const ENTITY_ID = 'entity_id';
    public const UUID = 'uuid';
    public const SOURCE_TYPE = 'source_type';
    public const IMPORT_TYPE = 'import_type';
    public const IMPORT_DATA = 'import_data';
    public const FORMAT = 'format';
    public const CREATED_AT = 'created_at';
    public const STATUS = 'status';
    public const STATUS_UPLOADED = 'uploaded';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    /**
     * Retrieve source uuid
     *
     * @return string|null
     */
    public function getUuid(): ?string;

    /**
     * Set data source uuid
     *
     * @param string $uuid
     *
     * @return $this
     */
    public function setUuid(string $uuid): SourceCsvInterface;

    /**
     * Retrieve data source type
     *
     * @return string
     */
    public function getSourceType(): string;

    /**
     * Set data source type
     *
     * @param string $sourceType
     *
     * @return $this
     */
    public function setSourceType(string $sourceType): SourceCsvInterface;

    /**
     * Retrieve Import type
     *
     * @return string
     */
    public function getImportType(): string;

    /**
     * Set Import type
     *
     * @param string $importType
     *
     * @return $this
     */
    public function setImportType(string $importType): SourceCsvInterface;

    /**
     * @return string|null
     */
    public function getStatus(): ?string;

    /**
     * @param string|null $status
     *
     * @return $this
     */
    public function setStatus(?string $status): SourceCsvInterface;

    /**
     * Retrieve Import data
     *
     * @return string
     */
    public function getImportData(): string;

    /**
     * Set Import data
     *
     * @param string $importData
     *
     * @return $this
     */
    public function setImportData(string $importData): SourceCsvInterface;

    /**
     * Retrieve Source Format
     *
     * @return \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvFormatInterface|null
     */
    public function getFormat(): ?SourceCsvFormatInterface;

    /**
     * Set Source Format
     *
     * @param \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvFormatInterface $format
     *
     * @return $this
     */
    public function setFormat(SourceCsvFormatInterface $format): SourceCsvInterface;

    /**
     * Retrieve Import data
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Set Import date
     *
     * @param string|null $date
     *
     * @return SourceCsvInterface
     */
    public function setCreatedAt(?string $date): SourceCsvInterface;

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvExtensionInterface|null
     */
    public function getExtensionAttributes(): ?SourceCsvExtensionInterface;

    /**
     * Set an extension attributes object.
     *
     * @param \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvExtensionInterface $extensionAttributes
     *
     * @return $this
     */
    public function setExtensionAttributes(
        \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvExtensionInterface $extensionAttributes
    ): SourceCsvInterface;
}

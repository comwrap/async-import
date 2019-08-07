<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection,PhpFullyQualifiedNameUsageInspection
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface SourceInterface
 */
interface SourceInterface extends ExtensibleDataInterface
{

    public const ENTITY_ID = 'entity_id';
    public const UUID = 'uuid';
    public const SOURCE_TYPE = 'source_type';
    public const IMPORT_TYPE = 'import_type';
    public const IMPORT_DATA = 'import_data';
    public const CREATED_AT = 'created_at';
    public const STATUS = 'status';

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
    public function setUuid(string $uuid): SourceInterface;

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
    public function setSourceType(string $sourceType): SourceInterface;

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
    public function setImportType(string $importType): SourceInterface;

    /**
     * @return string|null
     */
    public function getStatus(): ?string;

    /**
     * @param string|null $status
     *
     * @return $this
     */
    public function setStatus(?string $status): SourceInterface;

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
    public function setImportData(string $importData): SourceInterface;

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
     * @return SourceInterface
     */
    public function setCreatedAt(?string $date): SourceInterface;

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Magento\ImportServiceApi\Api\Data\SourceExtensionInterface|null
     */
    public function getExtensionAttributes(): ?SourceExtensionInterface;

    /**
     * Set an extension attributes object.
     *
     * @param \Magento\ImportServiceApi\Api\Data\SourceExtensionInterface $extensionAttributes
     *
     * @return $this
     */
    public function setExtensionAttributes(
        \Magento\ImportServiceApi\Api\Data\SourceExtensionInterface $extensionAttributes
    ): SourceInterface;
}

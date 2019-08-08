<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\ImportServiceApi\Api\Data\SourceCsvExtensionInterface;
use Magento\ImportServiceApi\Api\Data\SourceCsvFormatInterface;
use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;
use Magento\ImportService\Model\ResourceModel\Source as SourceResource;
use Magento\ImportService\Model\SourceCsvFormatFactory as FormatFactory;
use Magento\ImportService\Model\SourceBuilderInterface;

/**
 * Class Source
 */
class SourceBuilder extends AbstractExtensibleModel implements SourceBuilderInterface
{
    /**
     * @param array $data
     */
    public function __construct(
        array $data = []
    ) {
        $this->_data = $data;
    }

    /**
     * Source constructor
     */
    protected function _construct()
    {
        $this->_init(SourceResource::class);
    }

    /**
     * @inheritDoc
     */
    public function getUuid(): ?string
    {
        return $this->getData(self::UUID);
    }

    /**
     * @inheritDoc
     */
    public function setUuid(string $uuid): SourceBuilderInterface
    {
        return $this->setData(self::UUID, $uuid);
    }

    /**
     * @inheritDoc
     */
    public function getSourceType(): string
    {
        return $this->getData(self::SOURCE_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setSourceType(string $sourceType): SourceBuilderInterface
    {
        return $this->setData(self::SOURCE_TYPE, $sourceType);
    }

    /**
     * @inheritDoc
     */
    public function getImportType(): string
    {
        return $this->getData(self::IMPORT_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setImportType(string $importType): SourceBuilderInterface
    {
        return $this->setData(self::IMPORT_TYPE, $importType);
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): ?string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus(?string $status): SourceBuilderInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getImportData(): string
    {
        return $this->getData(self::IMPORT_DATA);
    }

    /**
     * @inheritDoc
     */
    public function setImportData(string $importData): SourceBuilderInterface
    {
        return $this->setData(self::IMPORT_DATA, $importData);
    }

    /**
     * @inheritDoc
     */
    public function getFormat(): ?array
    {
        return $this->getData(self::FORMAT);
    }

    /**
     * @inheritDoc
     */
    public function setFormat(array $format): SourceBuilderInterface
    {
        return $this->setData(self::FORMAT, $format);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(?string $date): SourceBuilderInterface
    {
        return $this->setData(self::CREATED_AT, $date);
    }
}

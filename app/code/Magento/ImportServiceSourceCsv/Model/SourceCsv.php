<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceSourceCsv\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvExtensionInterface;
use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvFormatInterface;
use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface;
use Magento\ImportService\Model\ResourceModel\Source as SourceResource;
use Magento\ImportServiceSourceCsv\Model\SourceCsvFormatFactory as FormatFactory;

/**
 * Class Source
 */
class SourceCsv extends AbstractExtensibleModel implements SourceCsvInterface
{
    public const CACHE_TAG = 'magento_import_service_source';

    /**
     * Source format factory
     *
     * @var FormatFactory
     */
    private $formatFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param FormatFactory $formatFactory
     * @param SerializerInterface $serializer
     * @param AbstractResource $resource
     * @param AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        FormatFactory $formatFactory,
        SerializerInterface $serializer,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->formatFactory = $formatFactory;
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );
        $this->serializer = $serializer;
    }

    /**
     * Source constructor
     */
    protected function _construct()
    {
        $this->_init(SourceResource::class);
    }

    /**
     * Get unique page cache identities
     *
     * @return array
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
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
    public function setUuid(string $uuid): SourceCsvInterface
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
    public function setSourceType(string $sourceType): SourceCsvInterface
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
    public function setImportType(string $importType): SourceCsvInterface
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
    public function setStatus(?string $status): SourceCsvInterface
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
    public function setImportData(string $importData): SourceCsvInterface
    {
        return $this->setData(self::IMPORT_DATA, $importData);
    }

    /**
     * @inheritDoc
     */
    public function getFormat(): ?SourceCsvFormatInterface
    {
        return $this->getData(self::FORMAT);
    }

    /**
     * @inheritDoc
     */
    public function setFormat(SourceCsvFormatInterface $format): SourceCsvInterface
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
    public function setCreatedAt(?string $date): SourceCsvInterface
    {
        return $this->setData(self::CREATED_AT, $date);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes(): ?SourceCsvExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensionAttributes(
        SourceCsvExtensionInterface $extensionAttributes
    ): SourceCsvInterface {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function afterLoad()
    {
        $this->decorate();
        parent::afterLoad();
    }

    /**
     * {@inheritdoc}
     */
    public function decorate()
    {
        $formatJson = $this->getData(self::FORMAT);

        if (isset($formatJson)) {

            /** get format json string and decode */
            $formatJson = $this->serializer->unserialize($formatJson);

            /** set decoded json string and object to formatted source */
            $format = $this->formatFactory->create()->setData($formatJson);
            $this->setData(self::FORMAT, $format);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave()
    {
        /** get format object */
        $format = $this->getFormat();

        if (!isset($format)) {
            $data = [
                SourceCsvFormatInterface::CSV_SEPARATOR => SourceCsvFormatInterface::DEFAULT_CSV_SEPARATOR,
                SourceCsvFormatInterface::CSV_ENCLOSURE => SourceCsvFormatInterface::DEFAULT_CSV_ENCLOSURE,
                SourceCsvFormatInterface::CSV_DELIMITER => SourceCsvFormatInterface::DEFAULT_CSV_DELIMITER,
                SourceCsvFormatInterface::MULTIPLE_VALUE_SEPARATOR => SourceCsvFormatInterface::DEFAULT_MULTIPLE_VALUE_SEPARATOR
            ];
            /** create format object and set default values */
            $format = $this->formatFactory->create()->setData($data);
        }

        /** set format json string to format field */
        $this->setData(self::FORMAT, $format->toJson());

        parent::beforeSave();
    }
}

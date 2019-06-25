<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\ImportService\Api\Data\FieldMappingInterface;
use Magento\ImportService\Api\Data\ProcessingRulesRuleInterfaceFactory;
use Magento\ImportService\Api\Data\ProcessingRulesRuleInterface;
use Magento\ImportService\Api\Data\SourceExtensionInterface;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Model\ResourceModel\Source as SourceResource;
use Magento\ImportService\Model\Source\FieldMappingFactory;
use Magento\Store\Model\StoreManager;

/**
 * Class Source
 */
class Source extends AbstractExtensibleModel implements SourceInterface
{
    const CACHE_TAG = 'magento_import_service_source';
    /**
     * @var \Magento\ImportService\Model\Source\FieldMapping
     */
    private $fieldMappingFactory;
    /**
     * @var \Magento\ImportService\Model\ProcessingRulesRuleInterfaceFactory
     */
    private $processingRulesRuleFactory;

    /**
     * Source constructor.
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory
     * @param \Magento\ImportService\Model\Source\FieldMappingFactory $fieldMappingFactory
     * @param \Magento\ImportService\Api\Data\ProcessingRulesRuleInterfaceFactory $processingRulesRuleFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        FieldMappingFactory $fieldMappingFactory,
        ProcessingRulesRuleInterfaceFactory $processingRulesRuleFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->fieldMappingFactory = $fieldMappingFactory;
        $this->processingRulesRuleFactory = $processingRulesRuleFactory;
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $resource, $resourceCollection, $data);
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
    public function getIdentities()
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
    public function setUuid(string $uuid): SourceInterface
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
    public function setSourceType(string $sourceType): SourceInterface
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
    public function setImportType(string $importType): SourceInterface
    {
        return $this->setData(self::IMPORT_TYPE, $importType);
    }

    /**
     * @inheritDoc
     */
    public function getMapping(): ?array
    {
        return $this->getData(self::MAPPING);
    }

    /**
     * @inheritDoc
     */
    public function setMapping(array $mapping = null): SourceInterface
    {
        return $this->setData(self::MAPPING, $mapping);
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus(string $status): SourceInterface
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
    public function setImportData(string $importData): SourceInterface
    {
        return $this->setData(self::IMPORT_DATA, $importData);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $date): SourceInterface
    {
        return $this->setData(self::CREATED_AT, $date);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensionAttributes(SourceExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function afterLoad()
    {
        $mappingJson = $this->getData(self::MAPPING);
        if (isset($mappingJson)) {
            $mapping = $this->convertArrayToMapping(json_decode($mappingJson, true));
            $this->setMapping($mapping);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave()
    {
        $mappingArray = $this->convertMappingToArray($this->getMapping());
        $mappingJson = json_encode($mappingArray);
        $this->setData(self::MAPPING, $mappingJson);

        parent::beforeSave();
    }

    /**
     * @param $mapping
     * @return FieldMappingInterface[]
     */
    private function convertArrayToMapping($mapping)
    {
        $mappings = [];
        foreach ($mapping as $fieldMappingArray) {
            /** @var FieldMappingInterface $fieldMapping */
            $fieldMapping = $this->fieldMappingFactory->create()->setData($fieldMappingArray);

            if (isset($fieldMappingArray[FieldMappingInterface::PROCESSING_RULES])) {
                $processingRulesArray = $fieldMappingArray[FieldMappingInterface::PROCESSING_RULES];
                $rulesArray = [];
                foreach ($processingRulesArray as $rule) {
                    $rulesArray[] = $this->processingRulesRuleFactory->create()->setData($rule);
                }
                $fieldMapping->setProcessingRules($rulesArray);
            }
            $mappings[] = $fieldMapping;
        }
        return $mappings;
    }

    /**
     * @param FieldMappingInterface[]
     * @return array
     */
    private function convertMappingToArray($mapping)
    {
        $mappingArray = [];
        /** @var \Magento\ImportService\Model\Source\FieldMapping $fieldMapping */
        foreach ($mapping as $fieldMapping) {
            $processingRules = $fieldMapping->getProcessingRules();
            $fieldMappingArray = $fieldMapping->toArray();
            if (isset($processingRules)) {
                $rulesArray = [];
                /** @var \Magento\ImportService\Model\Source\ProcessingRulesRule $rule */
                foreach ($processingRules as $rule) {
                    $rulesArray[] = $rule->toArray();
                }
                $fieldMappingArray[FieldMappingInterface::PROCESSING_RULES] = $rulesArray;
            }
            $mappingArray[] = $fieldMappingArray;
        }
        return $mappingArray;
    }
}

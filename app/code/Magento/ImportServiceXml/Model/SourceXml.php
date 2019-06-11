<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceXml\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\ImportService\Api\Data\ProcessingRulesRuleInterfaceFactory;
use Magento\ImportService\Model\Source;
use Magento\ImportService\Model\Source\FieldMappingFactory;
use Magento\ImportServiceXml\Api\Data\SourceXmlInterface;
use Magento\ImportServiceXml\Api\Data\SourceFormatXmlInterface;
use Magento\ImportServiceXml\Api\Data\SourceFormatXmlInterfaceFactory;

/**
 * Class Source
 */
class SourceXml extends Source implements SourceXmlInterface
{
    const SOURCE_EXTENSION = 'csv';
    /**
     * @var \Magento\ImportServiceXml\Api\Data\SourceFormatXmlInterfaceFactory
     */
    private $formatXmlInterfaceFactory;

    /**
     * SourceXml constructor.
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory
     * @param \Magento\ImportService\Model\Source\FieldMappingFactory $fieldMappingFactory
     * @param \Magento\ImportService\Api\Data\ProcessingRulesRuleInterfaceFactory $processingRulesRuleFactory
     * @param \Magento\ImportServiceXml\Api\Data\SourceFormatXmlInterfaceFactory $formatXmlInterfaceFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\ImportService\Model\Source\FieldMappingFactory $fieldMappingFactory,
        \Magento\ImportService\Api\Data\ProcessingRulesRuleInterfaceFactory $processingRulesRuleFactory,
        SourceFormatXmlInterfaceFactory $formatXmlInterfaceFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $fieldMappingFactory, $processingRulesRuleFactory, $resource, $resourceCollection, $data);
        $this->formatXmlInterfaceFactory = $formatXmlInterfaceFactory;
    }

    /**
     * @inheritDoc
     */
    public function getFormat(): ?SourceFormatXmlInterface
    {
        return $this->getData(self::FORMAT);
    }

    /**
     * @inheritDoc
     */
    public function setFormat(SourceFormatXmlInterface $format): SourceXmlInterface
    {
        return $this->setData(self::FORMAT, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function afterLoad()
    {
        $formatJson = $this->getData(self::FORMAT);
        if (isset($formatJson)) {
            $formatData = json_decode($formatJson, true);
            $format = $this->formatXmlInterfaceFactory->create()->setData($formatData);
            $this->setFormat($format);
        }

        parent::afterLoad();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave()
    {
        /** @var \Magento\ImportServiceXml\Model\SourceFormatXml $format */
        $format = $this->getFormat();
        if (isset($format)) {
            $format = $format->toJson();
            $this->setData(self::FORMAT, $format);
        }

        parent::beforeSave();
    }
}

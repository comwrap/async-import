<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\ImportService\Model;

use Magento\Framework\DataObject;
use Magento\ImportService\Api\Data\FieldMappingInterface;

class FieldMapping extends DataObject implements FieldMappingInterface
{
    /**
     * @inheritDoc
     */
    public function getSourceAttribute()
    {
        return $this->getData(self::SOURCE_ATTRIBUTE);
    }

    /**
     * @inheritDoc
     */
    public function setSourceAttribute($sourceAttribute)
    {
        return $this->setData(self::SOURCE_ATTRIBUTE, $sourceAttribute);
    }

    /**
     * @inheritDoc
     */
    public function getDestinationAttribute()
    {
        return $this->getData(self::DESTINATION_ATTRIBUTE);
    }

    /**
     * @inheritDoc
     */
    public function setDestinationAttribute($destinationAttribute)
    {
        return $this->setData(self::DESTINATION_ATTRIBUTE, $destinationAttribute);
    }

    /**
     * @inheritDoc
     */
    public function getProcessingRules()
    {
        return $this->getData(self::PROCESSING_RULES);
    }

    /**
     * @inheritDoc
     */
    public function setProcessingRules($processingRules)
    {
        return $this->setData(self::PROCESSING_RULES, $processingRules);
    }

    /**
     * @inheritDoc
     */
    public function getTaxonomy()
    {
        return $this->getData(self::TAXONOMY);
    }

    /**
     * @inheritDoc
     */
    public function setTaxonomy($taxonomy)
    {
        return $this->setData(self::TAXONOMY, $taxonomy);
    }

    /**
     * @inheritDoc
     */
    public function getValuesMapping()
    {
        return $this->getData(self::VALUES_MAPPING);
    }

    /**
     * @inheritDoc
     */
    public function setValuesMapping($valuesMapping)
    {
        return $this->setData(self::VALUES_MAPPING, $valuesMapping);
    }
}

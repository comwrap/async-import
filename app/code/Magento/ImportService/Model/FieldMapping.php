<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
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
}

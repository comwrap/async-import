<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface FieldMappingInterface extends ExtensibleDataInterface
{
    const SOURCE_ATTRIBUTE = 'source_attribute';
    const DESTINATION_ATTRIBUTE = 'destination_attribute';
    const PROCESSING_RULES = 'processing_rules';
    const VALUES_MAPPING = 'values_mapping';

    /**
     * Retrieve source attribute_code/column
     *
     * @return string
     */
    public function getSourceAttribute();

    /**
     * Set source attribute_code/column
     *
     * @param string $sourceAttribute
     * @return $this
     */
    public function setSourceAttribute($sourceAttribute);

    /**
     * Retrieve destination attribute code
     *
     * @return string
     */
    public function getDestinationAttribute();

    /**
     * Set destination attribute code
     *
     * @param string $destinationAttribute
     * @return $this
     */
    public function setDestinationAttribute($destinationAttribute);

    /**
     * Retrieve rules for processing attribute value, e.g. strtolower, trim
     *
     * @return string|null
     */
    public function getProcessingRules();

    /**
     * Set rules for processing attribute value, e.g. strtolower, trim
     *
     * @param string $processingRules
     * @return $this
     */
    public function setProcessingRules($processingRules);
}

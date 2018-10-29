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
    const TAXONOMY = 'taxonomy';
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

    /**
     * Retrieve taxonomy delimiter. Not a taxonomy if value not provided
     *
     * @return string|null
     */
    public function getTaxonomy();

    /**
     * Set taxonomy delimiter
     *
     * @param string $taxonomy
     * @return $this
     */
    public function setTaxonomy($taxonomy);

    /**
     * Retrieve values mapping, e.g. replace target attribute value "Yes" to "1"
     *
     * @return \Magento\ImportService\Api\Data\ValueMappingInterface[]|null
     */
    public function getValuesMapping();

    /**
     * Set values mapping, e.g. replace target attribute value "Yes" to "1"
     *
     * @param \Magento\ImportService\Api\Data\ValueMappingInterface[] $valuesMapping
     * @return $this
     */
    public function setValuesMapping($valuesMapping);
}

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
    const SOURCE_NAME_PREFIX = 'source';
    const TARGET_NAME_PREFIX = 'target';

    const NAME = 'name';
    const SOURCE_PATH = 'source_path';
    const TARGET_PATH = 'target_path';
    const SOURCE_VALUE = 'source_value';
    const TARGET_VALUE = 'target_value';
    const PROCESSING_RULES = 'processing_rules';

    /**
     * Retrieve name for internal use
     *
     * @return string
     */
    public function getName();

    /**
     * Set name for internal use
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /** product.sku
     * Retrieve Source path to the value
     *
     * @return string|null
     */
    public function getSourcePath();

    /**
     * Set Source path to the value
     *
     * @param string $sourcePath
     * @return $this
     */
    public function setSourcePath($sourcePath);

    /**
     * product.sku_custom|null
     * Retrieve Target path to the value
     *
     * @return string|null
     */
    public function getTargetPath();

    /**
     * Set Target path to the value
     *
     * @param string $targetPath
     * @return $this
     */
    public function setTargetPath($targetPath);

    /**
     * Retrieve value from source_path without processing rules or static data
     * which was set manually to this field (static data will be rewrited by
     * data from source_path if exist)
     *
     * @return mixed|null
     */
    public function getSourceValue();

    /**
     * Set data from source_path or some static data
     *
     * @param mixed $sourceValue
     * @return $this
     */
    public function setSourceValue($sourceValue);

    /**
     * Retrieve value from target_path after processing rules or static data
     * which was set manually to this field (static data will be rewrited by
     * data from source_path if exist)
     *
     * @return mixed|null
     */
    public function getTargetValue();

    /**
     * Set processed data or some static data to target_path
     *
     * @param mixed $targetValue
     * @return $this
     */
    public function setTargetValue($targetValue);

    /**
     * Retrieve rules for processing attribute value, e.g. strtolower, trim
     *
     * @return \Magento\ImportService\Api\Data\ProcessingRulesRuleInterface[]|null
     */
    public function getProcessingRules();

    /**
     * Set rules for processing attribute value, e.g. strtolower, trim
     *
     * @param \Magento\ImportService\Api\Data\ProcessingRulesRuleInterface[] $processingRules
     * @return $this
     */
    public function setProcessingRules($processingRules);
}

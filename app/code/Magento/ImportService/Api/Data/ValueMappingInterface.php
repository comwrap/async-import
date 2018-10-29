<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface ValueMappingInterface extends ExtensibleDataInterface
{
    const OLD_VALUE = 'old_value';
    const NEW_VALUE = 'new_value';
    const TARGET_ATTRIBUTE_PATH = 'target_attribute_path';

    /**
     * Get old value to replace
     *
     * @return string
     */
    public function getOldValue();

    /**
     * Set old value to replace
     *
     * @param string $oldValue
     * @return $this
     */
    public function setOldValue($oldValue);

    /**
     * Get new value to replace
     *
     * @return string
     */
    public function getNewValue();

    /**
     * Set new value to replace
     *
     * @param string $newValue
     * @return $this
     */
    public function setNewValue($newValue);

    /**
     * Get target attribute path to replace value, e.g. product.stock.use_backorders
     *
     * @return string|null
     */
    public function getTargetAttributePath();

    /**
     * Set target attribute path to replace value, e.g. product.stock.use_backorders
     *
     * @param string $targetAttributePath
     * @return $this
     */
    public function setTargetAttributePath($targetAttributePath);

}

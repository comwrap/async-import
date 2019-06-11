<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface ProcessingRulesRuleInterface extends ExtensibleDataInterface
{
    const SORT = 'sort';
    const FUNCTION = 'function';
    const ARGS = 'args';

    /**
     * Retrieve execution postion
     *
     * @return integer|null
     */
    public function getSort();

    /**
     * Set execution postion
     *
     * @param integer|null $sort
     * @return $this
     */
    public function setSort($sort);

    /**
     * Retrieve function name
     *
     * @return string
     */
    public function getFunction();

    /**
     * Set function name
     *
     * @param string $function
     * @return $this
     */
    public function setFunction($function);

    /**
     * Retrieve function arguments
     *
     * @return mixed|null
     */
    public function getArgs();

    /**
     * Set function arguments
     *
     * @param mixed $args
     * @return $this
     */
    public function setArgs($args);
}

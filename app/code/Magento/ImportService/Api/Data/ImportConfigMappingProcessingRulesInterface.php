<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

use Magento\Tests\NamingConvention\true\string;

/**
 * Interface ImportConfigMappingInterface
 */
interface ImportConfigMappingProcessingRulesInterface
{
    const SORT = 'sort';
    const FUNCTION = 'function';
    const args = 'args';

    /**
     * @return string
     */
    public function getSort(): string;

    /**
     * @param string $sort
     */
    public function setSort(string $sort): void;

    /**
     * @return string
     */
    public function getFunction(): string;

    /**
     * @param string $function
     */
    public function setFunction(string $function): void;

    /**
     * @return string
     */
    public function getArgs(): string;

    /**
     * @param string $args
     */
    public function setArgs(string $args): void;
}
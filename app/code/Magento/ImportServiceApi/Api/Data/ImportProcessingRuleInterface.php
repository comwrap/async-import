<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */

declare(strict_types=1);

namespace Magento\ImportServiceApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface ImportProcessingRuleInterface
 */
interface ImportProcessingRuleInterface extends ExtensibleDataInterface
{
    public const SORT = 'sort';
    public const FUNCTION = 'function';
    public const ARGS = 'args';

    /**
     * Retrieve execution position
     *
     * @return integer|null
     */
    public function getSort(): ?int;

    /**
     * Set execution postion
     *
     * @param integer|null $sort
     * @return void
     */
    public function setSort(int $sort): void;

    /**
     * Retrieve function name
     *
     * @return string
     */
    public function getFunction(): ?string;

    /**
     * Set function name
     *
     * @param string $function
     * @return void
     */
    public function setFunction(string $function): void;

    /**
     * Retrieve function arguments
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportProcessingRuleArgumentInterface[]|null
     */
    public function getArgs(): ?array;

    /**
     * Set function arguments
     *
     * @param \Magento\ImportServiceApi\Api\Data\ImportProcessingRuleArgumentInterface[]|null $args
     * @return void
     */
    public function setArgs(?array $args): void;

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Magento\ImportServiceApi\Api\Data\ImportProcessingRuleExtensionInterface|null
     */
    public function getExtensionAttributes(): ?ImportProcessingRuleExtensionInterface;

    /**
     * Set an extension attributes object.
     *
     * @param \Magento\ImportServiceApi\Api\Data\ImportProcessingRuleExtensionInterface $extensionAttributes
     *
     * @return $this
     */
    public function setExtensionAttributes(
        \Magento\ImportServiceApi\Api\Data\ImportProcessingRuleExtensionInterface $extensionAttributes
    ): ImportProcessingRuleInterface;
}

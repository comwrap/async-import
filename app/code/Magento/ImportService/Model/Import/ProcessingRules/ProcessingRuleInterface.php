<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\Import\ProcessingRules;

use Magento\Framework\DataObject;
use Magento\ImportServiceApi\Api\SourceBuilderInterface;

/**
 * @TODO add arguments validation
 */
interface ProcessingRuleInterface
{
    const ARGUMENTS = 'arguments';
    const VALUE = 'value';

    /**
     * Execute rule function
     *
     * @return mixed|null
     */
    public function execute();

    /**
     * @param array $arguments
     * @return ProcessingRuleInterface
     */
    public function setArguments(array $arguments = []);

    /**
     * @return array|null
     */
    public function getArguments();

    /**
     * @param mixed $value
     * @return ProcessingRuleInterface
     */
    public function setValue($value);

    /**
     * @return mixed|null
     */
    public function getValue();
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\ProcessingRules;

use Magento\Framework\DataObject;
use Magento\ImportService\Api\Data\SourceInterface;

/**
 * @TODO add arguments validation
 */
interface ProcessingRuleInterface
{
    const SOURCE = 'source';
    const ARGUMENTS = 'arguments';
    const VALUE = 'value';

    /**
     * Execute rule function
     *
     * @return mixed|null
     */
    public function execute();

    /**
     * @param SourceInterface $source
     * @return ProcessingRuleInterface
     */
    public function setSource(SourceInterface $source);

    /**
     * @return SourceInterface
     */
    public function getSource();

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

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\Import\ProcessingRules;

use Magento\Framework\DataObject;
use Magento\ImportServiceApi\Api\SourceBuilderInterface;

abstract class ProcessingRuleAbstract extends DataObject implements ProcessingRuleInterface
{
    /**
     * @inheritDoc
     */
    public function setSource(SourceBuilderInterface $source)
    {
        return $this->setData(self::SOURCE, $source);
    }

    /**
     * @inheritDoc
     */
    public function getSource()
    {
        return $this->getData(self::SOURCE);
    }

    /**
     * @inheritDoc
     */
    public function setArguments(array $arguments = [])
    {
        return $this->setData(self::ARGUMENTS, $arguments);
    }

    /**
     * @inheritDoc
     */
    public function getArguments()
    {
        return $this->getData(self::ARGUMENTS);
    }

    /**
     * @inheritDoc
     */
    public function setValue($value)
    {
        return $this->setData(self::VALUE, $value);
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->getData(self::VALUE);
    }
}

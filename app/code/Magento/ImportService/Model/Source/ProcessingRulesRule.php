<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\Source;

use Magento\Framework\DataObject;
use Magento\ImportService\Api\Data\ProcessingRulesRuleInterface;

class ProcessingRulesRule extends DataObject implements ProcessingRulesRuleInterface
{
    /**
     * @inheritDoc
     */
    public function getSort()
    {
        return $this->getData(self::SORT);
    }

    /**
     * @inheritDoc
     */
    public function setSort($sort)
    {
        return $this->setData(self::SORT, $sort);
    }

    /**
     * @inheritDoc
     */
    public function getFunction()
    {
        return $this->getData(self::FUNCTION);
    }

    /**
     * @inheritDoc
     */
    public function setFunction($function)
    {
        return $this->setData(self::FUNCTION, $function);
    }

    /**
     * @inheritDoc
     */
    public function getArgs()
    {
        return $this->getData(self::ARGS);
    }

    /**
     * @inheritDoc
     */
    public function setArgs($args)
    {
        return $this->setData(self::ARGS, $args);
    }
}

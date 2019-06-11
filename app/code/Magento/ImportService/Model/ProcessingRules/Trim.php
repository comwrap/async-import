<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\ProcessingRules;

class Trim extends ProcessingRuleAbstract
{
    public function execute()
    {
        $args = $this->getArguments();
        if (isset($args[0])) {
            $result = trim($this->getValue(), $args[0]);
        } else {
            $result = trim($this->getValue());
        }
        return $result;
    }
}

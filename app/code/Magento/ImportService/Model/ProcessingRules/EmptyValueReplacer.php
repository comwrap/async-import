<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\ProcessingRules;

use Magento\Framework\Exception\LocalizedException;

class EmptyValueReplacer extends ProcessingRuleAbstract
{
    public function execute()
    {
        $args = $this->getArguments();
        if (count($args) < 1) {
            throw new LocalizedException(__("emptyValueReplace function required one argument."));
        }
        $value = $this->getValue();
        if (!isset($value) || empty($value) || $value == '') {
            $value = $args[0];
        }
        return $value;
    }
}

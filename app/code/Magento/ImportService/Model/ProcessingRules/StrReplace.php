<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\ProcessingRules;

use Magento\Framework\Exception\LocalizedException;

class StrReplace extends ProcessingRuleAbstract
{
    public function execute()
    {
        $args = $this->getArguments();
        if (count($args) < 2) {
            throw new LocalizedException(__("StrReplace function required two arguments: search and replace."));
        }
        return str_replace($args[0], $args[1], $this->getValue());
    }
}

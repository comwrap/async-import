<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\ProcessingRules\Catalog\Product;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\ImportService\Model\ProcessingRules\ProcessingRuleAbstract;

class Options extends ProcessingRuleAbstract
{
    private $options = [];

    public function execute()
    {
        $args = $this->getArguments();
        if (!isset($args)) {
            $args = [];
        }
        if (array_key_exists(0, $args)) {
            $options = $args[0];
            $this->options = [];
            if (is_array($options)) {
                $this->options = $args[0];
            }
        }

        $value = $this->getValue();
        if (isset($value)) {
            $this->options[] = $this->getValue();
        }
        return $this->options;
    }
}

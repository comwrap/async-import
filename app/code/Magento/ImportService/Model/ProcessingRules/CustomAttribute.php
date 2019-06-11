<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\ProcessingRules;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

class CustomAttribute extends ProcessingRuleAbstract
{
    private $customAttributes = [];

    public function execute()
    {
        $args = $this->getArguments();
        if (empty($args)) {
            throw new LocalizedException(__("CustomAttirbute function required argument 'attributeCode'."));
        }
        $attributeCode = $args[0];
        if (array_key_exists(1, $args)) {
            $customAttributes = $args[1];
            $this->customAttributes = [];
            if (is_array($customAttributes)) {
                $this->customAttributes = $args[1];
            }
        }

        $value = $this->getValue();
        if (isset($value)) {
            $this->customAttributes[] = [
                'attribute_code' => $attributeCode,
                'value' => $this->getValue(),
            ];
        }
        return $this->customAttributes;
    }
}

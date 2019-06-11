<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\ProcessingRules;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

class AddExtensionAttributes extends ProcessingRuleAbstract
{
    private $extensionAttributes = [];

    public function execute()
    {
        $args = $this->getArguments();
        if (empty($args)) {
            throw new LocalizedException(__("addExtensionAttributes function required argument 'attributeCode'."));
        }
        $attributeCode = $args[0];
        if (array_key_exists(1, $args)) {
            $extensionAttributes = $args[1];
            $this->extensionAttributes = [];
            if (is_array($extensionAttributes)) {
                $this->extensionAttributes = $args[1];
            }
        }

        $value = $this->getValue();
        if (isset($value)) {
            $this->extensionAttributes[] = [
                $attributeCode => $this->getValue(),
            ];
        }
        return $this->extensionAttributes;
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\ProcessingRules;

use Magento\Framework\DataObject;
use Magento\ImportService\Api\Data\SourceInterface;

class MagentoWebapiDataResolver extends ProcessingRuleAbstract implements ProcessingRuleInterface
{
    public function execute()
    {
        $args = $this->getData('args');
        return call_user_func_array('trim', $args);
    }
}

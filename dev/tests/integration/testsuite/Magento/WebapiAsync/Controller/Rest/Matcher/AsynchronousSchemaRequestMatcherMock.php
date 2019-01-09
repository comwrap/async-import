<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\WebapiAsync\Controller\Rest\Matcher;

/**
 * Responsible for validating Async and Bulk request if they can be processed by defined processor
 */
class AsynchronousSchemaRequestMatcherMock extends AsynchronousSchemaRequestMatcher
{
    /**
     * @inheritdoc
     */
    public function isMatched(\Magento\Framework\Webapi\Rest\Request $request)
    {
        return true;
    }
}

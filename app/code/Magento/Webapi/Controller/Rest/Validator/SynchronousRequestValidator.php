<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Webapi\Controller\Rest\Validator;

/**
 * REST request processor for synchronous requests
 */
class SynchronousRequestValidator implements RequestValidatorInterface
{
    const PROCESSOR_PATH = "/^\\/V\\d+/";

    /**
     * {@inheritdoc}
     */
    public function canProcess(\Magento\Framework\Webapi\Rest\Request $request)
    {
        if (preg_match(self::PROCESSOR_PATH, $request->getPathInfo()) === 1) {
            return true;
        }
        return false;
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Webapi\Controller\Rest\Validator;

/**
 * REST request validator for synchronous "schema" requests
 */
class SchemaRequestValidator implements RequestValidatorInterface
{

    const PROCESSOR_PATH = 'schema';

    /**
     * {@inheritdoc}
     */
    public function canProcess(\Magento\Framework\Webapi\Rest\Request $request)
    {
        if (strpos(ltrim($request->getPathInfo(), '/'), self::PROCESSOR_PATH) === 0) {
            return true;
        }
        return false;
    }
}

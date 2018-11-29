<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\WebapiAsync\Controller\Rest\Validator;

use Magento\Webapi\Controller\Rest\Validator\RequestValidatorInterface;

/**
 * Responsible for validating Async and Bulk schema requests if swagger have to be delivered
 */
class AsynchronousSchemaRequestValidator implements RequestValidatorInterface
{
    /**
     * Path for accessing Async Rest API schema
     */
    const PROCESSOR_PATH = 'async/schema';
    const BULK_PROCESSOR_PATH = 'async/bulk/schema';

    /**
     * @var string
     */
    private $processorPath;

    /**
     * Initial dependencies
     *
     * @param string $processorPath
     */
    public function __construct(
        $processorPath = self::PROCESSOR_PATH
    ) {
        $this->processorPath = $processorPath;
    }

    /**
     * {@inheritdoc}
     */
    public function canProcess(\Magento\Framework\Webapi\Rest\Request $request)
    {
        if (strpos(ltrim($request->getPathInfo(), '/'), $this->processorPath) === 0) {
            return true;
        }
        return false;
    }

}

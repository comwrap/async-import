<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\WebapiAsync\Controller\Rest\Matcher;

use Magento\Webapi\Controller\Rest\Matcher\RequestMatcherInterface;

/**
 * Responsible for validating Async and Bulk request if they can be processed by defined processor
 */
class AsynchronousRequestMatcher implements RequestMatcherInterface
{
    const PROCESSOR_PATH = "/^\\/async(\\/V.+)/";
    const BULK_PROCESSOR_PATH = "/^\\/async\/bulk(\\/V.+)/";

    /**
     * @var string Regex pattern
     */
    private $processorPath;

    /**
     * Initialize dependencies.
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
    public function isMatched(\Magento\Framework\Webapi\Rest\Request $request)
    {
        if ($request->getHttpMethod() === \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_GET) {
            return false;
        }

        if (preg_match($this->processorPath, $request->getPathInfo()) === 1) {
            return true;
        }
        return false;
    }

}

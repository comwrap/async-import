<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\WebapiAsync\Controller\Rest;

use Magento\Webapi\Model\Rest\Swagger\Generator;
use Magento\Framework\Webapi\Rest\Response as RestResponse;
use Magento\Framework\Webapi\Request;
use Magento\Webapi\Controller\Rest\RequestProcessorInterface;
use Magento\WebapiAsync\Controller\Rest\Matcher\AsynchronousSchemaRequestMatcher;

/**
 * Class AsynchronousSchemaRequestProcessor responsible for processing requests from swagger
 */
class AsynchronousSchemaRequestProcessor implements RequestProcessorInterface
{
    /**
     * Path for accessing Async Rest API schema
     * @deprecated
     */
    const PROCESSOR_PATH = AsynchronousSchemaRequestMatcher::PROCESSOR_PATH;
    /**
     * @deprecated
     */
    const BULK_PROCESSOR_PATH = AsynchronousSchemaRequestMatcher::BULK_PROCESSOR_PATH;

    /**
     * @var \Magento\Webapi\Model\Rest\Swagger\Generator
     */
    private $swaggerGenerator;
    /**
     * @var \Magento\Framework\Webapi\Rest\Response
     */
    private $response;
    /**
     * @var string
     */
    private $processorPath;

    /**
     * Initial dependencies
     *
     * @param \Magento\Webapi\Model\Rest\Swagger\Generator $swaggerGenerator
     * @param \Magento\Framework\Webapi\Rest\Response $response
     * @param string $processorPath
     */
    public function __construct(
        Generator $swaggerGenerator,
        RestResponse $response,
        $processorPath = AsynchronousSchemaRequestMatcher::PROCESSOR_PATH
    ) {
        $this->swaggerGenerator = $swaggerGenerator;
        $this->response = $response;
        $this->processorPath = $processorPath;
    }

    /**
     * @inheritdoc
     */
    public function process(\Magento\Framework\Webapi\Rest\Request $request)
    {
        $requestedServices = $request->getRequestedServices('all');
        $requestedServices = $requestedServices == Request::ALL_SERVICES
            ? $this->swaggerGenerator->getListOfServices()
            : $requestedServices;
        $responseBody = $this->swaggerGenerator->generate(
            $requestedServices,
            $request->getScheme(),
            $request->getHttpHost(),
            $request->getRequestUri()
        );
        $this->response->setBody($responseBody)->setHeader('Content-Type', 'application/json');
    }

    /**
     * @inheritdoc
     */
    public function canProcess(\Magento\Framework\Webapi\Rest\Request $request)
    {
        if (strpos(ltrim($request->getPathInfo(), '/'), $this->processorPath) === 0) {
            return true;
        }
        return false;
    }

    /**
     * Check if current request is a BULK request
     *
     * @param \Magento\Framework\Webapi\Rest\Request $request
     * @return bool
     */
    public function isBulk(\Magento\Framework\Webapi\Rest\Request $request)
    {
        if (strpos(
            // @codingStandardsIgnoreStart
            ltrim($request->getPathInfo(), '/'),
            AsynchronousSchemaRequestMatcher::BULK_PROCESSOR_PATH) === 0
            // @codingStandardsIgnoreEnd
        ) {
            return true;
        }
        return false;
    }
}

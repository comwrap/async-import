<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Webapi\Controller\Rest;

/**
 *  Request Processor Pool
 */
class RequestProcessorPool
{

    /**
     * @var array
     */
    private $requestProcessors;

    /**
     * Initial dependencies
     *
     * @param RequestProcessorInterface[] $requestProcessors
     */
    public function __construct($requestProcessors = [])
    {
        $this->requestProcessors = $requestProcessors;

        foreach ($this->requestProcessors as $key => $processorData) {
            if (!is_object($processorData)) {
                if (!isset($processorData['processor'])) {
                    throw new \InvalidArgumentException("Instance for Processor '{$key}' is not defined");
                }
                if (!isset($processorData['matcher'])) {
                    throw new \InvalidArgumentException("Matcher for Processor '{$key}' is not defined");
                }
            }
        }
    }

    /**
     * @inheritdoc
     *
     * @throws \Magento\Framework\Webapi\Exception
     * return RequestProcessorInterface
     */
    public function getProcessor(\Magento\Framework\Webapi\Rest\Request $request)
    {
        foreach ($this->requestProcessors as $processorData) {

            if (isset($processorData['processor']) && isset($processorData['matcher'])) {
                $requestMatcher = $processorData['matcher'];
                if ($requestMatcher->isMatched($request)) {
                    return $processorData['processor'];
                }
            } elseif (is_object($processorData)) {
                /** Condition was created to keep backward compatibility */
                if ($processorData->canProcess($request)) {
                    return $processorData;
                }
            }
        }
        throw new \Magento\Framework\Webapi\Exception(
            __('Specified request cannot be processed.'),
            0,
            \Magento\Framework\Webapi\Exception::HTTP_BAD_REQUEST
        );
    }
}

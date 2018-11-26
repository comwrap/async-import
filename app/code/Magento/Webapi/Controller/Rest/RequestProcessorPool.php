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
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Initial dependencies
     *
     * @param RequestProcessorInterface[] $requestProcessors
     */
    public function __construct($requestProcessors = [],
                                \Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->requestProcessors = $requestProcessors;
        $this->objectManager = $objectManager;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Magento\Framework\Webapi\Exception
     * return RequestProcessorInterface
     */
    public function getProcessor(\Magento\Framework\Webapi\Rest\Request $request)
    {
        foreach ($this->requestProcessors as $processorData) {

            /**
             * Condition was created to keep backward compatibility
             */
            if (is_object($processorData)) {
                echo get_class($processorData)."<br>";
                if ($processorData->canProcess($request)) {
                    return $processorData;
                }
            } else {
                if (isset($processorData['processor']) && isset($processorData['validator'])) {
                    $requestValidator = $processorData['validator'];
                    if ($requestValidator->canProcess($request)) {
                        return $this->objectManager->create($processorData['processor']);
                    }
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

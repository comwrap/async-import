<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Model\SourceUploadResponseFactory;
use Magento\ImportService\Model\Import\SourceProcessorPool;
use Magento\ImportService\Api\SourceUploadInterface;

/**
 * Class Import
 *
 * @package Magento\ImportService\Model
 */
class SourceUpload implements SourceUploadInterface
{

    /**
     * @var SourceProcessorPool
     */
    private $sourceProcessorPool;

    /**
     * @var SourceUploadResponse
     */
    private $responseFactory;

    /**
     * Import constructor.
     * @param SourceUploadResponseFactory $responseFactory
     * @param SourceProcessorPool $sourceProcessorPool
     */
    public function __construct(
        SourceUploadResponseFactory $responseFactory,
        SourceProcessorPool $sourceProcessorPool
    ) {
        $this->sourceProcessorPool = $sourceProcessorPool;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param SourceInterface $source
     * @return SourceUploadResponseFactory
     */
    public function execute(SourceInterface $source)
    {
        try {
            $processor = $this->sourceProcessorPool->getProcessor($source);
            $response = $this->responseFactory->create();
            $response = $processor->processUpload($source, $response);
        } catch (\Exception $e) {
            $response = $this->responseFactory->createFailure($e->getMessage());
        }
        return $response;
    }
}

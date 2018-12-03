<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\FileEntryInterface;
use Magento\ImportService\Model\ImportResponseFactory as ImportResponse;
use Magento\ImportService\Controller\Import\FilesProcessorPool;
use Magento\ImportService\Model\ImportEntryFactory;
/**
 * Class ImportFile
 *
 * @package Magento\ImportService\Model
 */
class ImportFile implements \Magento\ImportService\Api\ImportFileInterface
{

    /**
     * @var \Magento\ImportService\Controller\Import\FilesProcessorPool
     */
    protected $fileProcessorPool;

    /**
     * @var ImportResponse
     */
    protected $response;

    /**
     * ImportFile constructor.
     * @param ImportResponseFactory $response
     * @param FilesProcessorPool $fileProcessorPool
     */
    public function __construct(
        ImportResponse $response,
        FilesProcessorPool $fileProcessorPool
    ) {
        $this->fileProcessorPool = $fileProcessorPool;
        $this->response = $response->create();
    }

    /**
     * @param FileEntryInterface $fileEntry
     * @return ImportResponse
     */
    public function importFile(FileEntryInterface $fileEntry){

        try {
            $processor = $this->fileProcessorPool->getProcessor($fileEntry);
            $filename = $processor->process($fileEntry);



        } catch (\Exception $e) {
            $this->response->setFailed()->setError($e->getMessage());
        }
        return $this->response;

    }

}

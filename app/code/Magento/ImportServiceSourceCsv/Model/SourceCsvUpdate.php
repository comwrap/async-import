<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceSourceCsv\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface;
use Magento\ImportServiceApi\Api\Data\SourceUploadResponseInterface;
use Magento\ImportServiceSourceCsvApi\Api\SourceCsvRepositoryInterface;
use Magento\ImportServiceSourceCsvApi\Api\SourceCsvUpdateInterface;
use Magento\ImportService\ImportServiceException;
use Magento\ImportServiceApi\Model\SourceUploadResponseFactory;

/**
 * Class SourceCsvUpdate
 */
class SourceCsvUpdate implements SourceCsvUpdateInterface
{
    /**
     * @var SourceUploadResponseFactory
     */
    private $responseFactory;

    /**
     * @var SourceCsvRepositoryInterface
     */
    private $sourceRepository;

    /**
     * @param SourceUploadResponseFactory $responseFactory,
     * @param SourceCsvRepositoryInterface $sourceRepository
     */
    public function __construct(
        SourceUploadResponseFactory $responseFactory,
        SourceCsvRepositoryInterface $sourceRepository
    ) {
        $this->responseFactory = $responseFactory;
        $this->sourceRepository = $sourceRepository;
    }

    /**
     * Update source.
     *
     * @param string $uuid
     * @param SourceCsvInterface $source
     *
     * @return SourceUploadResponse
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function execute(string $uuid, SourceCsvInterface $source): SourceUploadResponseInterface
    {
        $response = $this->responseFactory->create();

        try {
            $sourceToUpdate = $this->sourceRepository->getByUuid($uuid);
            if ($sourceToUpdate->getId()) {
                if ($sourceToUpdate->getSourceType() !== SourceCsvInterface::CSV_SOURCE_TYPE) {
                    throw new ImportServiceException(
                        __('Specified Source type "%1" is wrong.', SourceCsvInterface::CSV_SOURCE_TYPE)
                    );
                }
                $sourceToUpdate->setFormat($source->getFormat());
                $this->sourceRepository->save($sourceToUpdate);
                $source = $this->sourceRepository->getByUuid($uuid);
                $response->setUuid($source->getUuid())->setStatus($source->getStatus());
            } else {
                throw new ImportServiceException(
                    __('Specified uuid "%1" does not exist.', $uuid)
                );
            }
        } catch (ImportServiceException $e) {
            $response = $this->responseFactory->createFailure($e->getMessage());
        }

        return $response;
    }
}

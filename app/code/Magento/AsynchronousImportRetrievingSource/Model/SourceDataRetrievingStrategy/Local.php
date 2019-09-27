<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSource\Model\SourceDataRetrievingStrategy;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataResultInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataResultInterfaceFactory;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Model\RetrieveSourceDataStrategyInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Model\SourceDataValidatorInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemFactory;
use League\Flysystem\Adapter\Local as FlysystemLocal;
use League\Flysystem\Adapter\LocalFactory as FlysystemLocalFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Local strategy for retrieving source data
 */
class Local implements RetrieveSourceDataStrategyInterface
{
    /**
     * @var SourceDataValidatorInterface
     */
    private $sourceDataValidator;

    /**
     * @var RetrievingSourceDataResultInterfaceFactory
     */
    private $retrievingResultFactory;
    /**
     * @var \League\Flysystem\FilesystemFactory
     */
    private $fileSystemFactory;
    /**
     * @var \League\Flysystem\Adapter\LocalFactory
     */
    private $flysystemLocalFactory;

    /**
     * @param \League\Flysystem\FilesystemFactory $fileSystemFactory
     * @param \League\Flysystem\Adapter\LocalFactory $flysystemLocalFactory
     * @param SourceDataValidatorInterface $sourceDataValidator
     * @param RetrievingSourceDataResultInterfaceFactory $retrievingResultFactory
     */
    public function __construct(
        FilesystemFactory $fileSystemFactory,
        FlysystemLocalFactory $flysystemLocalFactory,
        SourceDataValidatorInterface $sourceDataValidator,
        RetrievingSourceDataResultInterfaceFactory $retrievingResultFactory
    ) {
        $this->sourceDataValidator = $sourceDataValidator;
        $this->retrievingResultFactory = $retrievingResultFactory;
        $this->fileSystemFactory = $fileSystemFactory;
        $this->flysystemLocalFactory = $flysystemLocalFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceDataInterface $sourceData): RetrievingSourceDataResultInterface
    {
        $validationResult = $this->sourceDataValidator->validate($sourceData);
        if (!$validationResult->isValid()) {
            return $this->createResult(
                RetrievingSourceDataResultInterface::STATUS_FAILED,
                null,
                $validationResult->getErrors()
            );
        }
        try {
            /** @var \League\Flysystem\Adapter\Local $localAdapter */
            $localAdapter = $this->flysystemLocalFactory->create(['root'=>dirname($sourceData->getSourceData()), 'writeFlags'=>LOCK_SH]);
            /** @var \League\Flysystem\Filesystem $fileSystem */
            $fileSystem = $this->fileSystemFactory->create(['adapter'=>$localAdapter]);
            /** read content from local path */
            $stream = $fileSystem->readStream($sourceData->getSourceData());
            if(!$stream){
                throw new LocalizedException(__('File %1 not found or not readable.', $sourceData->getSourceData()));
            }
        } catch (\Exception $e) {
            return $this->createResult(
                RetrievingSourceDataResultInterface::STATUS_FAILED,
                null,
                [$e->getMessage()]
            );
        }
        $content = stream_get_contents($stream);
        fclose($stream);

        return $this->createResult(RetrievingSourceDataResultInterface::STATUS_SUCCESS, $content);
    }

    /**
     * Create retrieving source data result
     *
     * @param string $status
     * @param string|null $file
     * @param array $errors
     * @return RetrievingSourceDataResultInterface
     */
    private function createResult(
        string $status,
        ?string $file,
        array $errors = []
    ) {
        $data = [
            RetrievingSourceDataResultInterface::STATUS => $status,
            RetrievingSourceDataResultInterface::FILE => $file,
            RetrievingSourceDataResultInterface::ERRORS => $errors,
        ];
        return $this->retrievingResultFactory->create($data);
    }
}

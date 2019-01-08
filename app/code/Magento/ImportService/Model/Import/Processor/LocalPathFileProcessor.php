<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processor;

use Magento\Framework\Filesystem\Io\File;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\Data\SourceUploadResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\ImportService\Api\SourceRepositoryInterface;
use Magento\ImportService\Exception as ImportServiceException;
use Magento\ImportService\Model\Import\SaveSource;

/**
 * CSV files processor for asynchronous import
 */
class LocalPathFileProcessor implements SourceProcessorInterface
{
    /**
     * @var File
     */
    private $fileSystemIo;
    /**
     * @var Filesystem
     */
    private $fileSystem;
    /**
     * @var WriteInterface
     */
    private $directoryWrite;
    /**
     * @var \Magento\ImportService\Api\SourceRepositoryInterface
     */
    private $sourceRepository;

    /**
     * LocalPathFileProcessor constructor.
     *
     * @param File $fileSystemIo
     * @param Filesystem $fileSystem
     * @param \Magento\ImportService\Api\SourceRepositoryInterface $sourceRepository
     */
    public function __construct(
        File $fileSystemIo,
        Filesystem $fileSystem,
        SourceRepositoryInterface $sourceRepository
    ) {
        $this->fileSystemIo = $fileSystemIo;
        $this->fileSystem = $fileSystem;
        $this->sourceRepository = $sourceRepository;
    }

    /**
     *  {@inheritdoc}
     */
    public function processUpload(SourceInterface $source, SourceUploadResponseInterface $response)
    {
        try {
            $source->setImportData($this->saveFile($source));
            $source->setStatus(SourceInterface::STATUS_UPLOADED);
            $source = $this->sourceRepository->save($source);
        } catch (CouldNotSaveException $e) {
            $this->removeFile($source->getImportData());
            throw new ImportServiceException(__($e->getMessage()));
        }

        $response->setStatus(SourceUploadResponseInterface::STATUS_UPLOADED);
        $response->setSourceId($source->getSourceId());
        return $response;
    }

    /**
     * @param SourceInterface $source
     * @return string
     * @throws FileSystemException
     */
    private function saveFile(SourceInterface $source)
    {
        $filePath = $this->getDirectoryWrite()->getRelativePath($source->getImportData());
        $newFile = self::IMPORT_SOURCE_FILE_PATH . '/' . uniqid() . '_' . time() . '.' . $source->getSourceType();
        $this->directoryWrite->copyFile($filePath, $newFile);
        return $this->getDirectoryWrite()->getAbsolutePath($newFile);
    }

    /**
     * @param string $filename
     * @throws FileSystemException
     */
    private function removeFile($filename)
    {
        $this->getDirectoryWrite()->delete($filename);
    }

    /**
     * @return WriteInterface
     * @throws FileSystemException
     */
    private function getDirectoryWrite()
    {
        if (!$this->directoryWrite) {
            $this->directoryWrite = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);
        }
        return $this->directoryWrite;
    }
}

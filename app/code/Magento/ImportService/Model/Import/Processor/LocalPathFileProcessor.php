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
use Magento\Framework\Filesystem;
use Magento\ImportService\Model\Import\SourceTypePool;

/**
 * CSV files processor for asynchronous import
 */
class LocalPathFileProcessor implements SourceProcessorInterface
{
    /**
     * Import Type
     */
    const IMPORT_TYPE = 'local_path';

    /**
     * @var PersistentSourceProcessor
     */
    private $persistantUploader;

    /**
     * @var File
     */
    private $fileSystemIo;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * LocalPathFileProcessor constructor
     *
     * @param PersistentSourceProcessor $persistantUploader
     * @param File $fileSystemIo
     * @param Filesystem $fileSystem
     */
    public function __construct(
        PersistentSourceProcessor $persistantUploader,
        File $fileSystemIo,
        Filesystem $fileSystem
    ) {
        $this->persistantUploader = $persistantUploader;
        $this->fileSystemIo = $fileSystemIo;
        $this->fileSystem = $fileSystem;
    }

    /**
     *  {@inheritdoc}
     */
    public function processUpload(SourceInterface $source, SourceUploadResponseInterface $response)
    {
        /** @var \Magento\Framework\Filesystem\Directory\Write $write */
        $write = $this->fileSystem->getDirectoryWrite(DirectoryList::ROOT);

        /** create absolute path */
        $absoluteSourcePath = $write->getAbsolutePath($source->getImportData());

        /** read content from system */
        $content = $this->fileSystemIo->read($absoluteSourcePath);

        /** Set downloaded data */
        $source->setImportData($content);

        /** process source and get response details */
        return $this->persistantUploader->processUpload($source, $response);
    }
}

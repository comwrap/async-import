<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Controller\Import;
use Magento\Framework\Filesystem\Io\File;

/**
 * CSV files processor for asynchronous import
 */
class LocalPathFileProcessor implements FileProcessorInterface
{

    /**
     *
     * @var \Magento\Framework\Filesystem\Io\File
     */
    protected $fileSystemIo;

    /**
     * Initial dependencies
     */
    public function __construct(
        File $fileSystemIo
    ) {
        $this->fileSystemIo = $fileSystemIo;
    }

    /**
     *  {@inheritdoc}
     */
    public function process(\Magento\ImportService\Api\Data\FileEntryInterface $fileEntry)
    {

        $this->validateSource($fileEntry);
        return "filename.csv";

    }

    public function validateSource($fileEntry){

        if (!$this->fileSystemIo->read($fileEntry)){
            throw new \Magento\ImportService\Exception(
                __("Cannot read from file system. File not existed or cannot be read")
            );
        }

    }

}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Controller\Import;

/**
 *  File Processor Pool
 */
class FilesProcessorPool
{

    /**
     * @var array
     */
    private $fileProcessors;

    /**
     * Initial dependencies
     *
     * @param FileProcessorInterface[] $fileProcessors
     */
    public function __construct($fileProcessors = [],
                                \Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->fileProcessors = $fileProcessors;
        $this->objectManager = $objectManager;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Magento\ImportService\Exception
     * return RequestProcessorInterface
     */
    public function getProcessor(\Magento\ImportService\Api\Data\FileEntryInterface $fileEntry)
    {
        foreach ($this->fileProcessors as $key=>$processor) {
            if ($key === $fileEntry->getSource()->getFileType()){
                return $this->objectManager->create($processor);
            }
        }

        throw new \Magento\ImportService\Exception(
            __('Specified request cannot be processed.')
        );
    }
}

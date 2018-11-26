<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Controller\Import;

/**
 * CSV files processor for asynchronous import
 */
class CsvFileProcessor implements FileProcessorInterface
{

    /**
     * Initial dependencies
     */
    public function __construct(
    ) {
    }

    /**
     *  {@inheritdoc}
     */
    public function process(\Magento\ImportService\Api\Data\FileEntryInterface $fileEntry)
    {

    }

}

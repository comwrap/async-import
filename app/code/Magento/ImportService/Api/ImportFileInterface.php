<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

use Magento\ImportService\Api\Data\FileEntryInterface;

/**
 * Class ImportProcessor
 *
 * @package Magento\ImportService\Model
 */
interface ImportFileInterface
{

    /**
     * Run import.
     *
     * @param \Magento\ImportService\Api\Data\FileEntryInterface $importEntry
     * @return \Magento\ImportService\Api\Data\ImportResponseInterface
     */
    public function importFile(FileEntryInterface $fileEntry);
}

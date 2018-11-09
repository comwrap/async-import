<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

use Magento\ImportService\Api\Data\ImportEntryInterface;

/**
 * Class ImportProcessor
 *
 * @package Magento\ImportService\Model
 */
interface ImportProcessorInterface
{

    /**
     * Run import.
     *
     * @param \Magento\ImportService\Api\Data\ImportEntryInterface $importEntry
     * @return bool
     */
    public function processImport(ImportEntryInterface $importEntry);
}

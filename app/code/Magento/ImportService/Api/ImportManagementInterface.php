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
 * @package Magento\ImportServiceBack\Model
 */
interface ImportManagementInterface
{

    /**
     * @param ImportEntryInterface $importEntry
     * @return mixed
     */
    public function start($importEntry);
}

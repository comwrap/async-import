<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Command;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Validation\ValidationException;
use Magento\ImportService\Api\Data\SourceInterface;

/**
 * Save source data command
 *
 * Separate command interface to which Repository proxies initial Save call
 *
 * @see \Magento\ImportService\Api\SourceRepositoryInterface
 */
interface SaveInterface
{
    /**
     * Save source data
     *
     * @param SourceInterface $source
     * @return SourceInterface
     * @throws CouldNotSaveException
     */
    public function execute(SourceInterface $source): SourceInterface;
}

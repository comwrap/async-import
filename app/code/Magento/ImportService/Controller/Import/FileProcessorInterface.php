<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Controller\Import;

/**
 *  Request processor interface
 */
interface FileProcessorInterface
{
    /**
     * Executes the logic to process the request
     *
     * @param \Magento\ImportService\Api\Data\FileEntryInterface $fileEntry
     * @return void
     * @throws \Magento\Framework\Exception\AuthorizationException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Webapi\Exception
     */
    public function process(\Magento\ImportService\Api\Data\FileEntryInterface $fileEntry);

}

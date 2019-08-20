<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import;
use Magento\ImportServiceApi\Api\Data\ImportConfigInterface;
use Magento\ImportService\Model\Import\Processors\ImportProcessorInterface;

/**
 *  ImportProcessorsPoolInterface
 */
interface ImportProcessorsPoolInterface
{
    /**
     * @param ImportConfigInterface $importConfig
     * @return string
     */
    public function getProcessor(ImportConfigInterface $importConfig): ImportProcessorInterface;

}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Processors;

use Magento\ImportServiceApi\Model\ImportStartResponse;

/**
 * Processor interface for process import
 */
interface ImportProcessorInterface
{

    /**
     * Construct of ImportProcessorInterface interface
     *
     * @param array $mappingItemsList
     * @param ImportStartResponse $importResponse

     * @return ImportStartResponse
     */
    public function process(
        array $mappingItemsList,
        ImportStartResponse $importResponse
    ): ImportStartResponse;

}
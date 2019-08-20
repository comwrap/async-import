<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Exchange;

use Magento\ImportServiceApi\Api\SourceBuilderInterface;
use Magento\ImportServiceApi\Api\Data\ImportConfigInterface;
use Magento\ImportServiceApi\Model\ImportStartResponse;

/**
 *  Storage Processor Interface
 */
interface ExchangeProcessorInterface
{

    /**
     * @param array $mappingItemsList
     * @param ImportConfigInterface $importConfig
     * @param SourceBuilderInterface $source
     * @param ImportStartResponseFactory $importResponse
     *
     * @return ImportStartResponseFactory
     */
    public function process(array $mappingItemsList, ImportConfigInterface $importConfig, ImportStartResponse $importResponse): ImportStartResponse;

}

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
use Magento\ImportService\Model\Import\ImportProcessorsPool;

/**
 * Class Start
 */
class AmqpProcessor implements ExchangeProcessorInterface
{

    /**
     * @var MassSchedule
     */
    private $massSchedule;

    /**
     * @var ImportProcessorsPool
     */
    private $importProcessorsPool;

    public function __construct(
        ImportProcessorsPool $importProcessorsPool,
        MassSchedule $massSchedule
    )
    {
        $this->importProcessorsPool = $importProcessorsPool;
        $this->massSchedule = $massSchedule;
    }


    /**
     * @param array $mappingItemsList
     * @param ImportConfigInterface $importConfig
     * @param SourceBuilderInterface $source
     * @param ImportStartResponseFactory $importResponse
     *
     * @return ImportStartResponseFactory
     */
    public function process(
        array $mappingItemsList,
        ImportConfigInterface $importConfig,
        ImportStartResponse $importResponse
    ): ImportStartResponse{

        $processor = $this->importProcessorsPool->getProcessor($importConfig);
        $processor->process($mappingItemsList, $importResponse);

//        $this->massSchedule->publishMass(
//            $topic,
//            $requestItems,
//            null,
//            0
//        );

        /**
         * @TODO implement import to storage. Dummy class for now
         */
        return $importResponse;

    }
}
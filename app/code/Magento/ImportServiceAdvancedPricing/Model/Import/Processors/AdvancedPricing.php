<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceAdvancedPricing\Model\Import\Processors;

use Magento\ImportService\Model\Import\Processors\ImportProcessorInterface;
use Magento\ImportServiceApi\Model\ImportStartResponse;
use Magento\Catalog\Api\TierPriceStorageInterface;
use Magento\Framework\Webapi\ServiceInputProcessor;
use Magento\AsynchronousOperations\Model\MassSchedule;
use Magento\ImportServiceApi\Api\Data\ImportMappingInterface;
use Magento\ImportService\Model\Import\Resolver\JsonPathResolver;

class AdvancedPricing implements ImportProcessorInterface
{

    public const BULK_API_TOPIC_NAME = "async.magento.catalog.api.tierpricestorageinterface.update.post";

    /**
     * @var MassSchedule
     */
    private $massSchedule;

    /**
     * @var TierPriceStorageInterface
     */
    private $priceStorage;

    /**
     * @var JsonPathResolver
     */
    private $jsonResolver;

    /**
     * @var ServiceInputProcessor
     */
    private $serviceInputProcessor;

    public function __construct(
        TierPriceStorageInterface $priceStorage,
        ServiceInputProcessor $inputProcessor,
        MassSchedule $massSchedule,
        JsonPathResolver $jsonPathResolver
    ) {
        $this->priceStorage = $priceStorage;
        $this->serviceInputProcessor = $inputProcessor;
        $this->massSchedule = $massSchedule;
        $this->jsonResolver = $jsonPathResolver;
    }

    /**
     * @param array $mappingItemsList
     * @param ImportStartResponse $importResponse
     *
     * @return ImportStartResponse
     */
    public function process(
        array $mappingItemsList,
        ImportStartResponse $importResponse
    ): ImportStartResponse {

        $requestItems = [];
        $requestItems['prices'] = [];
        foreach ($mappingItemsList as $importLine) {
            $itemData = [];
            foreach ($importLine as $element){
                $itemData = $this->jsonResolver->set($itemData, $element->getTargetPath(), $element->getTargetValue());
            }
            $requestItems['prices'][] = $itemData;
        }

        $inputParams = $this->serviceInputProcessor->process("Magento\Catalog\Api\TierPriceStorageInterface", "update", $requestItems);
        $this->massSchedule->publishMass(
            self::BULK_API_TOPIC_NAME,
            [0 => $inputParams],
            null,
            0
        );

        return $importResponse;
    }

}
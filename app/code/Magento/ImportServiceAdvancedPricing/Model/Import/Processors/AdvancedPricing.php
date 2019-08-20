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
     * @var ServiceInputProcessor
     */
    private $serviceInputProcessor;

    public function __construct(
        TierPriceStorageInterface $priceStorage,
        ServiceInputProcessor $inputProcessor,
        MassSchedule $massSchedule
    ) {
        $this->priceStorage = $priceStorage;
        $this->serviceInputProcessor = $inputProcessor;
        $this->massSchedule = $massSchedule;
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
            $requestItem = [];
            foreach ($importLine as $element){
                $requestItem[$element->getTargetPath()] = $element->getSourceValue();
            }
            $requestItems['prices'][] = $requestItem;
        }

        $inputParams = $this->serviceInputProcessor->process("Magento\Catalog\Api\TierPriceStorageInterface", "update", $requestItems);
var_dump($inputParams);
exit;

//        $serviceMethodName = "update";


        var_dump($requestItems);
        exit;


        echo "a";
        exit;

    }

}
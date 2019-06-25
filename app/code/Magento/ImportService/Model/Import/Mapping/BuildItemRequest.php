<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Mapping;

/**
 *  Source Processor Pool
 */
class BuildItemRequest
{

    public function execute($processedMappedItem, $mappingTargetProcessor)
    {

        $itemData = null;
        foreach ($processedMappedItem as $fieldMapping) {
            $itemData = $mappingTargetProcessor->set($itemData, $fieldMapping->getTargetPath(), $fieldMapping->getTargetValue());
        }
        return $itemData;
    }

}
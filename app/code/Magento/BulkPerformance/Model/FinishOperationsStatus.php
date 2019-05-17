<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\BulkPerformance\Model;

use Magento\Framework\Exception\NoSuchEntityException;

use Magento\BulkPerformance\Api\FinishStatusInterface;
use Magento\AsynchronousOperations\Model\ResourceModel\Operation\CollectionFactory;

/**
 * Class BulkStatus
 */
class FinishOperationsStatus implements FinishStatusInterface
{
    /**
     * @var CollectionFactory
     */
    private $operationCollectionFactory;

    /**
     * Init dependencies.
     *
     * @param CollectionFactory $operationCollection
     */
    public function __construct(
        CollectionFactory $operationCollection
    ) {
        $this->operationCollectionFactory = $operationCollection;
    }

    /**
     * @inheritDoc
     */
    public function getFinishInformation($bulkUuid)
    {
        $operations = $this->operationCollectionFactory->create()->addFieldToFilter('bulk_uuid', $bulkUuid)->getItems();
        return $operations;
    }

}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\BulkPerformance\Api;

/**
 * Interface FinishStatusInterface.
 *
 * Bulk summary data with information about finished operations
 *
 * @api
 */
interface FinishStatusInterface
{
    /**
     * Get summary data with information about finished operations.
     *
     * @param string $bulkUuid
     * @return \Magento\BulkPerformance\Api\Data\OperationInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getFinishInformation(string $bulkUuid): array;

}

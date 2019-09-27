<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AsynchronousImportRetrievingSourceApi\Api;

use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\SourceDataInterface;
use Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataResultInterface;

/**
 * Retrieve source data operation. Uses differect strategies for source data retrieving
 *
 * Used fully qualified namespaces in annotations for proper work of WebApi request parser
 *
 * @api
 */
interface RetrieveSourceDataInterface
{
    /**
     * Retrieve source data operation. Uses different strategies for source data retrieving
     *
     * @param SourceDataInterface $sourceData
     * @return \Magento\AsynchronousImportRetrievingSourceApi\Api\Data\RetrievingSourceDataResultInterface
     * @throws RetrievingSourceException
     */
    public function execute(SourceDataInterface $sourceData): RetrievingSourceDataResultInterface;
}

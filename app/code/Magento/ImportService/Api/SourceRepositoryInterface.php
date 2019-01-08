<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface SourceRepositoryInterface
{
    /**
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return \Magento\ImportService\Api\Data\SourceInterface
     */
    public function save(SourceInterface $source);

    /**
     * @param int $id
     * @return \Magento\ImportService\Api\Data\SourceInterface
     */
    public function getById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Magento\ImportService\Api\Data\SourceSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria);

    /**
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return bool
     */
    public function delete(SourceInterface $source);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id);
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceSourceCsvApi\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface SourceCsvRepositoryInterface
 */
interface SourceCsvRepositoryInterface
{
    /**
     * Save source data
     *
     * @param \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface $source
     * @return \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface
     * @throws CouldNotSaveException
     */
    public function save(SourceCsvInterface $source): SourceCsvInterface;

    /**
     * Get source data by given uuid
     *
     * @param string $uuid
     * @return \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface
     * @throws NoSuchEntityException
     */
    public function getByUuid(string $uuid): SourceCsvInterface;

    /**
     * Find sources by given search criteria. Search criteria is not required.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface;

    /**
     * Delete the source by uuid. If source is not found, NoSuchEntityException is thrown
     *
     * @param string $uuid
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteByUuid(string $uuid): void;
}

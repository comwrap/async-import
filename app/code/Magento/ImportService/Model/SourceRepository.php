<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\SourceRepositoryInterface;
use Magento\ImportService\Model\ResourceModel\Source as SourceResourceModel;
use Magento\ImportService\Model\Source\Command\SaveInterface;
use Magento\ImportService\Model\Source\Command\GetInterface;
use Magento\ImportService\Model\Source\Command\GetListInterface;
use Magento\ImportService\Model\Source\Command\DeleteByUuidInterface;

/**
 * Class SourceRepository
 */
class SourceRepository implements SourceRepositoryInterface
{
    /**
     * @var SourceResourceModel
     */
    private $sourceResourceModel;

    /**
     * @var GetListInterface
     */
    private $commandGetList;

    /*
     * @var DeleteByUuidInterface
     */
    private $commandDeleteByUuid;

    /**
     * @var GetInterface
     */
    private $commandGet;

    /**
     * @var SaveInterface
     */
    private $commandSave;

    /**
     * @param SourceResourceModel $sourceResourceModel
     * @param SaveInterface $commandSave
     * @param GetListInterface $commandGetList
     * @param DeleteByUuidInterface $commandDeleteByUuid
     * @param GetInterface $commandGet
     */
    public function __construct(
        SourceResourceModel $sourceResourceModel,
        SaveInterface $commandSave,
        GetListInterface $commandGetList,
        DeleteByUuidInterface $commandDeleteByUuid,
        GetInterface $commandGet
    ) {
        $this->sourceResourceModel  = $sourceResourceModel;
        $this->commandSave = $commandSave;
        $this->commandGetList = $commandGetList;
        $this->commandDeleteByUuid = $commandDeleteByUuid;
        $this->commandGet = $commandGet;
    }

    /**
     * @inheritdoc
     */
    public function save(SourceInterface $source): SourceInterface
    {
        return $this->commandSave->execute($source);
    }

    /**
     * @inheritdoc
     */
    public function getByUuid(string $uuid): SourceInterface
    {
        return $this->commandGet->execute($uuid);
    }

    /**
     * @inheritdoc
     *
     * @throws CouldNotDeleteException
     */
    public function delete(SourceInterface $source)
    {
        try {
            /** @var \Magento\Framework\Model\AbstractModel|SourceInterface $source */
            $this->sourceResourceModel->delete($source);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function deleteByUuid(string $uuid): void
    {
        $this->commandDeleteByUuid->execute($uuid);
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface
    {
        return $this->commandGetList->execute($searchCriteria);
    }
}

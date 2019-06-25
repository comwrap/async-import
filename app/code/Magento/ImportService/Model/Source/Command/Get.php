<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Command;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\Data\SourceInterfaceFactory;
use Magento\ImportService\Model\ResourceModel\Source as SourceResourceModel;

/**
 * @inheritdoc
 */
class Get implements GetInterface
{
    /**
     * @var SourceInterfaceFactory
     */
    private $sourceFactory;

    /**
     * @var SourceResourceModel
     */
    private $sourceResource;

    /**
     * @param SourceInterfaceFactory $sourceFactory
     * @param SourceResourceModel $sourceResource
     */
    public function __construct(
        SourceInterfaceFactory $sourceFactory,
        SourceResourceModel $sourceResource
    ) {
        $this->sourceFactory = $sourceFactory;
        $this->sourceResource = $sourceResource;
    }

    /**
     * @inheritdoc
     */
    public function execute(string $uuid): SourceInterface
    {
        /** @var SourceInterface $source */
        $source = $this->sourceFactory->create();
        $this->sourceResource->load($source, $uuid, SourceInterface::UUID);

        if (null === $source->getUuid()) {
            throw new NoSuchEntityException(__('Source with uuid "%value" does not exist.', ['value' => $uuid]));
        }
        return $source;
    }
}

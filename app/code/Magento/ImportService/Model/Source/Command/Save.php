<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Command;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Model\ResourceModel\Source as SourceResourceModel;

/**
 * @inheritdoc
 */
class Save implements SaveInterface
{
    /**
     * @var SourceResourceModel
     */
    private $sourceResource;

    /**
     * @param SourceResourceModel $sourceResource
     */
    public function __construct(
        SourceResourceModel $sourceResource
    ) {
        $this->sourceResource = $sourceResource;
    }

    /**
     * @inheritdoc
     */
    public function execute(SourceInterface $source): SourceInterface
    {
        try {
            $this->sourceResource->save($source);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $source;
    }
}

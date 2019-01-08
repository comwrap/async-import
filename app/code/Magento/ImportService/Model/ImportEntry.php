<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\ImportService\Api\Data\ImportEntryInterface;

class ImportEntry extends AbstractExtensibleModel implements ImportEntryInterface
{

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getProfileCode()
    {
        return $this->getData(self::PROFILE_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setProfileCode($profileCode)
    {
        return $this->setData(self::PROFILE_CODE, $profileCode);
    }

    /**
     * @inheritDoc
     */
    public function getSourceId()
    {
        return $this->getData(self::SOURCE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setSourceId($sourceId)
    {
        return $this->setData(self::SOURCE_ID, $sourceId);
    }

}

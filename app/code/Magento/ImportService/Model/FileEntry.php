<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\ImportService\Model;

use Magento\Framework\DataObject;
use Magento\ImportService\Api\Data\FileEntryInterface;

class FileEntry extends DataObject implements FileEntryInterface
{

    /**
     * @inheritDoc
     */
    public function getFileId()
    {
        return $this->getData(self::FILE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setFileId($fileId)
    {
        return $this->setData(self::FILE_ID, $fileId);
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
    public function getSource()
    {
        return $this->getData(self::SOURCE);
    }

    /**
     * @inheritDoc
     */
    public function setSource($source)
    {
        return $this->setData(self::SOURCE, $source);
    }

}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\DataObject;
use Magento\ImportService\Api\Data\SourceInterface;

class Source extends DataObject implements SourceInterface
{
    /**
     * @inheritDoc
     */
    public function getSourceType()
    {
        return $this->getData(self::SOURCE_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setSourceType($sourceType)
    {
        return $this->setData(self::SOURCE_TYPE, $sourceType);
    }


    /**
     * @inheritDoc
     */
    public function getFileType()
    {
        return $this->getData(self::FILE_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setFileType($fileType)
    {
        return $this->setData(self::FILE_TYPE, $fileType);
    }


    /**
     * @inheritDoc
     */
    public function getBase64EncodedData()
    {
        return $this->getData(self::BASE64_ENCODED_DATA);
    }

    /**
     * @inheritDoc
     */
    public function setBase64EncodedData($data)
    {
        return $this->setData(self::BASE64_ENCODED_DATA, $data);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }
}

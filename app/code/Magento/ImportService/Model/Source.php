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
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
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
    public function getImportData()
    {
        return $this->getData(self::IMPORT_DATA);
    }

    /**
     * @inheritDoc
     */
    public function setImportData($importData)
    {
        return $this->setData(self::IMPORT_DATA, $importData);
    }
}

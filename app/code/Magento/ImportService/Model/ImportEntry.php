<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\ImportService\Model;

use Magento\Framework\DataObject;
use Magento\ImportService\Api\Data\ImportEntryInterface;

class ImportEntry extends DataObject implements ImportEntryInterface
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
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @inheritDoc
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * @inheritDoc
     */
    public function getParams()
    {
        return $this->getData(self::PARAMS);
    }

    /**
     * @inheritDoc
     */
    public function setParams($params)
    {
        return $this->setData(self::PARAMS, $params);
    }
}

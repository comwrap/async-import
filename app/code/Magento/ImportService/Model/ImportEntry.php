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

    /**
     * @inheritDoc
     */
    public function getImportParams()
    {
        return $this->getData(self::IMPORT_PARAMS);
    }

    /**
     * @inheritDoc
     */
    public function setImportParams($importParams)
    {
        return $this->setData(self::IMPORT_PARAMS, $importParams);
    }

    /**
     * @inheritDoc
     */
    public function getFieldsMapping()
    {
        return $this->getData(self::FIELDS_MAPPING);
    }

    /**
     * @inheritDoc
     */
    public function setFieldsMapping($fieldsMapping)
    {
        return $this->setData(self::FIELDS_MAPPING, $fieldsMapping);
    }
}

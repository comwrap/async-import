<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\ImportService\Api\Data\FormatInterface;

class Format extends AbstractExtensibleModel implements FormatInterface
{
    /**
     * @inheritDoc
     */
    public function getCode()
    {
        return $this->getData(self::CODE);
    }

    /**
     * @inheritDoc
     */
    public function setCode($code)
    {
        return $this->setData(self::CODE, $code);
    }

    /**
     * @inheritDoc
     */
    public function getBehaviour()
    {
        return $this->getData(self::BEHAVIOUR);
    }

    /**
     * @inheritDoc
     */
    public function setBehaviour($behaviour)
    {
        return $this->setData(self::BEHAVIOUR, $behaviour);
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

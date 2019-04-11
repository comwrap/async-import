<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface FormatInterface extends ExtensibleDataInterface
{
    const CODE = 'code';
    const BEHAVIOUR = 'behaviour';
    const FIELDS_MAPPING = 'fields_mapping';

    /**
     * Retrieve profile code
     *
     * @return string|null
     */
    public function getCode();

    /**
     * Set profile code
     *
     * @param string|null $code
     * @return $this
     */
    public function setCode($code);

    /**
     * Retrieve import behaviour
     *
     * @return string|null
     */
    public function getBehaviour();

    /**
     * Set import behaviour
     *
     * @param string|null $behaviour
     * @return $this
     */
    public function setBehaviour($behaviour);

    /**
     * Retrieve fields mapping data
     *
     * @return FieldMappingInterface[]|null
     */
    public function getFieldsMapping();

    /**
     * Set fields mapping data
     *
     * @param FieldMappingInterface[]|null $fieldsMapping
     * @return $this
     */
    public function setFieldsMapping($fieldsMapping);

}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface ImportEntryInterface extends ExtensibleDataInterface
{
    const ID = 'id';
    const PROFILE_CODE = 'profile_code';
    const SOURCE = 'source';
    const IMPORT_PARAMS = 'import_params';
    const FIELDS_MAPPING = 'fields_mapping';
    const TARGET_REPOSITORY = 'target_repository';

    /**
     * Retrieve import ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set import ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Retrieve import Profile code
     *
     * @return string|null
     */
    public function getProfileCode();

    /**
     * Set import Profile code
     *
     * @param string $profileCode
     * @return $this
     */
    public function setProfileCode($profileCode);

    /**
     * Get import source
     *
     * @return \Magento\ImportService\Api\Data\SourceInterface|null
     */
    public function getSource();

    /**
     * Set import source
     *
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return $this
     */
    public function setSource($source);

    /**
     * Get target service
     *
     * @return string|null
     */
    public function getTargetRepository();

    /**
     * Set target service
     *
     * @param string $targetRepository
     * @return $this
     */
    public function setTargetRepository($targetRepository);

    /**
     * Get import params
     *
     * @return \Magento\ImportService\Api\Data\ImportParamsInterface|null
     */
    public function getImportParams();

    /**
     * Set import params
     *
     * @param \Magento\ImportService\Api\Data\ImportParamsInterface $importParams
     * @return $this
     */
    public function setImportParams($importParams);

    /**
     * Get import params
     *
     * @return \Magento\ImportService\Api\Data\FieldMappingInterface[]|null
     */
    public function getFieldsMapping();

    /**
     * Set import params
     *
     * @param \Magento\ImportService\Api\Data\FieldMappingInterface[] $fieldsMapping
     * @return $this
     */
    public function setFieldsMapping($fieldsMapping);
}

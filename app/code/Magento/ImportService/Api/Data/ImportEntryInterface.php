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
    const SOURCE_ID = 'source_id';

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
     * Get import sourceId
     *
     * @return int
     */
    public function getSourceId();

    /**
     * Set import sourceId
     *
     * @param int $sourceId
     * @return $this
     */
    public function setSourceId($sourceId);

}

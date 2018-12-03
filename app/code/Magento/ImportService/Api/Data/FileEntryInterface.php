<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface FileEntryInterface extends ExtensibleDataInterface
{
    const FILE_ID = 'file_id';
    const PROFILE_CODE = 'profile_code';
    const SOURCE = 'source';

    /**
     * Retrieve import File ID
     *
     * @return int|null
     */
    public function getFileId();

    /**
     * Set import File ID
     *
     * @param int $id
     * @return $this
     */
    public function setFileId($fileId);

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

}

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
    const CONTENT = 'content';
    const PARAMS = 'params';

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
     * Get import file content
     *
     * @return \Magento\ImportService\Api\Data\SourceInterface|null
     */
    public function getContent();

    /**
     * Set import content
     *
     * @param \Magento\ImportService\Api\Data\SourceInterface $content
     * @return $this
     */
    public function setContent($content);

    /**
     * Get import params
     *
     * @return \Magento\ImportService\Api\Data\ImportParamsInterface|null
     */
    public function getParams();

    /**
     * Set import params
     *
     * @param \Magento\ImportService\Api\Data\ImportParamsInterface $params
     * @return $this
     */
    public function setParams($params);
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\ImportServiceApi\Api\Data\SourceUploadResponseInterface;
use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;

class SourceUploadResponse extends AbstractModel implements SourceUploadResponseInterface
{
    /**
     * Get file UUID
     *
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->getData(self::UUID);
    }

    /**
     * Get file status
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get error
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->getData(self::ERROR);
    }

    /**
     * @param $uuid
     * @return SourceUploadResponse
     */
    public function setUuid(string $uuid): SourceUploadResponseInterface
    {
        return $this->setData(self::UUID, $uuid);
    }

    /**
     * @param $status
     * @return SourceUploadResponse
     */
    public function setStatus(string $status): SourceUploadResponseInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @param $error
     * @return SourceUploadResponse
     */
    public function setError(string $error): SourceUploadResponseInterface
    {
        return $this->setData(self::ERROR, $error);
    }

}

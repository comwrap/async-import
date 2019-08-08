<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceApi\Api\Data;

/**
 * Interface SourceUploadResponseInterface
 */
interface SourceUploadResponseInterface
{
    public const UUID = 'uuid';
    public const STATUS = 'status';
    public const ERROR = 'error';
    public const SOURCE_MODEL = 'source';

    /**
     * Get file UUID
     *
     * @return string|null
     */
    public function getUuid(): ?string;

    /**
     * Get file status
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Get error
     *
     * @return string
     */
    public function getError(): ?string;

    /**
     * @param $uuid
     *
     * @return SourceUploadResponseInterface
     */
    public function setUuid(string $uuid): SourceUploadResponseInterface;

    /**
     * @param $status
     *
     * @return SourceUploadResponseInterface
     */
    public function setStatus(string $status): SourceUploadResponseInterface;

    /**
     * @param $error
     *
     * @return SourceUploadResponseInterface
     */
    public function setError(string $error): SourceUploadResponseInterface;

}

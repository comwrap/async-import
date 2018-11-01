<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\ApiClient\SchemaInfo;

use Magento\Framework\App\Filesystem\DirectoryList;

abstract class AbstractSchemaInfo
{
    const VENDOR_NAME = 'Magento';
    const NAMESPACE_PATH = 'RestApiClientGenerated';
    const SWAGER_URI = 'rest/all/schema?services=all';
    const SCHEMA_NAME = 'Rest';

    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    private $directoryList;

    /**
     * AbstractSchemaInfo constructor.
     *
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directoryList
     */
    public function __construct(DirectoryList $directoryList)
    {
        $this->directoryList = $directoryList;
    }

    public function getNamespace()
    {
        return static::VENDOR_NAME . '\\' . static::NAMESPACE_PATH;
    }

    public function getSchemaName()
    {
        return static::SCHEMA_NAME;
    }

    public function getSwaggerUri()
    {
        return static::SWAGER_URI;
    }

    public function getPathToApiClient()
    {
        return $this->directoryList
                ->getPath(DirectoryList::GENERATED_CODE) . DIRECTORY_SEPARATOR .
            static::VENDOR_NAME . DIRECTORY_SEPARATOR . static::NAMESPACE_PATH;
    }

    public function getPathToSwaggerSchemaFile()
    {
        return $this->getPathToApiClient() . DIRECTORY_SEPARATOR . $this->getSchemaName() . '.json';
    }

    public function isSchemaExist()
    {
        return (file_exists($this->getPathToSwaggerSchemaFile())) ? true : false;
    }
}

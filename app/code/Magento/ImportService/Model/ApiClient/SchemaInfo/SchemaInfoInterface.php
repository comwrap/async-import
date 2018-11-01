<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\ApiClient\SchemaInfo;

interface SchemaInfoInterface
{
    /**
     * @return string
     */
    public function getSchemaName();

    /**
     * @return string
     */
    public function getSwaggerUri();

    /**
     * @return string
     */
    public function getNamespace();

    /**
     * @return string
     */
    public function getPathToApiClient();

    /**
     * @return string
     */
    public function getPathToSwaggerSchemaFile();

    /**
     * @return boolean
     */
    public function isSchemaExist();
}

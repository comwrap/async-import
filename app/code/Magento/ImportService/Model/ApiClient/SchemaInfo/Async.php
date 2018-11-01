<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\ApiClient\SchemaInfo;

class Async extends AbstractSchemaInfo implements SchemaInfoInterface
{
    const NAMESPACE_PATH = 'AsyncApiClientGenerated';
    const SWAGER_URI = 'rest/all/async/schema?services=all';
    const SCHEMA_NAME = 'Async';
}

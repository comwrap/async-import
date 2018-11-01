<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\ApiClient\SchemaInfo;

class AsyncBulk extends AbstractSchemaInfo implements SchemaInfoInterface
{
    const NAMESPACE_PATH = 'AsyncBulkApiClientGenerated';
    const SWAGER_URI = 'rest/all/async/bulk/schema?services=all';
    const SCHEMA_NAME = 'AsyncBulk';
}

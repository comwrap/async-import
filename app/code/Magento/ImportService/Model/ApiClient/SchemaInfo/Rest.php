<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\ApiClient\SchemaInfo;

class Rest extends AbstractSchemaInfo implements SchemaInfoInterface
{
    const NAMESPACE_PATH = 'RestApiClientGenerated';
    const SWAGER_URI = 'rest/all/schema?services=all';
    const SCHEMA_NAME = 'Rest';
}

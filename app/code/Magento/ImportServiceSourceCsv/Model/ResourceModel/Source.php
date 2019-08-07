<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceSourceCsv\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface;

/**
 * Class SourceResourceModel
 */
class Source extends AbstractDb
{
    public const TABLE_NAME = 'import_service_source';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, SourceCsvInterface::ENTITY_ID);
    }
}

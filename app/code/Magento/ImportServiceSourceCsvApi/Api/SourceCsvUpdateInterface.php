<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceSourceCsvApi\Api;

use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface;

/**
 * Class SourceCsvUpdateInterface
 */
interface SourceCsvUpdateInterface
{
    /**
     * Update source.
     *
     * @param string $uuid
     * @param \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface $source
     * @return \Magento\ImportServiceSourceCsvApi\Api\Data\SourceUploadResponseInterface
     */
    public function execute(string $uuid, SourceCsvInterface $source);
}

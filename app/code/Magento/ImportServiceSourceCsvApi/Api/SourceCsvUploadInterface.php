<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceSourceCsvApi\Api;

use Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface;

/**
 * Class SourceCsvUploadInterface
 */
interface SourceCsvUploadInterface
{
    /**
     * Upload source.
     *
     * @param \Magento\ImportServiceSourceCsvApi\Api\Data\SourceCsvInterface $source
     * @return \Magento\ImportServiceSourceCsvApi\Api\Data\SourceUploadResponseInterface
     */
    public function execute(SourceCsvInterface $source);
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceXml\Api;

use Magento\ImportServiceXml\Api\Data\SourceXmlInterface;

/**
 * Class ImportProcessor
 */
interface SourceUploadXmlInterface
{
    /**
     * Upload source.
     *
     * @param \Magento\ImportServiceXml\Api\Data\SourceXmlInterface $source
     * @return \Magento\ImportService\Api\Data\SourceUploadResponseInterface
     */
    public function execute(SourceXmlInterface $source);
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceXml\Api\Data;

use Magento\ImportService\Api\Data\SourceInterface;

/**
 * Interface SourceInterface
 */
interface SourceXmlInterface extends SourceInterface
{

    /**
     * Retrieve Source Format
     *
     * @return \Magento\ImportServiceXml\Api\Data\SourceFormatXmlInterface|null
     */
    public function getFormat(): ?SourceFormatXmlInterface;

    /**
     * Set Source Format
     *
     * @param \Magento\ImportServiceXml\Api\Data\SourceFormatXmlInterface $format
     * @return $this
     */
    public function setFormat(SourceFormatXmlInterface $format): SourceXmlInterface;
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceXml\Api\Data;

/**
 * Interface SourceFormatXmlInterface
 *
 * @package Magento\ImportServiceXml\Api\Data
 */
interface SourceFormatXmlInterface
{
    const XML_ITEMS_XPATH = 'xml_items_xpath';

    const DEFAULT_ITEMS_XPATH = 'items';

    /**
     * @return string|null
     */
    public function getItemsXpath(): ?string;

    /**
     * Set xml xpath to the items
     *
     * @param string $xpath
     * @return \Magento\ImportServiceXml\Api\Data\SourceFormatXmlInterface
     */
    public function setItemsXpath(string $xpath): SourceFormatXmlInterface;
}

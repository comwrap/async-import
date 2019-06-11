<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceXml\Model;

use Magento\ImportServiceXml\Api\Data\SourceFormatXmlInterface;

/**
 * Class SourceFormatXml
 */
class SourceFormatXml extends \Magento\Framework\DataObject implements SourceFormatXmlInterface
{
    /**
     * @inheritDoc
     */
    public function getItemsXpath(): ?string
    {
        return $this->getData(self::XML_ITEMS_XPATH) ?? self::DEFAULT_ITEMS_XPATH;
    }

    /**
     * @inheritDoc
     */
    public function setItemsXpath(string $xpath): SourceFormatXmlInterface
    {
        return $this->setData(self::XML_ITEMS_XPATH, $xpath);
    }
}

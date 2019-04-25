<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source;

use Magento\Framework\DataObject;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Model\Source\ParserInterface;

abstract class ParserAbstract extends DataObject implements ParserInterface
{

    /**
     * @inheritDoc
     */
    public function getFilePath()
    {
        return $this->getData(ParserInterface::FILE_PATH);
    }

    /**
     * @inheritDoc
     */
    public function setFilePath(string $filePath)
    {
        return $this->setData(ParserInterface::FILE_PATH, $filePath);
    }

    /**
     * @inheritDoc
     */
    public function getSource()
    {
        return $this->getData(ParserInterface::SOURCE);
    }

    /**
     * @inheritDoc
     */
    public function setSource(SourceInterface $source)
    {
        return $this->setData(ParserInterface::SOURCE, $source);
    }
}

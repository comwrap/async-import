<?php

namespace Magento\ImportService\Model\Import\Command;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\Data\ImportConfigInterface;

interface StartInterface
{

    /**
     * @param SourceInterface $source
     * @param ImportConfigInterface $importConfig
     * @return mixed
     */
    public function execute(SourceInterface $source, ImportConfigInterface $importConfig);

}

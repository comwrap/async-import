<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Mapping;

/**
 *  Source Processor Pool
 */
class ProcessSourceItemMapping
{
    private $data;
    private $mapping;
    private $processor;

    public function __construct(
        $data = [],
        $mapping = [],
        $processor = null
    ) {
        $this->data = $data;
        $this->mapping = $mapping;
        $this->processor = $processor;
    }

    public function process()
    {

        $mapping = [];
        foreach ($this->mapping as $fieldMappingSource) {
            $fieldMapping = clone $fieldMappingSource;
            if ($fieldMapping->getSourcePath() == null || $fieldMapping->getSourcePath() == '') {
                $value = $this->data;
            } else {
                $value = $this->processor->get($this->data, $fieldMapping->getSourcePath());
            }
            $fieldMapping->setSourceValue($value);
            $mapping[] = $fieldMapping;
        }

        return $mapping;

    }



}
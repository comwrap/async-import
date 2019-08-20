<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import;

use Magento\ImportService\ImportServiceException;
use Magento\ImportServiceApi\Api\Data\ImportConfigInterface;
use Magento\ImportService\Model\Import\Processors\ImportProcessorInterface;

/**
 *  Imports Processor Pool
 */
class ImportProcessorsPool implements ImportProcessorsPoolInterface
{
    /**
     * @var array
     */
    private $importProcessors;

    /**
     * Initial dependencies
     *
     * @param array $importProcessors
     */
    public function __construct(array $importProcessors = [])
    {
        $this->importProcessors = $importProcessors;
    }

    /**
     * @param ImportConfigInterface $importConfig

     * @return string

     * @throws ImportServiceException
     */
    public function getProcessor(ImportConfigInterface $importConfig): ImportProcessorInterface
    {

        foreach ($this->importProcessors as $key => $processorInformation) {
            if ($key == $importConfig->getImportType()){
                foreach ($processorInformation as $strategyKey => $processor){
                    if ($strategyKey == $importConfig->getImportStrategy()){
                        return $processor['processor'];
                    }
                }
            }
        }
        throw new ImportServiceException(
            __('Topic for import type is not defined')
        );
    }
}

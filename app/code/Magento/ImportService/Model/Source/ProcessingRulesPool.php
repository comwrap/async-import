<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source;

use Magento\Framework\ObjectManagerInterface;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;
use Magento\ImportService\Model\Import\Type\SourceTypeInterface;

/**
 * Class ProcessingRulesPool
 */
class ProcessingRulesPool
{
    /**
     * @var array
     */
    private $rules;
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Initial dependencies
     *
     * @param SourceTypeInterface[] $rules
     */
    public function __construct(
        //ObjectManagerInterface $objectManager,
        $rules = []
    ) {
        $this->rules = $rules;
        //$this->objectManager = $objectManager;
    }

    /**
     * {@inheritdoc}
     * @throws ImportServiceException
     * @return SourceTypeInterface
     */
    public function getRule($ruleName)
    {
        foreach ($this->rules as $key => $name) {
            if ($ruleName == $key) {
                return $object;
            }
        }
        throw new ImportServiceException(
            __('Specified Source type "%1" is wrong.', $source->getSourceType())
        );
    }
}

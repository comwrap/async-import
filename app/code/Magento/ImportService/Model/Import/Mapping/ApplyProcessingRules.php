<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Mapping;

use Magento\ImportService\Model\Import\RulesProcessorFactory;

/**
 *  Source Processor Pool
 */
class ApplyProcessingRules
{

    public function __construct(

    ) {
    }

    public function execute($mapping)
    {
        $variables = [
            'custom_attributes' => []
        ];
        $rulesRecreated = [];
        foreach ($mapping as $fieldMapping) {
            $processingRules = $fieldMapping->getProcessingRules();
            $fieldName = $fieldMapping->getName();
            $value = $fieldMapping->getSourceValue();
            $targetValue = $fieldMapping->getTargetValue();
            if (isset($targetValue)) {
                $value = $targetValue;
            }
            if (!empty($processingRules)) {
                usort($processingRules, function ($a, $b) {
                    return (int)$a->getSort() - $b->getSort();
                });
                $fieldMapping->setProcessingRules($processingRules);

                /** @var \Magento\ImportServiceApi\Api\Data\ImportProcessingRuleInterface $rule */
                foreach ($fieldMapping->getProcessingRules() as $rule) {
                    $forceCreate = false;
                    if (!in_array($rule->getFunction(), $rulesRecreated)) {
                        $forceCreate = true;
                        $rulesRecreated[] = $rule->getFunction();
                    }
                    $args = $rule->getArgs();
                    if (!isset($args)) {
                        $args = [];
                    }
                    foreach ($args as &$arg) {
                        if (!is_string($arg)) {
                            continue;
                        }
                        $searchResult = [];
                        preg_match('/{{([A-Za-z\-\_\.]+)}}/', $arg, $searchResult);
                        if (count($searchResult) > 1) {
                            if (!array_key_exists($searchResult[1], $variables)) {
                                throw new LocalizedException(__("Varibale %1 for import field %2 not defined yet. Check fields mapping order.", $arg, $fieldName));
                            }
                            $arg = $variables[$searchResult[1]];
                        }
                    }
                    /** @var \Magento\ImportService\Model\Import\ProcessingRules\ProcessingRuleInterface $processor */
                    $processor = $this->rulesProcessorFactory->create($rule->getFunction(), [], $forceCreate);
                    // @TODO - why we need source?
                    $processor->setSource(null);
                    $processor->setArguments($args);
                    $processor->setValue($value);
                    $value = $processor->execute();//change to call_user_func_array
                }
            }
            $variables[$fieldMapping->getName()] = $value;
            $fieldMapping->setTargetValue($value);
        }
        return $mapping;
    }


}
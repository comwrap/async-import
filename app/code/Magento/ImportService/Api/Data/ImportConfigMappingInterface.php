<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

use Magento\Tests\NamingConvention\true\string;

/**
 * Interface ImportConfigMappingInterface
 */
interface ImportConfigMappingInterface
{
    const NAME = 'name';
    const SOURCE_PATH = 'source_path';
    const TARGET_PATH = 'target_path';
    const TARGET_VALUE = 'target_value';
    const PROCESSING_RULES = 'processing_rules';

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @return string
     */
    public function getSourcePath(): string;

    /**
     * @param string $sourcePath
     */
    public function setSourcePath(string $sourcePath): void;

    /**
     * @return string
     */
    public function getTargetPath(): string;

    /**
     * @param string $targetPath
     */
    public function setTargetPath(string $targetPath): void;

    /**
     * @return string
     */
    public function getTargetValue(): string;

    /**
     * @param string $targetValue
     */
    public function setTargetValue(string $targetValue): void;

    /**
     * @return ImportConfigMappingProcessingRulesInterface
     */
    public function getProcessingRules(): ImportConfigMappingProcessingRulesInterface;

    /**
     * @param ImportConfigMappingProcessingRulesInterface $processingRules
     */
    public function setProcessingRules(ImportConfigMappingProcessingRulesInterface $processingRules): void;
}
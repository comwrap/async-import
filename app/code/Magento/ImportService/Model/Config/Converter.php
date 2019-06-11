<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model\Config;

use Magento\Framework\Module\Manager;
use Magento\Framework\App\Utility\Classes;

class Converter implements \Magento\Framework\Config\ConverterInterface
{

    const KEY_IMPORTS = 'imports';
    const KEY_IMPORT = 'import';
    const KEY_IMPORT_TYPE = 'type';
    const KEY_MAPPING_PROCESSOR = 'mapping_processor';
    const KEY_MAPPING_PROCESSOR_SOURCE = 'source';
    const KEY_MAPPING_PROCESSOR_TARGET = 'target';

    const KEY_BEHAVIOURS = 'behaviours';
    const KEY_STORAGES = 'storages';
    const KEY_STORAGE = 'storage';
    const KEY_STORAGE_CLASS = 'class';
    const KEY_STORAGE_METHOD = 'method';
    const KEY_STORAGE_NAME = 'name';
    const KEY_STORAGE_DATA = 'data';

    const KEY_FORCE = 'force';
    const KEY_VALUE = 'value';

    /**
     * @var \Magento\Framework\Module\Manager
     */
    private $moduleManager;

    /**
     * @param Manager $moduleManager
     */
    public function __construct(Manager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    /**
     * Convert dom node tree to array
     *
     * @param \DOMDocument $source
     * @return array
     * @throws \InvalidArgumentException
     */
    public function convert($source)
    {
        $output = [self::KEY_IMPORTS => []];
        /** @var \DOMNodeList $entities */
        $entities = $source->getElementsByTagName(self::KEY_IMPORT);
        /** @var \DOMElement $import */
        foreach ($entities as $import) {
            if ($import->nodeType != XML_ELEMENT_NODE) {
                continue;
            }
            $type = $import->attributes->getNamedItem('type')->nodeValue;

            /** @var \DOMElement $service */
            $mappingProcessor = $import->getElementsByTagName('mappingProcessor')->item(0);
            $mpSourceClass = $mappingProcessor->attributes->getNamedItem('sourceClass')->nodeValue;
            $mpTargetClass = $mappingProcessor->attributes->getNamedItem('targetClass')->nodeValue;
            if (!$this->isModelEnabled($mpSourceClass) || !$this->isModelEnabled($mpTargetClass)) {
                continue;
            }

            $behaviours = $import->getElementsByTagName('behaviours')->item(0);
            $behavioursEl = $behaviours->getElementsByTagName('behaviour');
            $behavioursArray = [];
            /** @var \DOMElement $behaviour */
            foreach ($behavioursEl as $behaviour) {
                $behaviourCode = $behaviour->attributes->getNamedItem('code')->nodeValue;

                $storages = $import->getElementsByTagName('storages')->item(0);
                $storagesEl = $storages->getElementsByTagName('storage');
                $storagesArray = [];
                /** @var \DOMElement $storage */
                foreach ($storagesEl as $storage) {
                    $storageClass = $storage->attributes->getNamedItem('class')->nodeValue;
                    $storageMethod = $storage->attributes->getNamedItem('method')->nodeValue;
                    $storageName = $storage->attributes->getNamedItem('method')->nodeValue;
                    $data = $this->convertMethodParameters($storage->getElementsByTagName('parameter'));
                    if (!$this->isModelEnabled($storageClass)) {
                        continue;
                    }

                    $storagesArray[] = [
                        self::KEY_STORAGE_NAME => $storageName,
                        self::KEY_STORAGE_CLASS => $storageClass,
                        self::KEY_STORAGE_METHOD => $storageMethod,
                        self::KEY_STORAGE_DATA => $data
                    ];
                }

                $behavioursArray[$behaviourCode][self::KEY_STORAGES] = $storagesArray;
            }

            $output[self::KEY_IMPORTS][$type] = [
                self::KEY_IMPORT_TYPE => $type,
                self::KEY_BEHAVIOURS => $behavioursArray,
                self::KEY_MAPPING_PROCESSOR => [
                    self::KEY_MAPPING_PROCESSOR_SOURCE => $mpSourceClass,
                    self::KEY_MAPPING_PROCESSOR_TARGET => $mpTargetClass
                ],
            ];
        }
        return $output;
    }

    /**
     * Parses the method parameters into a string array.
     *
     * @param \DOMNodeList $parameters
     * @return array
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function convertMethodParameters($parameters)
    {
        $data = [];
        /** @var \DOMElement $parameter */
        foreach ($parameters as $parameter) {
            if ($parameter->nodeType != XML_ELEMENT_NODE) {
                continue;
            }
            $name = $parameter->attributes->getNamedItem('name')->nodeValue;
            $forceNode = $parameter->attributes->getNamedItem('force');
            $force = $forceNode ? (bool)$forceNode->nodeValue : false;
            $value = $parameter->nodeValue;
            $data[$name] = [
                self::KEY_FORCE => $force,
                self::KEY_VALUE => ($value === 'null') ? null : $value,
            ];
        }
        return $data;
    }

    private function isModelEnabled($model)
    {
        return $this->moduleManager->isEnabled(Classes::getClassModuleName($model));
    }
}

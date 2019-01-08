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
        $output = ['entities' => []];
        /** @var \DOMNodeList $entities */
        $entities = $source->getElementsByTagName('entity');
        /** @var \DOMNode $entityConfig */
        foreach ($entities as $entityConfig) {
            $attributes = $entityConfig->attributes;
            $name = $attributes->getNamedItem('name')->nodeValue;
            $label = $attributes->getNamedItem('label')->nodeValue;
            $behavior = $attributes->getNamedItem('behavior')->nodeValue;
            $apiEndpoint = $attributes->getNamedItem('apiEndpoint')->nodeValue;
            $apiMethod = $attributes->getNamedItem('apiMethod')->nodeValue;
            $model = $attributes->getNamedItem('model')->nodeValue;
            if (!$this->moduleManager->isEnabled(Classes::getClassModuleName($model))) {
                continue;
            }
            $output['entities'][$name] = [
                'name' => $name,
                'label' => $label,
                'behavior' => $behavior,
                'apiEndpoint' => $apiEndpoint,
                'apiMethod' => $apiMethod,
                'model' => $model,
                'types' => [],
            ];
        }

        /** @var \DOMNodeList $entityTypes */
        $entityTypes = $source->getElementsByTagName('entityType');
        /** @var \DOMNode $entityTypeConfig */
        foreach ($entityTypes as $entityTypeConfig) {
            $attributes = $entityTypeConfig->attributes;
            $name = $attributes->getNamedItem('name')->nodeValue;
            $model = $attributes->getNamedItem('model')->nodeValue;
            $entity = $attributes->getNamedItem('entity')->nodeValue;

            if (isset($output['entities'][$entity])) {
                $output['entities'][$entity]['types'][$name] = [
                    'name' => $name,
                    'model' => $model
                ];
            }
        }

        return $output;
    }
}

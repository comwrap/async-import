<?php

namespace Magento\ImportService\Model\Import\Mapping;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\ImportService\Model\ConfigInterface;


class GetMappingProcessorSource
{

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;


    public function __construct(
        ObjectManagerInterface $objectManager,
        ConfigInterface $config
    ) {
        $this->objectManager = $objectManager;
        $this->config = $config;

    }

    /**
     * @param ImportConfigInterface $importConfig
     * @param $configType
     * @throws NotFoundException
     */
    public function get($configType)
    {

        $processor = $this->config->getMappingProcessorSource($configType);
        if (!isset($processor)) {
            throw new NotFoundException(__('Mapping source processor not defined.'));
        }
        return $this->objectManager->get($processor);

    }
}

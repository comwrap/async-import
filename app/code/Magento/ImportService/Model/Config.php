<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model;

use Magento\ImportService\Model\ConfigInterface;
use Magento\Framework\Config\Data;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\ImportService\Model\Config\Reader;
use Magento\ImportService\Model\Config\Converter;
use Magento\Framework\Config\CacheInterface;

/**
 * Provides import configuration
 */
class Config extends Data implements ConfigInterface
{
    const CACHE_ID = 'import_service_config_cache';

    /**
     * Constructor
     *
     * @param Config\Reader $reader
     * @param \Magento\Framework\Config\CacheInterface $cache
     * @param string|null $cacheId
     * @param SerializerInterface|null $serializer
     */
    public function __construct(
        Reader $reader,
        CacheInterface $cache,
        $cacheId = self::CACHE_ID,
        SerializerInterface $serializer = null
    ) {
        parent::__construct($reader, $cache, $cacheId, $serializer);
    }

    /**
     * Retrieve import entities configuration
     *
     * @return array
     */
    public function getImportEntities()
    {
        return $this->get(Converter::KEY_IMPORTS);
    }

    /**
     * Retrieve import entity type configuration
     *
     * @param string $type
     * @return array
     */
    public function getImportType($type)
    {
        $importEntities = $this->getImportEntities();
        return isset($importEntities[$type]) ? $importEntities[$type] : [];
    }

    /**
     * @inheritDoc
     */
    public function getMappingProcessorSource($type, $behaviour = null)
    {
        $path = implode('/', [
            Converter::KEY_IMPORTS,
            $type,
            Converter::KEY_MAPPING_PROCESSOR,
            Converter::KEY_MAPPING_PROCESSOR_SOURCE
        ]);
        return $this->get($path, null);
    }

    /**
     * @inheritDoc
     */
    public function getMappingProcessorTarget($type, $behaviour = null)
    {
        $path = implode('/', [
            Converter::KEY_IMPORTS,
            $type,
            Converter::KEY_MAPPING_PROCESSOR,
            Converter::KEY_MAPPING_PROCESSOR_TARGET
        ]);
        return $this->get($path, null);
    }
}

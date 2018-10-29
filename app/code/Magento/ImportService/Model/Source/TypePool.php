<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source;

use Magento\Framework\Filesystem\Directory\Write;
use Magento\ImportExport\Model\Import\AbstractSource;

/**
 * Import data source type pool model
 */
class TypePool
{
    /**
     * @var array
     */
    private $sourceTypes;

    /**
     * Initial dependencies
     *
     * @param array $sourceTypes
     */
    public function __construct($sourceTypes = [])
    {
        $this->sourceTypes = $sourceTypes;
    }

    /**
     * Adapter factory. Checks for availability, loads and create instance of
     * import adapter object.
     *
     * @param string $sourceType Adapter type ('csv', 'xml' etc.)
     * @return AbstractSource
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function factory($sourceType)
    {
        if (!is_string($sourceType) || !$sourceType) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The adapter type must be a non-empty string.')
            );
        }
        $sourceType = strtolower($sourceType);
        if (!isset($this->sourceTypes[$sourceType])) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('\'%1\' source type is not supported', $sourceType)
            );
        }

        $adapterClass = $this->sourceTypes[$sourceType];
        if (!class_exists($adapterClass)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('\'%1\' file extension is not supported because of adapter class not exist', $sourceType)
            );
        }

        /** @var AbstractSource $adapter */
        $adapter = new $adapterClass($sourceType);

        if (!$adapter instanceof AbstractSource) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Adapter must be an instance of \Magento\ImportExport\Model\Import\AbstractSource')
            );
        }
        return $adapter;
    }

    /**
     * Create adapter instance for specified source type.
     *
     * @param string $sourceType Source type
     * @return AbstractSource
     */
    public function findAdapterFor($sourceType)
    {
        return $this->factory($sourceType);
    }
}

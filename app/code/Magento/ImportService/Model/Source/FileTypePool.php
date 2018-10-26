<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source;

use Magento\Framework\Filesystem\Directory\Write;
use Magento\ImportExport\Model\Import\AbstractSource;

/**
 * Import data format pool model
 */
class FileTypePool
{

    /**
     * @var array
     */
    private $sourceFileTypes;

    /**
     * Initial dependencies
     *
     * @param \Magento\ImportExport\Model\Import\AbstractSource[] $sourceFileTypes
     */
    public function __construct($sourceFileTypes = [])
    {
        $this->sourceFileTypes = $sourceFileTypes;
    }

    /**
     * Adapter factory. Checks for availability, loads and create instance of
     * import adapter object.
     *
     * @param string $type Adapter type ('csv', 'xml' etc.)
     * @param Write $directory
     * @param string $source
     * @param mixed $options OPTIONAL Adapter constructor options
     * @return AbstractSource
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function factory($type, $directory, $source, $options = null)
    {
        if (!is_string($type) || !$type) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The adapter type must be a non-empty string.')
            );
        }
        $type = strtolower($type);
        if (!isset($this->sourceFileTypes[$type])) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('\'%1\' file extension is not supported', $type)
            );
        }

        $adapterClass = $this->sourceFileTypes[$type];
        if (!class_exists($adapterClass)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('\'%1\' file extension is not supported because of adapter class not exist', $type)
            );
        }

        /** @var AbstractSource $adapter */
        $adapter = new $adapterClass($source, $directory, $options);

        if (!$adapter instanceof AbstractSource) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Adapter must be an instance of \Magento\ImportExport\Model\Import\AbstractSource')
            );
        }
        return $adapter;
    }

    /**
     * Create adapter instance for specified source file.
     *
     * @param string $source Source file path.
     * @param Write $directory
     * @param mixed $options OPTIONAL Adapter constructor options
     * @return AbstractSource
     */
    public function findAdapterFor($source, $directory, $options = null)
    {
        return $this->factory(pathinfo($source, PATHINFO_EXTENSION), $directory, $source, $options);
    }
}

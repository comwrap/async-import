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
     * @param string $sourceType
     * @param string $data PAth to file or encoded_data
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function factory($sourceType, $data)
    {
        if (!is_string($sourceType) || !$sourceType) {
            throw new \Magento\ImportService\Exception(
                __('The adapter type must be a non-empty string.')
            );
        }
        $sourceType = strtolower($sourceType);
        if (!isset($this->sourceTypes[$sourceType])) {
            throw new \Magento\ImportService\Exception(
                __('\'%1\' source type is not supported', $sourceType)
            );
        }

        $adapterClass = $this->sourceTypes[$sourceType];
        if (!class_exists($adapterClass)) {
            throw new \Magento\ImportService\Exception(
                __('\'%1\' file extension is not supported because of adapter class not exist', $sourceType)
            );
        }

        /** @var string $file Path to file */
        $file = new $adapterClass($data);
        return $file;
    }

    /**
     * Create adapter instance for specified source type.
     *
     * @param string $sourceType Source type
     * @return AbstractSource
     */
    public function getFileForType($sourceType, $data)
    {
        return $this->factory($sourceType, $data);
    }
}

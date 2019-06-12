<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Magento\ImportService\Model;

/**
 * Provides import sync configuration
 */
interface ConfigInterface
{
    /**
     * Retrieve import entities configuration
     *
     * @return array
     */
    public function getImportEntities();

    /**
     * Retrieve import type configuration
     *
     * @param string $type
     * @return array
     */
    public function getImportType($type);

    /**
     * @param string $type
     * @param null $behaviour
     * @return mixed
     */
    public function getMappingProcessorSource($type, $behaviour = null);

    /**
     * @param string $type
     * @param null $behaviour
     * @return mixed
     */
    public function getMappingProcessorTarget($type, $behaviour = null);

    /**
     * @param string $type
     * @param string $behaviour
     * @return mixed
     */
    public function getStorages($type, $behaviour);
}

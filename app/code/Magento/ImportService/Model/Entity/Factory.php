<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Import entity factory
 */
namespace Magento\ImportService\Model\Entity;

class Factory
{
    /**
     * Object Manager
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param string $className
     * @return AbstractEntity|\Magento\ImportExport\Model\Import\AbstractEntity
     * @throws \InvalidArgumentException
     */
    public function create($className)
    {
        if (!$className) {
            throw new \InvalidArgumentException('Incorrect class name');
        }

        return $this->objectManager->create($className);
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Resolver;

use Magento\Framework\Exception\NotFoundException;

interface PathResolverInterface
{
    /**
     * Get item value by path
     *
     * @param string $path
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function get($item, $path);

    /**
     * Set item value by path
     *
     * @param array|string $item
     * @param string $path
     * @param string $value
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function set($item, $path, $value);
}
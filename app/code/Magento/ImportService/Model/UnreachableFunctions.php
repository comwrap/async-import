<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\ImportService\Model;

use Magento\Store\Model\StoreManagerInterface;

class UnreachableFunctions
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * NotAccessibleConfig constructor.
     *
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager
    ) {

        $this->storeManager = $storeManager;
    }

    public function getBaseUrl()
    {
        $store = $this->storeManager->getStore();
        $baseUrl =$store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
        return $baseUrl;
    }
}

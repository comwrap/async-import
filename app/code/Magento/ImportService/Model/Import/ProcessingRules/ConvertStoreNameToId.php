<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\ProcessingRules;

use Magento\Framework\Exception\LocalizedException;

/**
 * Class ConvertStoreNameToId

 * @package Magento\ImportService\Model\ProcessingRules
 */
class ConvertStoreNameToId extends ProcessingRuleAbstract
{

    public const VALUE_ALL_WEBSITES = "All Websites";

    /**
     * @var \Magento\Store\Model\Website
     */
    protected $websiteModel;

    /**
     * Store manager instance.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var array
     */
    protected $websiteCodeToId;

    /**
     * @var array
     */
    protected $websiteCodeToStoreIds;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Store\Model\Website $websiteModel
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Store\Model\Website $websiteModel
    ) {
        $this->storeManager = $storeManager;
        $this->websiteModel = $websiteModel;
    }

    public function execute()
    {
        $value = $this->getValue();
        if ($value === $this->getAllWebsitesValue()){
            return "0";
        }
        $this->_initWebsites();
        return $this->websiteCodeToId[$value] ?? null;
    }

    /**
     * Get all websites value with currency code
     *
     * @return string
     */
    private function getAllWebsitesValue()
    {
        return self::VALUE_ALL_WEBSITES . ' ['.$this->websiteModel->getBaseCurrency()->getCurrencyCode().']';
    }

    /**
     * Initialize website values.
     *
     * @return $this
     */
    protected function _initWebsites()
    {
        /** @var $website \Magento\Store\Model\Website */
        foreach ($this->storeManager->getWebsites() as $website) {
            $this->websiteCodeToId[$website->getCode()] = $website->getId();
            $this->websiteCodeToStoreIds[$website->getCode()] = array_flip($website->getStoreCodes());
        }
        return $this;
    }

}
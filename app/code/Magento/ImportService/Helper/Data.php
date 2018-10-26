<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Helper;

/**
 * ImportService data helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\ImportExport\Helper\Data
     */
    private $importExportHelper;

    /**
     * Initial dependencies.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\ImportExport\Helper\Data $importExportHelper
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\ImportExport\Helper\Data $importExportHelper
    ) {
        $this->importExportHelper = $importExportHelper;
        parent::__construct($context);
    }
}

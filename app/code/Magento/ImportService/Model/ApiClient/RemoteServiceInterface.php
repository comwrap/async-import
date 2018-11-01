<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\ApiClient;

use Magento\Framework\HTTP\Client\Curl;

interface RemoteServiceInterface
{
    /**
     * @return string
     */
    public function getServiceUrl();

    public function getRequestBody();
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\ApiClient;

use Magento\Framework\HTTP\Client\Curl;

class Invoker
{

    /**
     * @var \Magento\Framework\HTTP\Client\Curl
     */
    private $curlClient;

    /**
     * Invoker constructor.
     *
     * @param \Magento\Framework\HTTP\Client\Curl $curlClient
     */
    public function __construct(
        Curl $curlClient,
        RemoteServiceInterface $remoteService
    ) {
        $this->curlClient = $curlClient;
    }

    /**
     * Gets partners json
     *
     * @return array
     */
    public function makeGet()
    {
        $apiUrl = $this->getApiUrl();
        try {
            $this->getCurlClient()->post($apiUrl, []);
            $this->getCurlClient()->setOptions(
                [
                    CURLOPT_REFERER => $this->getReferer()
                ]
            );
            $response = json_decode($this->getCurlClient()->getBody(), true);
            if ($response['partners']) {
                $this->getCache()->savePartnersToCache($response['partners']);
                return $response['partners'];
            } else {
                return $this->getCache()->loadPartnersFromCache();
            }
        } catch (\Exception $e) {
            return $this->getCache()->loadPartnersFromCache();
        }
    }

    /**
     * @return Curl
     */
    public function getCurlClient()
    {
        return $this->curlClient;
    }
}

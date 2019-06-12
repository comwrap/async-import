<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Storage;

use Magento\Framework\DataObject;

class MagentoRest extends DataObject implements StorageInterface
{

    /**
     * @var \Magento\Framework\App\DeploymentConfig
     */
    private $deploymentConfig;
    /**
     * @var \Magento\Framework\HTTP\ZendClientFactory
     */
    private $httpClientFactory;
    /**
     * @var \Magento\Framework\HTTP\Adapter\CurlFactory
     */
    private $curlFactory;

    /**
     * MagentoRest constructor.
     *
     * @param \Magento\Framework\App\DeploymentConfig $deploymentConfig
     * @param \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory
     * @param \Magento\Framework\HTTP\Adapter\CurlFactory $curlFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\DeploymentConfig $deploymentConfig,
        \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory,
        \Magento\Framework\HTTP\Adapter\CurlFactory $curlFactory,
        array $data = []
    ) {
        parent::__construct($data);
        $this->deploymentConfig = $deploymentConfig;
        $this->httpClientFactory = $httpClientFactory;
        $this->curlFactory = $curlFactory;
    }

    /**
     * @param mixed $item
     * @param \Magento\ImportService\Api\Data\SourceInterface $source
     * @return string
     */
    public function execute($item, $source)
    {
        $config = $this->deploymentConfig->getConfigData('import_service');
        $magentoApiConfig = $config['magento'];
        $url = $magentoApiConfig['url'] .
            $this->getData('restPath')['value'];
        $body = $item;

        $curlObject = $this->curlFactory->create();
        $curlObject->setConfig(
            [
                'timeout' => 18000
            ]
        );

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'cache-control: no-cache',
            "Authorization: Bearer {$magentoApiConfig['token']}"
        ];

        $curlObject->write(
            $this->getData('httpMethod')['value'],
            $url,
            CURL_HTTP_VERSION_NONE,
            $headers,
            $body
        );
        $curlObject->addOption(CURLOPT_FOLLOWLOCATION, true);
        $response = $curlObject->read();
        $responseCode = $curlObject->getInfo(CURLINFO_RESPONSE_CODE);
        if ($responseCode != 200) {
            throw new \Exception(sprintf($response));
        }
        $curlObject->close();

        return $response;
    }

    public function post($item, $source)
    {
        return $this->execute($item, $source);
    }
}

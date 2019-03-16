<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Api;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\UrlInterface;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\Data\SourceUploadResponseInterface;
use Magento\ImportService\Model\Import\SourceProcessorPool;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Tests the import service by given external source.
 */
class ExternalFileProcessorTest extends WebapiAbstract
{
    const SERVICE_NAME = 'sourceRepositoryV1';
    const SERVICE_VERSION = 'V1';
    const RESOURCE_PATH = '/V1/import/source';

    /**
     * The tested file extension
     */
    const EXTERNAL_FILE_TYPE = 'csv';

    /**
     * The type of import
     */
    const IMPORT_TYPE = 'external';

    /**
     * The temporary directory name
     */
    const TEMPORARY_DIR = 'tmp_importservice/';

    /**
     * Test Import Data not set
     */
    public function testImportDataNotSet()
    {
        $result = $this->_webApiCall(
            $this->makeServiceInfo(),
            $this->makeRequestData(null)
        );

        $this->assertEquals(SourceUploadResponseInterface::STATUS_FAILED, $result['status']);
        $this->assertRegExp('/Invalid request/', $result['error']);
        $this->assertNull($result['source']);
    }

    /**
     * Test non reachable file
     */
    public function testUnreachableFile()
    {
        $sampleFileName = 'non-existing' . '.' . self::EXTERNAL_FILE_TYPE;
        
        $result = $this->_webApiCall(
            $this->makeServiceInfo(),
            $this->makeRequestData($this->getExternalLink($sampleFileName))
        );

        $this->assertEquals(SourceUploadResponseInterface::STATUS_FAILED, $result['status']);
        $this->assertRegExp('/does not exist./', $result['error']);
        $this->assertNull($result['source']);
    }

    /**
     * Test reachable file
     */
    public function testReachableFile()
    {
        $sampleFileName = 'importservice-test-' . time() . '.' . self::EXTERNAL_FILE_TYPE;
        $sampleFileContent = 'ABCDEFGHabcdefgh0123456789';

        /** @var \Magento\Framework\Filesystem\Directory\WriteInterface $mediaWriter */
        $mediaWriter = $this->getWriteInterface(DirectoryList::MEDIA);

        /** @var \Magento\Framework\Filesystem\Directory\WriteInterface $varWriter */
        $varWriter = $this->getWriteInterface(DirectoryList::VAR_DIR);

        /** Create the test file that should be copied */
        $mediaWriter->writeFile($mediaWriter->getAbsolutePath(self::TEMPORARY_DIR) . $sampleFileName, $sampleFileContent);

        /** Make the Api call */
        $result = $this->_webApiCall(
            $this->makeServiceInfo(),
            $this->makeRequestData($this->getExternalLink($sampleFileName))
        );

        /** Assert the response status and the source_id */
        $this->assertEquals(SourceUploadResponseInterface::STATUS_UPLOADED, $result['status']);
        $this->assertNotNull($result['source']['import_data']);

        if (isset($result['source']['import_data'])) {

            /** @var string $nameCopiedFile */
            $nameCopiedFile = $result['source']['import_data'];

            /** @var string $pathCopiedFile */
            $pathCopiedFile = $varWriter->getAbsolutePath(SourceProcessorPool::WORKING_DIR)
                . $nameCopiedFile;

            /** Assert that the content of the copied file matches the original content */
            $this->assertEquals(
                strlen($sampleFileContent),
                strlen($varWriter->readFile($pathCopiedFile))
            );

            /** Remove the file from the working directory */
            $varWriter->getDriver()->deleteFile($pathCopiedFile);
        }

        /** Remove tmp dir */
        $mediaWriter->delete($mediaWriter->getAbsolutePath(self::TEMPORARY_DIR));
    }

    /**
     * Sets up the service info
     * @return array
     */
    private function makeServiceInfo()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_POST,
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'serviceVersion' => self::SERVICE_VERSION,
                'operation' => self::SERVICE_NAME . 'Save',
            ],
        ];

        return $serviceInfo;
    }

    /**
     * Sets up the request array
     * @param string $import_data
     * @return array
     */
    private function makeRequestData($import_data)
    {
        return ['source' => [
                SourceInterface::SOURCE_TYPE => self::EXTERNAL_FILE_TYPE,
                SourceInterface::IMPORT_TYPE => self::IMPORT_TYPE,
                SourceInterface::IMPORT_DATA => $import_data
            ]
        ];
    }

    /**
     * Gets the public link to the file to be copied
     * @param $sampleFileName
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getExternalLink($sampleFileName)
    {
        /** @var \Magento\Store\Model\StoreManagerInterface $storeManager */
        $storeManager = Bootstrap::getObjectManager()->create(\Magento\Store\Model\StoreManagerInterface::class);

        return $storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
            . self::TEMPORARY_DIR
            . $sampleFileName;
    }

    /**
     * Gets a Write object
     * @param string $dir The directory to write to
     * @return \Magento\Framework\Filesystem\Directory\WriteInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    private function getWriteInterface($dir)
    {
        $fileSystem = Bootstrap::getObjectManager()->create(\Magento\Framework\Filesystem::class);

        return $fileSystem->getDirectoryWrite($dir);
    }
}

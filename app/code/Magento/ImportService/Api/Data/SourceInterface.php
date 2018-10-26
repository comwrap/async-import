<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface SourceInterface extends ExtensibleDataInterface
{
    const SOURCE_TYPE = 'source_type';
    const FILE_TYPE = 'file_type';
    const DATA = 'data';

    /**
     * @TODO Move to di.xml as pool arguments
     */
    const SOURCE_TYPE_LOCAL = 'local_path';
    const SOURCE_TYPE_URL = 'remote_url';
    const SOURCE_TYPE_ENCODED_DATA = 'base64_encoded_data';

    /**
     * Retrieve data source type (local_path, remote_url, base64_encoded_data)
     *
     * @return string
     */
    public function getSourceType();

    /**
     * Set data source type
     *
     * @param string $sourceType
     * @return $this
     */
    public function setSourceType($sourceType);

    /**
     * Retrieve data format (csv, xml, xls, json, etc.)
     *
     * @return string
     */
    public function getFileType();

    /**
     * Set source data file type (csv, xml, xls, json, etc.)
     *
     * @param string $fileType
     * @return $this
     */
    public function setFileType($fileType);

    /**
     * Retrieve file data (base64 encoded content)
     *
     * @return string
     */
    public function getData();

    /**
     * Set file data (http://domain/file.*, /path/to/file.*, base64_encode_data_string)
     *
     * @param string $data
     * @return $this
     */
    public function setData($data);
}

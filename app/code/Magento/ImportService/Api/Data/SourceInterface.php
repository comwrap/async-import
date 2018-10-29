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
    const TYPE = 'type';
    const FILE_TYPE = 'file_type';
    const IMPORT_DATA = 'import_data';

    /**
     * @TODO Move to di.xml as pool arguments
     */
    const TYPE_LOCAL = 'local_path';
    const TYPE_URL = 'remote_url';
    const TYPE_ENCODED_DATA = 'base64_encoded_data';

    /**
     * Retrieve data source type (local_path, remote_url, base64_encoded_data)
     *
     * @return string
     */
    public function getType();

    /**
     * Set data source type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type);

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
    public function getImportData();

    /**
     * Set file data (http://domain/file.*, /path/to/file.*, base64_encode_data_string)
     *
     * @param string $importData
     * @return $this
     */
    public function setImportData($importData);
}

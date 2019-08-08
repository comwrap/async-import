<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source;

use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;

/**
 *  Source Reader Interface
 */
interface ReaderInterface extends \SeekableIterator
{
    const FILE_PATH = 'file_path';
    const SOURCE = 'source';

    /**
     * @param SourceCsvInterface $source
     * @param $filePath
     *
     * @return void
     */
    public function init(SourceCsvInterface $source, $filePath);

    /**
     * @return string
     */
    public function getFilePath();

    /**
     * @param string $filePath
     *
     * @return $this
     */
    public function setFilePath(string $filePath);

    /**
     * @return SourceCsvInterface
     */
    public function getSource();

    /**
     * @param SourceCsvInterface $source
     *
     * @return $this
     */
    public function setSource(SourceCsvInterface $source);

}
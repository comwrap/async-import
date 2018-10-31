<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source\Type;

/**
 * CSV import adapter
 */
class LocalPath
{
    /**
     * @var string
     */
    private $file;

    /**
     * Open file and detect column names
     * There must be column names in the first line
     *
     * @param string $file
     * @throws \Exception
     */
    public function __construct($file = null)
    {
        if (!file_exists($file)) {
            throw new \Exception('File not exist');
        }
        $this->file = $file;
    }

    /**
     * Transform the object in the filename
     *
     * @return string
     */
    public function __toString()
    {
        return $this->file;
    }
}

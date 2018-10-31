<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Model\Source\Type;

/**
 * Parse encoded data and write to the temp file
 */
class EncodedData
{
    /**
     * @var string $file Full path to temporary file
     */
    private $file;

    /**
     * Create instance a temporary file and register auto delete function
     *
     * @param mixed $data
     */
    public function __construct($data = null)
    {
        $this->file = $this->create();
        register_shutdown_function([$this, 'delete']);
        if ($data) {
            $this->write(base64_decode($data));
        }
    }

    /**
     * Create file with unique name in temp directory
     *
     * @throws \Exception
     * @return string
     */
    private function create()
    {
        $filename = tempnam(sys_get_temp_dir(), 'php');
        if (!$filename) {
            throw new \Exception('The function tempnam() could not create a file in temporary directory.');
        }
        return $filename;
    }

    /**
     * Write the data to a file
     *
     * @param mixed $data
     * @param int $flags
     * @return int|false
     */
    public function write($data, $flags = 0)
    {
        return file_put_contents($this->file, $data, $flags);
    }

    /**
     * Append the data to the end of the file
     *
     * @param mixed $data
     * @return int|false
     */
    public function puts($data)
    {
        return $this->write($data, FILE_APPEND);
    }

    /**
     * Read entire file or chunk into a string
     *
     * @param int $offset
     * @param int $maxlen
     * @return string|false
     */
    public function read()
    {
        $args = array_merge(
            [$this->file],
            [false, null],
            func_get_args()
        );
        return file_get_contents(...$args);
    }

    /**
     * Delete a file
     *
     * @return bool
     */
    public function delete()
    {
        return @unlink($this->file);
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

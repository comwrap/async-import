<?php

namespace Magento\ImportService\Model\Logger;

use Magento\Framework\Filesystem\DriverInterface;
use Monolog\Logger;

class Error extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     *
     * @var int
     */
    protected $loggerType = Logger::ERROR;

    /**
     * File name
     *
     * @var string
     */
    protected $fileName = 'var/log/import_service/error.log';

    /**
     * @param DriverInterface $filesystem
     * @param string $filePath
     * @param string $fileName
     * @throws \Exception
     */
    public function __construct(
        \Magento\Framework\Filesystem\DriverInterface $filesystem,
        ?string $filePath = null,
        ?string $fileName = null
    ) {
        parent::__construct($filesystem, $filePath, $fileName);
    }
}

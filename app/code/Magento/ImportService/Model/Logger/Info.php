<?php

namespace Magento\ImportService\Model\Logger;

use Monolog\Logger;

class Info extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     *
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * File name
     *
     * @var string
     */
    protected $fileName = 'var/log/import_service/info.log';
}

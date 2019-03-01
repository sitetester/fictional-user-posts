<?php
declare(strict_types=1);

namespace Config\Helper;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class MonologHelper
{
    private static $logger;

    /**
     * Examples of channels might include ‘database’, ‘security’, ’business’ and others.
     */
    public static function getLogger(string $channel = 'my-channel'): LoggerInterface
    {
        if (self::$logger === null) {
            $logger = new Logger($channel);
            $logger->pushHandler(
                new StreamHandler(
                    __DIR__ . '/../../var/log/' . date('Y-m-d') . '.log',
                    Logger::DEBUG
                )
            );

            self::$logger = $logger;
        }

        return self::$logger;
    }
}



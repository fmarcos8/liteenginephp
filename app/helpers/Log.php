<?php

namespace App\helpers;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log
{
    private static $logger = null;

    private static function getLogger(): Logger
    {
        if (self::$logger == null) {
            self::$logger = new Logger("api_logger");
            $handler = new StreamHandler(__DIR__ . '/../../storage/logs/app.log');

            $output = "[%datetime%] %channel%.%level_name%: %message%\n";

            $formatter = new LineFormatter($output, null, true, true);

            $handler->setFormatter($formatter);

            self::$logger->pushHandler($handler);
        }

        return self::$logger;
    }

    private static function format($var): string
    {
        if (is_array($var) || is_object($var)) {
            return print_r($var, true);
        }

        return $var;
    }

    public static function debug(mixed $context): void
    {
        $data = self::format($context);
        self::getLogger()->debug($data);
    }

    public static function info(mixed $context): void
    {
        $data = self::format($context);
        self::getLogger()->info($data);
    }

    public static function error(mixed $context): void
    {
        $data = self::format($context);
        self::getLogger()->error($data);
    }

    public static function logException(\Throwable $exception): void
    {
        $formatter = self::formatException($exception);
        self::getLogger()->error($formatter);
    }

    public static function formatException(\Throwable  $exception): string
    {
        $result = sprintf("%s: %s in %s:%d\n[Stack trace]:%s\n",
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );

        return $result;
    }
}
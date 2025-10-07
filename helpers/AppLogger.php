<?php

namespace App\Helpers;

use Carbon\Carbon;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class AppLogger
{
    private static $instance = null;

    public static function logger(): Logger
    {
        if (self::$instance === null) {
            $current_date = Carbon::now()->format('y-m-d');
            $log_filename = "$current_date.txt";
            $log = new Logger('app');
            $log->pushHandler(new StreamHandler(__DIR__ . "/../logs/$log_filename", Logger::DEBUG));
            self::$instance = $log;
        }
        return self::$instance;
    }
}

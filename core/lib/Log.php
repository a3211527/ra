<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-18
 * Time: 下午2:58
 */

namespace core\lib;
class Log{
    public static function log($message, $file = 'error') {
        $logDir = LOG . '/' . date('Y-m-d') . '/' . date('H');
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
            file_put_contents($logDir . $file . '.txt', date('Y-m-d H:i:s')
                . "    " .json_encode($message) . PHP_EOL, FILE_APPEND);
        }
        else {
            file_put_contents($logDir . $file . '.txt', date('Y-m-d H:i:s')
                . "    " .json_encode($message) . PHP_EOL, FILE_APPEND);
        }
    }
}
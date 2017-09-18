<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-18
 * Time: 下午3:33
 * 错误处理
 */

namespace core\lib;

use core\lib\Log;

class Exc{
    public static function handing($message) {
        if (DEBUG) {
            p($message);
        }
        else {
            Log::log($message, 'error');
        }
    }
}
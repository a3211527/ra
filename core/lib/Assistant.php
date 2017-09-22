<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-21
 * Time: 上午8:54
 */

namespace core\lib;

class Assistant{
    public static function checkPost(array $vars) {
        foreach($vars as $val) {
            if (!isset($_POST[$val]) || empty($_POST[$val])) {
                return false;
            }
        }
        return true;
    }
    public static function checkGet(array $vars) {
        foreach ($vars as $val) {
            if (!isset($_POST[$val]) && empty($_POST[$val])) {
                return false;
            }
        }
        return true;
    }
}
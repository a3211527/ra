<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-18
 * Time: 上午10:36
 */

namespace core\lib;
use core\lib\Conf;
class Route {
    public static $ctrl;
    public static $action;

    public static function route() {
        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') {
            $path = $_SERVER['REQUEST_URI'];
            $pathArr = explode('/', trim($path, '/'));
            //获取controller
            if (array_key_exists(0, $pathArr)) {
                self::$ctrl = $pathArr[0];
            }
            else {
                self::$ctrl = Conf::get('ctrl', route);
            }
            //获取action
            if (array_key_exists(1, $pathArr)) {
                self::$action = $pathArr[1];
            }
            else {
                //todo
                //从配置文件route.conf中获取action
                self::$ctrl = Conf::get('action', 'route');
            }
            //将多余的参数转化为get
            if (array_key_exists(3, $pathArr)) {
                unset($pathArr[0]);
                unset($pathArr[1]);
                for ($i = 2; $i < count($pathArr) + 2; $i++) {
                    if (array_key_exists($i + 1)) {
                        $_GET[$pathArr[$i]] = $pathArr[$i + 1];
                    }
                }
            }
        }
        else {
            //ctrl
            //从配置文件中获取ctrl和action
            self::$ctrl = Conf::get('ctrl', 'route');
            self::$action = Conf::get('action', 'route');
        }
    }
}
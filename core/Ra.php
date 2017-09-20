<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-17
 * Time: 下午9:13
 */

namespace core;
use core\lib\Route;
use core\lib\Conf;
class Ra {
    public static function run() {
        Route::route();
        $ctrl = ucfirst(Route::$ctrl);
        $action = Route::$action;
        $ctrlFile = API . 'controller/' . $ctrl . 'Ctrl.php';
        $ctrlClass = 'api\controller\\' . $ctrl . 'Ctrl' ;
        if (file_exists($ctrlFile)) {

            if (method_exists($ctrlClass, $action)) {

                $ctrl = new $ctrlClass;
                $ctrl -> $action();
            }
            else {
                //todo
                //当不存在action时,从配置文件route中获取默认ctrl
                $action = Conf::get('action', 'route');
                $ctrl = new $ctrlClass;
                $ctrl -> $action();

            }
        }
        else {
            //todo
            //当不存在controller文件时，从配置文件中获取默认ctrl和action
            $ctrl = Conf::get('ctrl', 'route');
            $action = Conf::get('action', 'route');
            $ctrlClass = 'api\controller\\' . $ctrl . 'Ctrl';
            $ctrlObj = new $ctrlClass;
            $ctrlObj -> $action();
        }

    }
    /**
     * 自动加载
     */
    public static function load($className){
        $file = str_replace("\\", '/', $className);
        $path = RA . '/' . $file . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
        else {
            return false;
        }
    }
}
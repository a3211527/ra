<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-18
 * Time: 下午12:13
 * 获取配置信息
 */

//添加错误处理
namespace core\lib;

class Conf{
    public static $conf = array();

    /**
     * @param string $conf 配置名
     * @param string $file 配置文件
     * @return bool/string 配置值
     */
    public static function get($conf, $file = 'config') {
        if (array_key_exists($file, self::$conf)) {
            if (array_key_exists($conf, self::$conf[$file])) {
                return self::$conf[$file][$conf];
            }
            else {
                //todo
                //没有该配置项，查看公共配置文件config[$file][$conf]是否存在
                return self::getDefault($conf, $file);
            }
        }
        else {
            $path = CONF . $file .'.php';
            if (file_exists($path)) {
                $config = require_once $path;
                self::$conf[$file] = $config;
                if (array_key_exists($conf, $config)) {
                    return $config[$conf];
                }
                else {
                    //todo
                    //没有该配置项,查看公共配置文件config[$file][$conf]是否存在
                    return self::getDefault($conf,  $file);
                }
            }
            else {
                // //没有该配置文件,查看公共配置文件config[$file][$conf]是否存在
            }
        }
    }
    //从config文件中获取配置信息

    /**
     * @param string $conf 配置名
     * @param string $file 配置文件
     * @return bool/string 配置值
     */
    public static function getDefault($conf, $file) {
        if (array_key_exists('config', self::$conf)) {
            if (array_key_exists($conf, self::$conf['config'])) {
                return self::$conf['config'][$conf];
            }
            else {
                //todo 错误处理:config文件里边也没有这个配置项
                return false;
            }
        }
        else {
            $default = CONF . 'config.php';
            $config = require_once $default;
            self::$conf['config'] = $config;
            if (array_key_exists($file, $config)) {
                if (array_key_exists($conf, $config[$file])) {
                    return $config[$file][$conf];
                }
                else {
                    //todo 错误处理 ： config 里边的$file里边没有$conf这个配置项
                    return false;
                }
            }
            else {
                //todo 错误处理 : config文件里边没有$file这个配置项
                return false;
            }

        }
    }
}
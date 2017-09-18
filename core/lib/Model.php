<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-18
 * Time: 下午4:00
 */

namespace core\lib;
use core\lib\Conf;

class Model extends \PDO{
    private static $model;
    public function __construct() {
        $dsn = 'mysql:host=localhost; dbname=' . Conf::get('dbname', 'database');
        $user = Conf::get('user', 'database');
        $pass = Conf::get('password', 'database');
        try{
            parent::__construct($dsn, $user, $pass);
        }
        catch (\PDOException $e) {
            Exc::handing($e -> getMessage());
        }
    }
    public static function init() {
        if (self::$model instanceof Model) {
            return self::$model;
        }
        else {
            try {
                self::$model = new Model();
                self::$model -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$model -> query("SET NAMES utf8");
                return self::$model;
            }
            catch (\PDOException $e) {
                Exc::handing($e -> getMessage());
            }
        }

    }

    public static function dql($sql, $param){
        self::$model -> prepare($sql);
        $res = self::$model -> execute($param);
        $arr = array();
        if ($res) {
            while($row = $res -> fetch(\PDO::FETCH_ASSOC)) {
                $arr[] = $row;
            }
            return $arr;
        }
        else {
            return false;
        }

    }
    public function dml($sql, $param) {
        self::$model -> prepare($sql);
        $res = self::$model -> execute($param);
        return $res;
    }
}


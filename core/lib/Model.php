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
    private static $table;
    final public function __construct() {
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
    //初始化model,创建模型对象
    public static function init($table) {
        self::$table == $table ? : self::$table = $table;
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

    /**
     * @param string $column 查询的列
     * @param string $condition 查询条件,即sql语句中table后面的内容 where id=1, limit 0, 1, order by id等
     * @param array $param 预编译传入的值
     * @return array|bool 返回结果集 如果查询的结果返回结果数组
     */
    public static function select($column='*', $condition='', $param = array()){
        $sql = "select " . $column . " from " . self::$table .' ' . $condition;
        $stmt = self::$model -> prepare($sql);
        $res = $stmt -> execute($param);
        $arr = array();
        if ($res) {
            while($row = $stmt -> fetch(\PDO::FETCH_ASSOC)) {
                $arr[] = $row;
            }
            return $arr;
        }
        else {
            return false;
        }

    }

    /**
     * @param string $column 插入的列,默认为空,格式为 '(id, name)';
     * @param string $value 插入的值, 格式为"(1, 'otorain')", 或者使用预编译传参时,"(?, ?)";
     * @param array $param 预编译的参数
     * @return bool 返回结果
     */
    public static function insert($column = "", $value, $param = array()) {
        $sql = 'insert into ' . self::$table . $column . ' values ' . $value;
        $stmt = self::$model -> prepare($sql);
        $res = $stmt -> execute($param);
        return $res;
    }

    public static function getInsertId() {
        return self::$model -> lastInsertId();
    }

    /**
     * @param $condition 删除的条件, 如 'where id = 1' 或 预编译形式 'where id = ?'
     * @param array $param 使用预编译传入的值， 如array(1)
     * @return mixed
     */
    public static function delete($condition, $param=array()) {
        $sql = 'delete from ' . self::$table . ' ' . $condition;
        $stmt = self::$model -> prepare($sql);
        $res = $stmt -> execute($param);
        return $res;
    }

    /**
     * 删除某张表的所有数据，慎用！！！
     * @return bool 返回结果
     */
    public static function deteleAll() {
        $sql = 'delete from ' . self::$table;
        $stmt = self::$model -> prepare($sql);
        $res = $stmt -> execute();
        return $res;
    }

    /**
     * @param string $change 变更的项, 如 'name = otorain, age = 20' 或 'name=?, age=?'
     * @param string $condition 条件, 如 'id = 1' 或 'id=?'
     * @param array $param 默认为空，预编译时传入的变量 当使用预编译传参时, 则格式如, array('otorain', 20, 1)
     * @return bool 返回结果
     */
    public static function update($change, $condition = '', $param = array()) {
        $sql = 'update ' . self::$table . ' set ' . $change . ' ' . $condition;
        $stmt = self::$model -> prepare($sql);
        $res = $stmt -> execute($param);
        return $res;
    }
}


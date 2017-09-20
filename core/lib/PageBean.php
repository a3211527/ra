<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-18
 * Time: 下午5:36
 */
namespace core\lb;
use core\lib\Conf;

class PageBean{
    private static $rowStart;
    private static $rowCount;
    private static $pageNow;
    private static $pageCount;
    private static $pageSize;
    private static $res;

    //从配置文件中获取pageSize并将其设为$pageSize的值
    public static function setPageSize(){
        if (Conf::get('pageSize', 'splitPage')) {
            self::$pageSize = Conf::get('pageSize', 'splitPage');
        }
        else{
            die("请查看分页配置文件中是否配置该项");
        }
    }
    //获取pageSize的值
    public static function getPageSize() {
        return self::$pageSize;
    }
    //设置总行数
    public static function setRowCount() {

    }
    //获取总行数
    public static function getRowCount() {
        return self::$rowCount;
    }
    //设置总页数
    public static function setPageCount() {
        if (isset(self::$rowCount) && isset(self::$pageSize)) {
            self::$pageCount = ceil(self::$rowCount / self::$pageSize);
        }
        else {
            die("请检查总行数是否已经设置");
        }
    }
    //获取总页数
    public static function getPageCount() {
        return self::$pageCount;
    }
    //设置当前页数
    public static function setPageNow($pageNow) {
        if (is_numeric($pageNow)) {
            self::$pageNow = $pageNow;
        }
        else {
            self::$pageNow = 1;
        }
    }
    //设置当前页起始行
    public static function setRowStart() {
        if (self::$pageNow && self::$pageSize) {
            self::$rowStart = (self::$pageNow - 1) * self::$pageSize;
        }
        else {
            die("请检查是否设置了pageSize和pageNow");
        }
    }
    //获取当前页起始行数
    public static function getRowStart() {
        return self::$rowStart;
    }
}
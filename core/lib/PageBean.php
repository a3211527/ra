<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-18
 * Time: 下午5:36
 */
namespace core\lib;
use core\lib\Conf;
use api\model\Article;

class PageBean{
    private static $rowStart;
    private static $rowCount;
    private static $pageNow;
    private static $pageCount;
    private static $pageSize;
    private static $res;
    private static $pageNowCount;

    //从配置文件中获取pageSize并将其设为$pageSize的值
    public static function setPageSize(){
        if (Conf::get('pageSize', 'pageBean')) {
            self::$pageSize = Conf::get('pageSize', 'pageBean');
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
        Article::init();
        $countRes = Article::select('count(a_id)');
        if ($countRes) {
            $count = $countRes[0]['count(a_id)'];
            self::$rowCount = $count;
        }
        else {
            return false;
        }

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

    //获取结果集
    public static function getRes(){
        Article::init();
        self::$res = Article::select('a_id, u_name, write_date, title, content, type, pv, comment, encourage, 
        admiration, title', 'limit ' . self::$rowStart .', '. self::$pageSize) ;
        return self::$res;
    }
    //获取当前页有多少条记录
    public static function getPageNowCount() {
        if (self::$pageNow == self::$pageCount) {
            self::$pageNowCount = self::$rowCount % self::$pageSize;
            if (self::$pageNowCount === 0) {
                self::$pageNowCount = self::$pageSize;
            }
            return self::$pageNowCount;
        }
        else {
            self::$pageNowCount = self::$pageSize;
            return self::$pageNowCount;
        }
    }
}
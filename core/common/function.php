<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-18
 * Time: 下午3:50
 * 打印数据到页面的函数
 */


function p($var){
    if(is_bool($var)) {
        var_dump($var);
    }
    else if(is_null($var)) {
        var_dump(NULL);
    }
    else{
        echo '<pre style="position=relative; z-index: 1000; padding: 10px; 
        border-radius: 5px; background:#f5f5f5; border: 1px solid #AAA; font-size: 14px; 
        line-height: 16px; opacity: 0.9">' . print_r($var, true) . '</pre>';
    }
}
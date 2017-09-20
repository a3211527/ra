<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-19
 * Time: 下午7:10
 */

namespace api\model;
use core\lib\Model;

class User extends Model{
    public static function init(){
        parent::init('user');
    }
}
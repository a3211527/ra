<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-22
 * Time: 上午11:42
 */

namespace api\model;
use core\lib\Model;

class Reply extends Model{
    public static function init() {
        parent::init('reply');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-22
 * Time: 上午10:55
 */

namespace api\model;
use core\lib\Model;

class Comment extends Model{
    public static function init() {
        parent::init('comment');
    }
}
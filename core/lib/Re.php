<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-18
 * Time: 下午4:42
 */
namespace core\lib;
use core\lib\Conf;
class Re{
    public function get($code, $message, $data=array()){
        $type = Conf::get('type', 'api');
        if ($type == 'json') {
            if(!is_numeric($code)) {
                return false;
            }
            else {
                $result = array(
                    'code'      => $code,
                    'message'   => $message,
                    'data'      => $data,
                );
                echo json_encode($result, JSON_UNESCAPED_UNICODE);
            }
        }
    }
}
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
    public static function get($code, $message, $data=array()){
        $type = Conf::get('type', 'api');
        if ($type == 'json'){
            self::getJson($code, $message, $data);
        }
        else if($type == 'xml'){
            self::getXml($code, $message, $data);
        }
    }
    public static function getJson($code, $message, $data=array()) {
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
    public static function getXml($code, $message, $data) {
        if (!is_numeric($code)) {
            return false;
        }
        else {
            header("Content-type: text/xml");
            $sxml = new \SimpleXMLElement("<?xml version='1.0', encoding='utf-8' ?><root />");
            $codeIt = $sxml -> addChild("code", $code);
            $messageIt = $sxml -> addChild("message", $message);
            $dataIt = $sxml -> addChild("data");
            if (is_array($data)) {
                foreach($data as $key => $value) {
                    if (is_numeric($key)) {
                       $item = $dataIt ->  addChild('item', $value);
                       $item -> addAttribute('id', $key);
                    }
                    else {
                        $dataIt -> addChild($key, $value);
                    }
                }
            }
            echo $sxml -> asXML();
        }
    }
}
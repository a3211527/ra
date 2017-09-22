<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-20
 * Time: 下午7:56
 */

namespace core\lib;

class AdminArticle {
    public static function save($article, $articleId, $user) {
        $articleDir = ARTICLE . $user;
        if(!is_dir($articleDir)) {
            mkdir($articleDir, 0777, true);
            chmod(ARTICLE,0777);
            chmod(DATA, 0777);
            chmod($articleDir, 0777);
            $filename = $articleDir . '/' . $articleId . '.txt';
            $article = htmlentities($article, ENT_QUOTES, 'UTF-8');
            $res = file_put_contents($filename, $article);
            chmod($filename, 0777);
            return $res;
        }
        else {
            $article = htmlentities($article, ENT_QUOTES, 'UTF-8');
            $filename = $articleDir . '/' . $articleId . '.txt';
            $res = file_put_contents($filename, $article);
            chmod($filename, 0777);
            return $res;
        }
    }
    public static function get($articleId, $user){
        $article = ARTICLE . $user . '/' . $articleId . '.txt';
        return file_get_contents($article);
    }
}
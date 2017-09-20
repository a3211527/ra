<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-20
 * Time: 下午7:56
 */

namespace core\lib;

class Article {
    public static function save($article, $articleId, $user) {
        $articleDir = ARTICLE . $user;
        if(！is_dir($articleDir)) {
            mkdir($articleDir, 0777, true);
        }
        else {
            $article = htmlentities($article, ENT_QUOTES, 'UTF-8');
            file_put_contents($articleDir . '/' . $articleId . '.txt', $article);
        }
    }
    public static function get($articleId, $user){
        $article = ARTICLE . $user . '/' . $articleId . '.txt';
        return file_get_contents($article);
    }
}
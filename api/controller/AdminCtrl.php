<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-20
 * Time: 下午9:08
 */

namespace api\controller;
use core\lib\Assistant;
use core\lib\Re;
use core\lib\AdminArticle;
use api\model\Article;

class AdminCtrl {
    /**
     * 保存文章接口
     */
    public function saveArticle() {
        /**
         * post: u_name, type, content, status
         * db:u_name, type, pv, admiration, reward, content, write_date, status
         */
        if (Assistant::checkPost(array('username', 'type', 'content', 'status', 'collection', 'title'))) {
            $username = $_POST['username'];
            $type =  $_POST['type'];
            $content = $_POST['content'];
            $status = $_POST['status'];
            $collection = $_POST['collection'];
            $title = $_POST['title'];
            Article::init();
            $maxIdRes = Article::select('max(article_id)');
            $maxId = $maxIdRes[0]['max(article_id)'];
            if ($maxId) {
                $articleId = $maxId + 1;
            }
            else {
                $articleId = 1;
            }
            $articlePath = ARTICLE . $username . '/' . $articleId . '.txt';
            $isSaveFile = AdminArticle::saveArticle($content, $articleId, $username);
            if (!$isSaveFile) {
                Re::get(200, '保存到文件中时失败');
            }
            else {
                $isSaveDb = Article::insert('(username, title, type, collection, pv, encourage, comment, 
                admiration, reward, content, write_date, status)', '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                        array($username, $title, $type, $collection, 0, 0, 0, 0, 0, $articlePath, time(), $status));
                if ($isSaveDb) {
                    $data = array(
                        'articleId' => $articleId
                    );
                    Re::get(200, '保存成功', $data);
                }
                else {
                    Re::get(200, '保存失败');
                }
            }
        }
        else {
            Re::get(200, '信息不完整');
        }
    }

    //保存评论接口
    public function saveComment() {
        if (Assistant::checkPost(array('articleId', 'comment', 'username'))) {
            $articleId = $_POST['articleId'];
            $comment = $_POST['comment'];
            $username = $_POST['username'];
            $saveCommentRes = AdminArticle::saveComment($articleId, $comment, $username);
            if ($saveCommentRes) {
                Re::get(200, '保存评论成功', $saveCommentRes);
            }
            else {
                Re::get(200, '保存评论失败');
            }
        }
    }
    //保存二级评论
    public function saveReply() {
        if (Assistant::checkPost(array('commentId', 'fromUser', 'toUser', 'reply'))) {
            $commentId = $_POST['commentId'];
            $fromUser = $_POST['fromUser'];
            $toUser = $_POST['toUser'];
            $reply = $_POST['reply'];
        }
        else {
            Re::get(200, '信息不完整');
        }
        $res = AdminArticle::saveReply($commentId, $fromUser, $toUser, $reply);
        if ($res) {
            Re::get(200, '保存成功');
        }
        else {
            Re::get(500, '保存失败');
        }
    }
}
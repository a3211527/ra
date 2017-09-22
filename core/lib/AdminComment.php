<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-21
 * Time: 下午12:16
 */

namespace core\lib;
use api\model\Comment;
use core\lib\Re;
use api\model\Reply;

class AdminComment {
    public static function save($articleId, $comment, $username) {
        Comment::init();
        $maxCommentIdRes = Comment::select('max(comment)');
        $maxCommentId = $maxCommentIdRes[0]['max(comment)'];
        $commentId = $maxCommentId + 1;
        $res = Comment::insert('comment_id, article_id, username, comment, comment_date',
            '(?, ?, ?, ?, ?)', array($commentId, $articleId, $username, $comment, time()));
        if ($res) {
            return true;
        }
        else {
            return false;
        }
    }
    public static function get($articleId) {
        Comment::init();
        $commentRes = Comment::select('comment_id, comment, comment_date, username',
            'where article_id=? order by comment_date', array($articleId));
        if ($commentRes) {
            Reply::init();
            for ($i = 0; $i < count($commentRes); $i++) {
                $replyRes = Reply::select('from_user, to_user, reply, reply_date', 'where comment_id=? 
            order by reply_date', array($commentRes[0]['comment_id']));
                if ($replyRes) {
                    $commentRes[0]['reply'] = $replyRes;
                }
            }
            return $commentRes;
        }
        else {
            return false;
        }
    }
}
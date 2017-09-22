<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-20
 * Time: 下午7:56
 */

namespace core\lib;
use api\model\Comment;
use api\model\Reply;

class AdminArticle {
    /**
     * 保存文章
     * @param string $article 文章内容
     * @param int $articleId 文章ID
     * @param string $user
     * @return bool|int
     */
    public static function saveArticle($article, $articleId, $user) {
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
    public static function getArticle($articleId, $user){
        $article = ARTICLE . $user . '/' . $articleId . '.txt';
        return file_get_contents($article);
    }
    public static function saveComment($articleId, $comment, $username) {
        Comment::init();
        $maxCommentIdRes = Comment::select('max(comment)');
        $maxCommentId = $maxCommentIdRes[0]['max(comment)'];
        $commentId = $maxCommentId + 1;
        $res = Comment::insert('comment_id, article_id, username, comment, comment_date',
            '(?, ?, ?, ?, ?)', array($commentId, $articleId, $username, $comment, time()));
        return $res;
    }
    public static function getComment($articleId) {
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
    //保存二级评论
    public static function saveReply($commentId, $fromUser, $toUser, $reply) {
        Reply::init();
        $maxReplyIdRes = Reply::select('max(reply_id)');
        $maxReplyId = $maxReplyIdRes[0]['reply_id'];
        $replyId = $maxReplyId + 1;
        $saveReplyRes = Reply::insert('', '(?, ?, ?, ? ,? ,?)', array($replyId, $commentId, $fromUser, $toUser. $reply, time()));
        return $saveReplyRes;
    }
}
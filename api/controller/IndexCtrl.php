<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-18
 * Time: 上午11:30
 */
namespace api\controller;
use core\lib\AdminArticle;
use core\lib\PageBean;
use core\lib\Assistant;
use core\lib\Re;
use api\model\Article;

class IndexCtrl{
    public function index(){

    }
    public function getArticle() {
        if (Assistant::checkGet(array('articleId', 'username'))) {
            $articleId = $_GET['articleId'];
            $username = $_GET['username'];
            $content = AdminArticle::getArticle($articleId, $username);
            Article::init();
            $res = Article::select('type, pv, admiration, reward, write_date, status, encourage, title',
                'where articleId=?', array($articleId));
            if ($content) {
                $commentRes = AdminArticle::getComment($articleId);
                $data = array(
                    'content'       => $content,
                    'username'      => $res[0]['username'],
                    'type'          => $res[0]['type'],
                    'pv'            => $res[0]['pv'],
                    'encourage'     => $res[0]['encourage'],
                    'admiration'    => $res[0]['admiration'],
                    'date'          => $res[0]['write_date'],
                    'status'        => $res[0]['status'],
                    'title'         => $res[0]['title'],
                    'comment_sum'   => $res[0]['comment'],
                    'comment'       => $commentRes,
                );
                Re::get(200, '获取内容成功', $data);
            }
            else {
                Re::get(200, '获取内容失败');
            }
        }
        else {
            Re::get(200, '信息不完整');
        }
    }
    public function getPageBean(){
        if (Assistant::checkGet(array('pageNow'))) {
            $pageNow = $_POST['pageNow'];
            $res = array();
            PageBean::setPageSize();
            PageBean::setRowCount();
            PageBean::setPageCount();
            PageBean::setPageNow($pageNow);
            PageBean::setRowStart();
            $pageNowCount = PageBean::getPageNowCount();
            $rowCount = PageBean::getRowCount();
            $pageCount = PageBean::getPageCount();
            $pageBeanRes = PageBean::getRes();
            for ($i = 0; $i < $pageNowCount; $i++) {
                $fp = fopen($pageBeanRes[$i]['content'], 'r');
                if (!feof($fp)) {
                    $con = fread($fp, 25);
                }
                $pageBeanRes[$i]['content'] = $con;
                fclose($fp);
            }

            $data = array(
                'rowCount'   => $rowCount,
                'pageCount'  => $pageCount,
                'data'       => $res,
            );
            Re::get(200, '获取数据成功', $data);
        }
        else {
            Re::get(200, '缺少参数');
        }
    }
    //获取评论接口
    public function getComment() {
        if (Assistant::checkGet(array('articleId'))) {
            $articleId = $_POST['articleId'];
            $res = AdminArticle::getComment($articleId);
            if ($res) {
                Re::get(200, '获取评论成功', $res);
            }
            else {
                Re::get(500, '获取评论失败');
            }

        }
        else {
            Re::get(200, '获取评论失败');
        }
    }
    public function test() {
        /*User::init();
        $res = User::select();
        p($res);*/
        //AdminComment::save('','','');
        //if (Assistant::checkGet(array('articleId'))) {
            $articleId = 1;//$_GET['articleId'];
            $data = AdminComment::get($articleId);
            Re::get(200, '获取评论成功', $data);
        //}


    }
}
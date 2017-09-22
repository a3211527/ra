<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-20
 * Time: 下午3:15
 */

namespace api\controller;
use api\model\User;
use core\lib\Re;
use core\lib\Assistant;

class LoginCtrl {
    public function login(){
        if (Assistant::checkPost(array('username'))) {
            if (Assistant::checkPost(array('password'))) {
                $username = $_POST['username'];
                $password = md5($_POST['password']);
                User::init();
                $res = User::select('user_pass', "where user_name = ?", array($username));
                if ($res) {
                    $u_pass = $res[0]['user_pass'];
                    if ($password == $u_pass) {
                        $res = User::select("user_id", 'where username=?',array($username));
                        $userId = $res[0]['user_id'];
                        $data = array('user_id' => $userId, 'username' => $username);
                        Re::get(200, '登录成功', $data);
                    }
                    else {
                        Re::get(200, '登录失败');
                    }
                }
                else {
                    Re::get(200, '登录失败');
                }
            }
            else {
                Re::get(200, '密码为空');
            }
        }
        else {
            Re::get(200, '用户名为空');
        }
    }
    public function check() {
        if (Assistant::checkPost(array('username'))) {
            $username = $_POST['username'];
            User::init();
            $res = User::select('count(user_id)', 'where username=?', array($username));
            $count = $res[0]['count(user_id)'];
            if ($count != 0) {
                Re::get(200, '该用户名已被注册');
            }
            else {
                Re::get(200, '该用户名可用');
            }

        }
        else {
            Re::get(200, '用户名为空');
        }

    }
    public function register() {
        if (Assistant::checkPost(array('username'))) {
            if (Assistant::checkPost(array('password'))) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                if (strlen($password) < 6) {
                    Re::get(200, '注册失败,密码长度小于6位');
                }
                else {
                    User::init();
                    $res = User::select('count(user_id)', 'where username=?', array($username));
                    if ($res[0]['count(user_id)'] == 0) {
                        $result = User::insert('(username, user_pass)', '(?, ?)', array($username, md5($password)));
                        if ($result) {
                            $insertId = User::getInsertId();
                            $data = array(
                                'user_id' => $insertId,
                            );
                            Re::get(200, '注册成功', $data);
                        }
                        else {
                            Re::get(500, '注册失败');
                        }
                    }
                    else {
                        Re::get(200, '用户名已存在');
                    }
                }
            }
            else {
                Re::get(200, '密码为空');
            }
        }
        else {
            Re::get(200, '用户名为空');
        }
    }
}
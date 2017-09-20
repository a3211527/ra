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

class LoginCtrl {
    public function login(){
        if (isset($_POST['username']) && $_POST['username']) {
            if (isset($_POST['password']) && $_POST['password']) {
                $username = $_POST['username'];
                $password = md5($_POST['password']);
                User::init();
                $res = User::select('u_pass', "where u_name = ?", array($username));
                if ($res) {
                    $u_pass = $res[0]['u_pass'];
                    if ($password == $u_pass) {
                        $res = User::select("u_id", 'where u_name=?',array($username));
                        $u_id = $res[0]['u_id'];
                        $data = array('u_id' => $u_id, 'u_name' => $username);
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
        if (isset($_POST['username']) && $_POST['username']) {
            $username = $_POST['username'];
            User::init();
            $res = User::select('count(u_id)', 'where u_name=?', array($username));
            $count = $res[0]['count(u_id)'];
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
        if (isset($_POST['username']) && $_POST['username']) {
            if (isset($_POST['password']) && $_POST['password']) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                User::init();
                $res = User::select('count(u_id)', 'where u_name=?', array($username));
                if ($res[0]['count(u_id)'] == 0) {
                    $result = User::insert('(u_name, u_pass)', '(?, ?)', array($username, $password));
                    if ($result) {
                            Re::get(200, '注册成功');
                    }
                    else {
                        Re::get(500, '注册失败');
                    }
                }
                else {
                    Re::get(200, '用户名已存在');
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
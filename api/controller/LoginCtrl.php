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
            $username = $_POST['username'];
            if (isset($_POST['password']) && $_POST['password']) {
                $password = md5($_POST['password']);
                User::init();
                $res = User::select('u_pass', "where u_name = ?", array($username));
                if ($res) {
                    $u_pass = $res[0]['u_pass'];

                    if ($password == $u_pass) {
                        Re::get(200, '登录成功');
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

    public function register() {
        if (isset($_POST['username']) && $_POST['username']) {

        }
        else {

        }
    }
}
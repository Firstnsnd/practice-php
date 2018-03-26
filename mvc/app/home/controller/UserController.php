<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-26
 * Time: 下午3:34
 */
namespace home\controller;

use core\Controller;
use home\model\UserModel;
/**
 * 用户控制器
 */
class UserController extends Controller
{
    public function index()
    {
        $model = new UserModel();
        if ($model->save(['name'=>'hello','password'=>'shiyanlou'])) {
//            $model->free();    //释放连接
            echo "Success";
        } else {
//            $model->free();    //释放连接
            echo 'Failed';
        }
    }
}

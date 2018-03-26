<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-26
 * Time: 下午3:29
 */
namespace home\controller;

use core\Controller;
/**
 * index控制器
 */
class IndexController extends Controller
{
    public function index()
    {
        $this->assign('name','shiyanlou---Admin');    //模板变量赋值
        $this->display();    //模板展示
    }
}
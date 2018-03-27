<?php 
namespace home\controller;

use core\Controller;
use home\model\UserModel;
/**
* yong
*/
class UserController extends Controller
{
	
	function __construct()
	{
		echo " I am user controller!";
	}
	public function index()
	{
		$model = new UserModel();
		if ($model->save(['name'=>'hello','password'=>'shiyanlou'])) {
			$this->success('Success','/');	//执行成功，弹出信息，跳转至首页
		} else {
          $this->error('Error');	//操作失败，弹出错误消息，执行跳转操作，默认上一页，若没有上一页，当前页面将会一直报错
		}
	}
}
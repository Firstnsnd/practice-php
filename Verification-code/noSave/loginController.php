<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-20
 * Time: 下午9:25
 */
//前面不能有输出，因此至于顶部
session_start();
// 接收ajax传递过来的数据
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

// 接收到的验证码，全部转换为小写
$validateCode = strtolower($_REQUEST['validateCode']);

// 首先判断验证码是否存在
if(!isset($_SESSION['session_validate_code'])){
    echo json_encode('0');
    exit;
}
//取出保存在类属性code中的这段字符
$session_validate_code = $_SESSION['session_validate_code'];

// 进行对比校验
if($validateCode != $session_validate_code){
    echo json_encode('0');
    exit;
}


if($username != 'shiyanlou' || $password != 'shiyanlou'){
    echo json_encode('00');
    exit;
}

// 销毁保存在session中的本次验证码
if(isset($_SESSION['session_validate_code'])){
    unset($_SESSION['session_validate_code']);
}

echo json_encode('1');
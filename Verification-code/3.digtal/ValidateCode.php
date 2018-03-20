<?php

//include 'ValidateCode.class.php';
//
////实例化ValidateCode类，同时调用doimg方法生成验证码
//$validateCode = new ValidateCode();
//$validateCode->doimg();

/*
 * 存储运算结果
 * */
//前面不能有输出，因此至于顶部
session_start();
// 调用ValidateCode类
include 'ValidateCode.class.php';

//实例化ValidateCode类，同时调用doimg方法生成验证码
$validateCode = new ValidateCode($height = 110, $width = 33);
// 把该端字符保存在session中，用于校验
$code = $validateCode->getCode();
$multiplier_left = substr($code,0,1);
$operators = substr($code,1,1);
$multiplier_right = substr($code,2,1);
// 进行算数运算
eval("\$res = $multiplier_left $operators $multiplier_right;");
$_SESSION['session_validate_code'] = $res;
$validateCode->doimg();
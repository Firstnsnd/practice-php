<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-20
 * Time: 下午5:29
 */
// 调用ValidateCode类
include 'ValidateCode.class.php';

//实例化ValidateCode类，同时调用doimg方法生成验证码
$validateCode = new ValidateCode();
$validateCode->doimg();

<?php
// 调用ValidateCode类
include 'ValidateCode.class.php';

//实例化ValidateCode类，同时调用doimg方法生成验证码
$validateCode = new ValidateCode($height=110,$width=33);
$validateCode->doimg();
?>

<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-26
 * Time: 上午9:40
 */
header("Content-Type:text/html;charset=UTF-8");
$phoneNum =  $_GET['phoneNum'];
include 'nowapi.class.php';
$nowapi_parm['app']='phone.get';
$nowapi_parm['phone']='18428327404';
$nowapi_parm['appkey']='32162';   //更改你的appkey
$nowapi_parm['sign']='481b7ec77f1d71e57a3fb78650d5c1a4';  //更改你的sign
$nowapi_parm['format']='json';
$nowapi=new nowapi();
$result = $nowapi->nowapi_call($nowapi_parm);
echo json_encode($result);
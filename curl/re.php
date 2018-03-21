<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-21
 * Time: 下午4:03
 */
//1.初始化，创建一个新cURL资源
$curl=curl_init();
//2.设置URL和相应的选项,我们采集`https://www.shiyanlou.com/`页面
curl_setopt($curl, CURLOPT_URL, "https://www.shiyanlou.com/courses/");
//如果你想把一个头包含在输出中，设置这个选项为一个非零值
curl_setopt($curl, CURLOPT_HEADER, 1);
// 执行之后不直接打印出来
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// 跳过证书检测 0 或 false
curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
//3.执行并获取结果
$resault=curl_exec($curl);
//释放CURL

curl_close($curl);
//匹配样式是course-title的span把标题赋值给变量
preg_match_all("/<div class=\"course-name\"(.*?)<\/div>/",$resault, $title);
//打印出数组$title
print_r($title);


//匹配标题和图片
preg_match_all("/<div class=\"course-name\"(.*?)>(.*?)<\/div>/",$resault, $out, PREG_SET_ORDER);
preg_match_all("/https\:\/\/dn-simplecloud.shiyanlou.com\/(.*?)g/",$resault, $img, PREG_SET_ORDER);

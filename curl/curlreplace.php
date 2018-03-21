<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-21
 * Time: 下午3:47
 */
//1.初始化，创建一个新cURL资源
$curl=curl_init();
//2.设置URL和相应的选项,我们采集`https://www.shiyanlou.com/`页面
curl_setopt($curl, CURLOPT_URL, "https://www.shiyanlou.com/");
//因为实验楼的地址为https,所以参数为 false 代表不检查ssl证书
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//如果你想把一个头包含在输出中，设置这个选项为一个非零值
curl_setopt($curl, CURLOPT_HEADER, 0);
// 执行之后不直接打印出来
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//3.执行并获取结果
$resault=curl_exec($curl);
//4.释放CURL
curl_close($curl);
//把页面中的实验楼修改为我喜欢在实验楼学习
echo str_replace("实验楼","我喜欢在实验楼学习",$resault);


<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-26
 * Time: 下午5:32
 */
//引入Iamge类文件
include 'image.class.php';

//$filepath = 'image.jpg';
//$image = new Image($filepath);
////60是透明度参数默认设置为0
//$image->waterMark('shuiyin.png', 60);
//$image->show();
//$image->save('sc_shuiyintu');

//缩略图
$filepath = 'image.jpg';
$image = new Image($filepath);
$image->thumbnail(600, 300);
$image->show();
$image->save('sc_suoluetu');
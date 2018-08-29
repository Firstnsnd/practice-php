<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2016-03-23 20:32:38
 * @version $Id$
 */

//打开

//配置图片路径
$src="./image/2.jpg";
//获取信息、
$info=getimagesize($src);
//3.获取图片的类型
$type=image_type_to_extension($info[2],false);
//内存中创建图片
$fun="imagecreatefrom{$type}";
//5.吧要操作的图片复制到内存
$image=$fun($src);


//操作
//设置水印
$image_mark="26.png";
//水印基本信息
$info2=getimagesize($image_mark);
//水印的图片类型
$type2=image_type_to_extension($info2[2],false);
//在内存中创建与水印一致的图片类型
$fun2="imagecreatefrom{$type2}";
//将水印复制到内存中
$water=$fun2($image_mark);
//合并图片
imagecopymerge($image, $water,20, 30, 0, 0, $info2[0] ,$info2[1], 20);
//销毁水印图
imagedestroy($water);

//输出图片
//浏览器输出
//ob_clean();//清空缓冲区
 header("Content-type:".$info['mime']);//告诉浏览器输出图片
 $func="image{$type}";
 $func($image);
//保存图片
 $func($image,'watenew.'.$type);
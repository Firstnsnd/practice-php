<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-26
 * Time: 下午5:00
 */
//打开图像
$image_path = 'image.jpg';
$image_info = getimagesize($image_path);


//输出图像信息
//echo "<pre>";
//print_r($image_info);
//echo "</pre>";

//取得图像类型的文件后缀
$image_type = image_type_to_extension($image_info[2], false);
//在内存中，创建动态图像
$image_fun = "imagecreatefrom$image_type";
$image = $image_fun($image_path);

$image2_path = 'shuiyin.png';
$image2_info = getimagesize($image2_path);
//取得图像类型的文件后缀
$image2_type = image_type_to_extension($image2_info[2], false);
//在内存中，创建动态图像
$image2_fun = "imagecreatefrom$image2_type";
$image2 = $image2_fun($image2_path);

//操作图像
//获取image和shuiyin的宽高
$image_x = imagesx($image);
$image_y = imagesy($image);
$image2_x = imagesx($image2);
$image2_y = imagesy($image2);
//水印定位到右下角
$x = $image_x - $image2_x;
$y = $image_y - $image2_y;
imagecopy($image, $image2, $x, $y, 0, 0, $image2_info[0], $image2_info[1]);
//销毁水印图像
imagedestroy($image2);

// 输出图像
header('Content-type:',$image_info['mime']);
$funs = "image$image_type";
$funs($image, null, 100);

//输出图像
//浏览器输出
// header('Content-type:',$image_info['mime']);
// $funs = "image$image_type";
// $funs($image, null, 100);

//保存在本地
$funs = "image$image_type";
$funs($image,'watermark.'.$image_type);
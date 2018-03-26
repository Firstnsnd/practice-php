<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-26
 * Time: 下午5:25
 */
// 获取图片路径、以及设置缩略的宽高
$filename = "image.jpg";
$xmax = 500;
$ymax = 400;

// 开打图像
$image_info = getimagesize($filename);

// 获取图像类型
$type = image_type_to_extension($image_info[2], false);

// 在内存中，创建一个图像对应的图像类型创建一个新图像
$imagecreate = "imagecreatefrom$type";

// 把图像复制到内存中
$image = $imagecreate($filename);


//操作图像
//获取原图的高度和宽度
$x = imagesx($image);
$y = imagesy($image);



//按比例缩放
if($x >= $y) {
    $newx = $xmax;
    $newy = $newx * $y / $x;
}
else {
    $newy = $ymax;
    $newx = $x / $y * $newy;
}

//创建新图像
$image2 = imagecreatetruecolor($newx, $newy);

// 复制图像进行缩略
imagecopyresized($image2, $image, 0, 0, 0, 0, floor($newx), floor($newy), $x, $y);

// 销毁图像
imagedestroy($image);
// 输出图像
header("Content-type: image/png");
header('Content-type:',$image_info['mime']);
$funs = "image$type";
$funs($image2);
// 销毁图像
imagedestroy($image2);
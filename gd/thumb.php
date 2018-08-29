<?php
//实现图片那缩略
$src='./image/3.jpg';
$info=getimagesize($src);
$type=image_type_to_extension($info[2],false);
$fun="imagecreatefrom{$type}";
$image=$fun($src);

//在内存中建立一个宽300,高200的真色彩图片
$image_thumb=imagecreatetruecolor(300, 200);
//将原图复制到新建的真色彩图片上
imagecopyresampled($image_thumb, $image, 0, 0, 0, 0, 300, 200, $info[0], $info[1]);
imagedestroy($image);
//
header("Content-type:".$info['mime']);
$funs="image{$type}";
$funs($image_thumb);
$funs($image_thumb,"thumb.".$type);
imagedestory($image_thumb);
?>
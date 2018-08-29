<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2016-03-23 22:22:57
 * @version $Id$
 */
require "image.class.php";
$src="./image/4.jpg";

//图片水印
$source="26.png";

$image=new image($src);

//压缩图片
//$image-thumb(300,200);

//文字水印
// $content="你好，时光";
// $font_url="./font/Yahei.ttf";
// $size=20;
// $color=array(
// 	0=>255,
// 	1=>255,
// 	2=>255,
// 	3=>10
// 	);
//$angle=10;
$local=array(
	'x'=>20,
	'y'=>40
	);
//$image->fontmark($content,$font_url,$size,$color,$local,$angle);

//图片水印
$alpha=30;
$image->imagemark($source,$local,$alpha);
$image->show();
//$image->save(newnamefont);


<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2016-03-23 18:39:41
 * @version $Id$
 */
header('Content-type:text/html;charset=utf8');
/**
 * 四个步骤
 1打开图片
 2.操作图片
 3输出图片
 4.销毁图片
 */

//  /**
//   * 1.打开图片
//   */
 //1.配置图片路径(要操作的图片路径)
 $src="./image/1.jpg";
 //2获取的图片信息（通过gd库提供的方法，得到先要处理图片的基本信息）
 $info=getimagesize($src);//数组的形式
 var_dump( $info);
 //3.获取图片的类型
 $type=image_type_to_extension($info[2],false);//false去掉图片类型前的点
 //在内存中创建相同类型的图片；
$fun="imagecreatefrom{$type}";
//5.把图片复制到内存中
$image=$fun($src);
  

  /**
   * 操作图片
   */
//1.设置字体路径
$font="./font/Yahei.ttf";
//填写水印的内容
$content="你好,世界";
//3.设置字体的颜色和透明度，
$color=imagecolorallocatealpha($image,255,255, 255, 3);//参数1 内存中的图片 234为三原色 red green blue 5为 透明度
//4.写入文字
 imagettftext($image,20, 5, 20, 30, $color, $font,$content );

 /**
  * 输出图片
  */
 //浏览器输出
 ob_clean();//清空缓冲区
 header("Content-type:".$info['mime']);//告诉浏览器输出图片
 $func="image{$type}";
 $func($image);
//保存图片
 $func($image,'fontnew.'.$type);

/**
 * 销毁图片
 */
  
  imagedestroy($image);
  ?>
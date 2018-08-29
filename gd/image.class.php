<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2016-03-23 21:39:48
 * @version $Id$
 */

class image {
    //图片的基本信息
    private $info;
    //内存中的图片
    private $image;
    public function __construct($src){
        $info=getimagesize($src);
        $this->info=array(
        	'width'=>$info[0],
        	'height'=>$info[1],
        	'type'=>image_type_to_extension($info[2],false),
        	'mime'=>$info['mime']);
        $fun="imagecreatefrom{$this->info['type']}";
        $this->image=$fun($src);
    }


    //压缩图片
    public function thumb($width,$height){
    	$image_thumb=imagecreatetruecolor($width, $height);
    	imagecopyresampled($image_thumb, $this->image, 0, 0, 0, 0, $width, $height, $this->info['width'], $this->info['height']);
    	imagedestroy($this->image);
    	$this->image=$image_thumb;
    }
    //添加文字水印
    public function fontmark($content,$font_url,$size,$color,$local,$angle){
        $col=imagecolorallocatealpha($this->image, $color[0], $color[1], $color[2], $color[3]);
        imagettftext($this->image,$size, $angle,$local['x'], $local['y'], $col, $font_url,$content );
    }
    //添加图片水印
    public function imagemark($source,$local,$alpha){
        $water_info=getimagesize($source);
        $water_type=image_type_to_extension($water_info[2],false);
        $fun_water="imagecreatefrom{$water_type}";
        $water=$fun_water($source);
        imagecopymerge($this->image, $water, $local['x'], $local['y'], 0, 0,$water_info[0], $water_info[1], $alpha);
        imagedestroy($water);
    }
    //在浏览器中输出图片
     public function show(){
     	ob_clean();
     	header("Content-type:".$this->info['mime']);
        $funs="image{$this->info['type']}";
        $funs($this->image);
     }
     //保存到硬盘
     public function save($newname){
     	$funs="image{$this->info['type']}";
     	$funs($this->image,$newname.".".$this->info['type']);
     }
     //销毁图片
     public function __destruct()
     {
     	imagedestroy($this->image);
     }
}
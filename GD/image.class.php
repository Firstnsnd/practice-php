<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-26
 * Time: 下午5:28
 */

class Image
{
    private $image;        //内存中的图片
    private $info;        //图片的基本信息

//打开图片
    public function __construct($filepath){
        $info = getimagesize($filepath);
        $this->info=array(
            'width'=>$info[0],
            'height'=>$info[1],
            'type'=>image_type_to_extension($info['2'],false),
            'mime'=>$info['mime']
        );
        $fun = "imagecreatefrom{$this->info['type']}";
        $this->image=$fun($filepath);
    }

//操作图片
    /**
     * thumbnail 缩略图
     * @param   $xmax 设置缩放的宽
     * @param   $ymax 设置缩放的高
     */
    public function thumbnail($xmax,$ymax){
        //获取原图的高度和宽度
        $x = imagesx($this->image);
        $y = imagesy($this->image);

        //限制只能缩小
        if($x <= $xmax && $y <= $ymax){
            return $this->image;
        }

        //按比例缩小
        if($x >= $y) {
            $newx = $xmax;
            $newy = $newx * $y / $x;
        }else {
            $newy = $ymax;
            $newx = $x / $y * $newy;
        }
        //创建新图像
        $newimage = imagecreatetruecolor($newx, $newy);
        imagecopyresized($newimage, $this->image, 0, 0, 0, 0, floor($newx), floor($newy), $x, $y);
        $this->image = $newimage;
    }

    /**
     * waterMark 添加图片水印
     * @param   $waterMark     水印图片路径
     * @param   $alpha      透明度
     */
    public function waterMark($waterMark, $alpha = 0){
        $info = getimagesize($waterMark);
        $type = image_type_to_extension($info[2],false);
        $funMark = "imagecreatefrom{$type}";
        $water = $funMark($waterMark);

        //获取image和water的宽高
        $image_x = imagesx($this->image);
        $image_y = imagesy($this->image);
        $water_x = imagesx($water);
        $water_y = imagesy($water);
        //水印定位到右下角
        $x = $image_x - $water_x;
        $y = $image_y - $water_y;
        $this->imagecopymerge_alpha($this->image, $water, $x, $y, 0, 0, $info[0], $info[1], $alpha);
        // }
        imagedestroy($water);
    }
// 输出图片
    /**
     * show 在浏览器中输出图片
     */
    public function show(){
        header("Content-type:".$this->info['mime']);
        $funs = "image{$this->info['type']}";
        $funs($this->image);
    }
    /**
     * save 把图片保存在硬盘里
     * @param   $newname 图片命名
     */
    public function save($newname){
        $funs = "image{$this->info['type']}";
        $funs($this->image,$newname.'.'.$this->info['type']);
    }

    public function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
        $opacity=$pct;
        // getting the watermark width
        $w = imagesx($src_im);
        // getting the watermark height
        $h = imagesy($src_im);

        // creating a cut resource
        $cut = imagecreatetruecolor($src_w, $src_h);
        // copying that section of the background to the cut
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
        // inverting the opacity
        $opacity = 100 - $opacity;

        // placing the watermark now
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $opacity);
    }
//销毁图片
    public function __destruct(){
        imagedestroy($this->image);
    }

}
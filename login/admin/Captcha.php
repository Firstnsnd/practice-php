<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-28
 * Time: 下午1:25
 */class Captcha
{
    private $codeNum;    //验证码位数
    private $width;    //验证码图片宽度
    private $height;    //验证码图片高度
    private $img;    //图像资源句柄
    private $lineFlag;    //是否生成干扰线条
    private $piexFlag;    //是否生成干扰点
    private $fontSize;    //字体大小
    private $code;    //验证码字符
    private $string;    //生成验证码的字符集
    private $font;    //字体
    function __construct($codeNum = 4,$height = 50,$width = 150,$fontSize = 20,$lineFlag = true,$piexFlag = true)
    {
        $this->string = 'qwertyupmkjnhbgvfcdsxa123456789';    //去除一些相近的字符
        $this->codeNum = $codeNum;
        $this->height = $height;
        $this->width = $width;
        $this->lineFlag = $lineFlag;
        $this->piexFlag = $piexFlag;
        $this->font = dirname(__FILE__).'/fonts/consola.ttf';
        $this->fontSize = $fontSize;
    }

    //创建图像资源
    public function createImage(){
        $this->img = imagecreate($this->width, $this->height);    //创建图像资源
        imagecolorallocate($this->img,mt_rand(0,100),mt_rand(0,100),mt_rand(0,100));    //填充图像背景（使用浅色）
    }

    //创建验证码
    public function createCode(){
        $strlen = strlen($this->string)-1;
        for ($i=0; $i < $this->codeNum; $i++) {
            $this->code .= $this->string[mt_rand(0,$strlen)];    //从字符集中随机取出四个字符拼接
        }
        $_SESSION['code'] = $this->code;    //加入 session 中

        //计算每个字符间距
        $diff = $this->width/$this->codeNum;
        for ($i=0; $i < $this->codeNum; $i++) {
            //为每个字符生成颜色（使用深色）
            $txtColor = imagecolorallocate($this->img,mt_rand(100,255),mt_rand(100,255),mt_rand(100,255));
            //写入图像
            imagettftext($this->img, $this->fontSize, mt_rand(-30,30), $diff*$i+mt_rand(3,8), mt_rand(20,$this->height-10), $txtColor, $this->font, $this->code[$i]);
        }
    }

//创建干扰线条（默认四条）
    public function createLines(){
        for ($i=0; $i < 4; $i++) {
            $color = imagecolorallocate($this->img,mt_rand(0,155),mt_rand(0,155),mt_rand(0,155));    //使用浅色
            imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
        }
    }

    //创建干扰点    （默认一百个点）
    public function createPiex(){
        for ($i=0; $i < 100; $i++) {
            $color = imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            imagesetpixel($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
        }
    }
    public function show()
    {
        $this->createImage();
        $this->createCode();
        if ($this->lineFlag) {    //是否创建干扰线条
            $this->createLines();
        }
        if ($this->piexFlag) {    //是否创建干扰点
            $this->createPiex();
        }
        header('Content-type:image/png');    //请求页面的内容是png格式的图像
        imagepng($this->img);    //以png格式输出图像
        imagedestroy($this->img);    //清除图像资源，释放内存
    }

    public function getCode(){
        return $this->code;
    }

}

session_start(); //开启session
$captcha = new Captcha();    //实例化验证码类(可自定义参数)
$captcha->show();    //调用输出
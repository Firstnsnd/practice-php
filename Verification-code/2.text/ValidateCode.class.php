<?php
class ValidateCode
{
  private $chinese ='厅檶超越在蟃不为加仍然冰奇妙折枯上民胡';//????
  public $code;//???
  private $codelen;//?????
  private $width;//??
  private $height;//??
  private $img;//??????
  private $font;//?????
  private $fontsize;//??????

  //???????
  public function __construct ($width = 130, $height = 50, $codelen = 4,$fontsize = 20)
  {
      $this->font = './simsun.ttc';//??????????????????
      $this->codelen = $codelen;
      $this->height = $height;
      $this->width = $width;
      $this->fontsize = $fontsize;
      $this->createCode();
  }

  //?????
  private function createCode()
  {
      $chinese_arr = str_split($this->chinese,3);
      $_len = count($chinese_arr) - 1;
      for ($i = 0;$i < $this->codelen;++$i) {
          $this->code .= $chinese_arr[rand(0, $_len)];
      }
  }

  //????
  private function createBg()
  {
      $this->img = imagecreatetruecolor($this->width, $this->height);
      $color = imagecolorallocate($this->img, mt_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255));
      imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color);
  }

  //???????
  private function createLine()
  {
    //??
    for ($i = 0;$i < 6;++$i) {
        $color = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
        imageline($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $color);
    }
    //??
    for ($i = 0;$i < 100;++$i) {
        $color = imagecolorallocate($this->img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
        imagestring($this->img, mt_rand(1, 5), mt_rand(0, $this->width), mt_rand(0, $this->height), '*', $color);
    }
  }

  //????
  private function createFont()
  {
      $_x = $this->width / $this->codelen;
      for ($i = 0;$i < $this->codelen;++$i) {
          $this->fontcolor = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
          imagettftext($this->img, $this->fontsize, mt_rand(-30, 30), $_x * $i + mt_rand(1, 5), $this->height / 1.4, $this->fontcolor, $this->font, mb_substr($this->code, $i, 1, 'utf8'));
      }
  }
  //??
  private function outPut()
  {
      header('Content-type:image/png');
      imagepng($this->img);
      imagedestroy($this->img);
  }

  //????
  public function doimg()
  {
      $this->createBg();
      $this->createLine();
      $this->createFont();
      $this->outPut();
  }

  //?????
  public function getCode()
  {
      return $this->code;
  }
}
?>


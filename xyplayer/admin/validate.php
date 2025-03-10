<?php
/*
* TODO:PHP-验证码类
 * Author：nohacks (23453161@qq.com)
 * time:   2019-2-1
 * version:1.3
 * ready:

   $_SESSION['authnum_session'] ;//验证码保存到SESSION中

*/

if (!isset($_SESSION)) {
    session_start();
}

/*定义头文件为图片*/
header("Content-type: image/png");
/*生成验证码*/
/*创建图片设置字体颜色*/
$w=120;
$h=50;
$im = imagecreate($w, $h);
$red = imagecolorallocate($im, mt_rand(0, 100),mt_rand(200, 255),  mt_rand(0, 100));
$white = imagecolorallocate($im, 255, 255, 255);
/*随机生成两个数字*/
$num1 = rand(1, 20);
$num2 = rand(1, 20);
$_SESSION ["authnum_session"] = $num1+$num2;
/*设置图片背景颜色*/
$gray = imagecolorallocate($im, 118, 151, 199);
$black = imagecolorallocate($im, 0, 0, 0);
/*创建图片背景*/
imagefilledrectangle($im, 0, 0, $w, $h, $black);


for ($i=0;$i<6;$i++) {
   $color = imagecolorallocate($im,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
   imageline($im,mt_rand(0,$w),mt_rand(0,$h-5),mt_rand(0,$w),mt_rand(0,$h-5),$color);
  }
$k=15;
/*将计算验证码写入到图片中*/
imagestring($im, 20,$k, 15, $num1, $red);
imagestring($im, 20, $k+20, 15, "+", $red);
imagestring($im, 20, $k+40, 15, $num2, $red);
imagestring($im, 20, $k+60, 15, "=", $red);
imagestring($im, 20, $k+80, 15, "?", $red);



/*输出图片*/
imagepng($im);
imagedestroy($im);




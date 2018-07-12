<?php
header("Content-Type: image/png");
session_start();
$captchaText=strval(rand(1000,9999));
$_SESSION["captcha"]=$captchaText;
$image=imagecreate(76,36);
imagecolorallocate($image,196,196,196);
$forColor=imagecolorallocate($image,127,127,127);
imagefttext($image,20,0,10,26,$forColor,"../assets/font/web-yekan.ttf",$captchaText);
imagepng($image);
imagedestroy($image);
?>
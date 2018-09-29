<?php

$height = 100;
$width = 1000;
$im = imagecreatetruecolor($width, $height);
$white = imagecolorallocate($im, 255, 255, 255);
$blue = imagecolorallocate($im, 0, 0, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$red = imagecolorallocate($im, 255, 0, 0);
imagefill($im, 0, 0 ,$blue);
imagestring($im, 150, 50, 50, "gg", $white);
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
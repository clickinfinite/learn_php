<?php 

/*
	图片的水印的升级
	当我们不知道水印图片的大小的时候。该怎么做
	使用getimagesziea函数来做
 */




$big = imagecreatefromjpeg('./bg.jpg'); //原图
$small = imagecreatefrompng('./t1.png'); //水印图片

/*
array getimagesize ( string $filename [, array &$imageinfo ] )
返回一个具有四个单元的数组。索引 0 包含图像宽度的像素值，索引 1 包含图像高度的像素值。索引 2 是图像类型的标记：1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP，7 = TIFF(intel byte order)，8 = TIFF(motorola byte order)，9 = JPC，10 = JP2，11 = JPX，12 = JB2，13 = SWC，14 = IFF，15 = WBMP，16 = XBM。这些标记与 PHP 4.3.0 新加的 IMAGETYPE 常量对应。索引 3 是文本字符串，内容为“height="yyy" width="xxx"”，可直接用于 IMG 标记。
 */


list($bigW, $bigH) = getimagesize('./bg.jpg');
list($smallW, $smallH) = getimagesize('./t1.png');

// 将水印图片覆盖在原图上面
imagecopymerge($big, $small, $bigW-$smallW, $bigH-$smallH, 0, 0, $smallW, $smallH, 30);

// 合成图片的生成
imagepng($big, './shuyin.png');

// 销毁画布
imagedestroy($big);
imagedestroy($small);

 ?>
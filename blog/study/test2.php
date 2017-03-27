<?php 

// GD库的学习

/*
1.创建空白画布(指定宽高)

resource imagecreatetruecolor ( int $width , int $height )
imagecreatetruecolor() 返回一个图像标识符，代表了一幅大小为 x_size 和 y_size 的黑色图像。
 */

$pic = imagecreatetruecolor(202, 300);  //创建200*300黑色画布


/*
2. 填充颜色---画的图像的颜色，并不是画布的颜色
int imagecolorallocate ( resource $image , int $red , int $green , int $blue )
imagecolorallocate() 返回一个标识符，代表了由给定的 RGB 成分组成的颜色。red，green 和 blue 分别是所需要的颜色的红，绿，蓝成分。这些参数是 0 到 255 的整数或者十六进制的 0x00 到 0xFF。imagecolorallocate() 必须被调用以创建每一种用在 image 所代表的图像中的颜色。
 */

$red = imagecolorallocate($pic, 255, 0, 0);
$blue = imagecolorallocate($pic, 0, 0, 255);



/*
3. 画图形（椭圆，矩形，直线）或者写字,假如我们需要
一个椭圆 bool imageellipse ( resource $image , int $cx , int $cy , int $width , int $height , int $color )-----在指定的坐标上画一个椭圆。
 */

imageellipse($pic, 100, 150, 200, 300, $red);


/*
bool imagefill ( resource $image , int $x , int $y , int $color )----填充画布的
imagefill() 在 image 图像的坐标 x，y（图像左上角为 0, 0）处用 color 颜色执行区域填充（即与 x, y 点颜色相同且相邻的点都会被填充）。只会填充封闭区域
即其原理类似于----画图工具的油桶填充
 */
imagefill($pic, 100, 10, $blue);


/*
4. 输出/保存图形-----例如输出一个png的图像
bool imagepng ( resource $image [, string $filename ] )
imagepng() 将 GD 图像流（image）以 PNG 格式输出到标准输出（通常为浏览器），或者如果用 filename 给出了文件名则将其输出到该文件。
 */

imagepng($pic, './t1.png'); //当前目录下的t1.png文件

/*
销毁画布(关闭画板)
 */

imagedestroy($pic);



 ?>
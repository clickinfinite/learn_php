<?php 

/*
	图片的水印基础版
	当我们知道水印图片的大小的时候。
 */


/*
resource imagecreatefrompng ( string $filename )
imagecreatefrompng() 返回一图像标识符，代表了从给定的文件名取得的图像。
 */

$big = imagecreatefromjpeg('./bg.jpg'); //原图
$small = imagecreatefrompng('./t1.png'); //水印图片

/*
bool imagecopymerge ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h , int $pct )
将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。两图像将根据 pct 来决定合并程度，其值范围从 0 到 100。当 pct = 0 时，实际上什么也没做，当为 100 时对于调色板图像本函数和 imagecopy() 完全一样，它对真彩色图像实现了 alpha 透明。
 */


// 将水印图片覆盖在原图上面
imagecopymerge($big, $small, 0, 0, 0, 0, 202, 300, 30);

// 合成图片的生成
imagepng($big, './shuyin.png');

// 销毁画布
imagedestroy($big);
imagedestroy($small);

 ?>
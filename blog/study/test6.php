<?php 

/*
	图片的缩略图----其原理是将大图，设定一个起点坐标
	和剪裁的宽高,然后把这个图放入一个小图的原点
	即0,0点,大图会自适应放入小图中
 */




$big = imagecreatefromjpeg('./bg.jpg'); //原图

// 获取大图的宽高
list($bigW, $bigH) = getimagesize('./bg.jpg');

// 创建缩略图
$small = imagecreatetruecolor($bigW/2, $bigH/2);


/*
重采样拷贝部分图像并调整大小
bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
imagecopyresampled() 将一幅图像中的一块正方形区域拷贝到另一个图像中，平滑地插入像素值，因此，尤其是，减小了图像的大小而仍然保持了极大的清晰度。
 */


imagecopyresampled($small, $big, 0, 0, 0, 0, $bigW/2, $bigH/2, $bigW, $bigH);

//把大图从0,0到图片的宽高----缩略成0,0到图片宽度和高度的一半


// 合成图片的生成
imagepng($small, './suolue.png');

// 销毁画布
imagedestroy($big);
imagedestroy($small);

 ?>
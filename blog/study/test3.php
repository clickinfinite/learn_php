<?php 


/*
	生成验证码
 */



/**
 * [randStr 生成随机字符串]
 * @param  integer $len [字符串的个数]
 * @return [sting]       [返回的随机字符串]
 */
function randStr($len=6) {
	$str = str_shuffle('ABCDFGHJKMNPORSTUVWXYZabcdefghijkmnporstuvwxyz');
	$randStr = substr($str, 0, $len);
	return $randStr;
}

// 创建画布
$canvas = imagecreatetruecolor(60, 40);

// 创建颜色
$red = imagecolorallocate($canvas, 255, 0, 0);
$gray = imagecolorallocate($canvas, 200, 200, 200);

// 填充画布的颜色
imagefill($canvas, 0, 0, $gray);


/*
bool imagestring ( resource $image , int $font , int $x , int $y , string $s , int $col )
imagestring() 用 col 颜色将字符串 s 画到 image 所代表的图像的 x，y 坐标处（这是字符串左上角坐标，整幅图像的左上角为 0，0）。如果 font 是 1，2，3，4 或 5，则使用内置字体。
 */

imagestring($canvas, 5, 10, 5, randStr(4), $red);
// 从10,5开始,画字符串，颜色为red;

// 保存图片,输出到浏览器
header('Content-type:image/png');
imagepng($canvas);

// 销毁画布
imagedestroy($canvas);
 ?>
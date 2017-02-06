<?php 
header('content-type: text/html, charset=utf-8');

/**
 * 转换字节大小
 * @param unmber $size
 * @return number
 */

function transBytes($size) {

//定义内存的单位
$arr = array('Byte', 'KB', 'MB', 'GB', 'TB');
$i = 0;
while ($size >= 1024) {
	$size = $size/1024;
	$i++;
}

return round($size, 2).$arr[$i];
}


 ?>
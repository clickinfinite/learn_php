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


/**
 * [创建文件]
 * @param [strings] $filename
 * @return [string] 
 */

function createFile($filename) {
	//  / * ? < > |这个是文件名不能保存的特殊字符
	$pattern = '/[\/\*<>\?\|]/';
	if (!preg_match($pattern, basename($filename))) {
		//检测当前目录下是否包含同名文件名
		if (!file_exists($filename)) {
			if (touch($filename)) {
				return '文件创建成功';
			}else {
				return '文件创建失败';
			}
		}else {
			return '文件已存在，请重命名后创建';
		}
	}else{
		return '非法文件名';
	}
}




 ?>

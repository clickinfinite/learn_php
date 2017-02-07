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


/**
 * [检测文件名是否合法]
 * @param [string]  [文件路径]
 * @return [Boolean] [符合返回true，不符合返回false]
 */
function checkFilename($filename) {
	//  / * ? < > |这个是文件名不能保存的特殊字符
	$pattern = '/[\/\*<>\?\|]/';
	if (preg_match($pattern,$filename)) {
		return false;
	}else {
		return true;
	}
		
}


/**
 * [文件的重命名]
 * @param  [string] $oldname [文件的路径]
 * @param  [string] $newname [文件的路径]
 * @return [string]          [提示信息]
 */
function renameFile($oldname, $newname) {
	//验证文件名是否合法
	if (checkFilename($newname)) {
		//检测当前目录下是否存在同名文件
		$path = dirname($oldname);
		//获取当前文件的目录
		if (!file_exists($path.'/'.$newname)) {
			//进行重命名
			if (rename($oldname, $path.'/'.$newname)) {
				return '重命名成功';
			}else{
				return '重命名失败';
			}
		}else {
			return '已经存在同名文件, 请重新命名';
		}
	}else {
		return '非法文件名';
	}
}


/**
 * [删除文件]
 * @param  [string] $filename [文件路径]
 * @return [string]           [提示信息]
 */
function delFile($filename) {
	if (unlink($filename)) {
		$mes = '文件删除成功';
	}else {
		$mes = '文件删除失败';
	}
	return $mes;
}


/**
 * [下载文件]
 * @param  [string] $filename [文件路径]
 */
function downloadFile($filename) {
	header('content-disposition:attachment; filename='.basename($filename));
	header('content-length:'.filesize($filename));
	readfile($filename);
	exit();
}




 ?>
<?php 
header('content-type: text/html, charset=utf-8');

/**
 * 遍历目录函数，读取目录中的最外层的内容
 * @param  string $path
 * @return array
 */

function readDirectory($path) {
	// 打开目录
	$handler = opendir($path);
	// 定义存储内容的数组变量
	$arr = array();
	// 遍历该目录下所有的内容
	while (false !== ($item = readdir($handler))) {
		//使用的是不全等，因为如果文件名为0的话，即为false
		//.表示当前目录; ..表示上级目录,这个也需要进行判断
		if ($item != '.' && $item != '..') {
			// 判断在该目录下是文件夹还是文件
			if (is_file($path.'/'.$item)) {
				//存在一个file二位数组下,php中的数组默认从0开始
				$arr['file'][] = $item;
			}
			if (is_dir($path.'/'.$item)) {
				//存在一个名为dir的二位数组下
				$arr['dir'][] = $item;
			}
		}
	}

	//关闭目录
	closedir($handler);
	// 返回数组
	return $arr;
}


/**
 * [得到文件夹的大小]
 * @param  [string] $path [路径]
 * @return [int]       [文件夹的大小]
 */
function dirSize($path) {
	$sum = 0;
	global $sum;
	$handler = opendir($path);
	while (false !== ($item = readdir($handler))) {
		if ($item != '.' && $item != '..') {
			// 如果是一个文件
			if (is_file($path.'/'.$item)) {
				$sum += filesize($path.'/'.$item);
			}
			// 如果是一个目录
			if (is_dir($path.'/'.$item)) {
				$func = __FUNCTION__;
				// 当我们把$sum进行设置的话，这个是局部变量
				// 当递归调用的话，该局部变量会销毁
				$func($path.'/'.$item);
			}
		}
	}
	closedir($handler);
	return $sum;
}


/**
 * [createFolder 创建文件夹]
 * @param  [string] $dirname [文件夹名字]
 * @return [string]          [提示语]
 */
function createFolder($dirname) {
	// 检测文件夹名称的合法性
	if (checkFilename(basename($dirname))) {
		//检测当前目录下是否包含同名文件名
		if (!file_exists($dirname)) {
			if (mkdir($dirname, 0777, true)) {
				$mes = '文件夹创建成功';
			}else {
				$mes = '文件夹创建失败';
			}
		}else {
			$mes = '文件夹已存在，请重命名后创建';
		}
	}else{
		$mes = '非法文件夹名';
	}

	return $mes;
}


/**
 * [copyFolder 复制文件夹]
 * @param  [string] $src [源文件的目录]
 * @param  [string] $dst [目标文件的目录]
 * @return [string]      [提示信息]
 */
function copyFolder($src, $dst) {
	// 判断移动到的文件夹是否存在
	if (!file_exists($dst)) {
		// 不存在，则创建文件夹
		mkdir($dst, 0777, true);
	}
	$handler = opendir($src);
	while (false !== ($item = readdir($handler))) {
		if ($item != '.' && $item == '..') {
			// 如果该文件夹下是文件的话，直接复制
			if (is_file($src.''.$item)) {
				copy($src.'/'.$item, $dst.'/'.$item);
			}

			if (is_dir($src.'/'.$item)) {
				// 递归函数
				$func = __FUNCTION__;
				$func($src.'/'.$item, $dst.''.$item);
			}
		}
	}
	closedir($handler);
	return '复制成功';
}


/**
 * [renameFolder 重命名文件夹]
 * @param  [string] $oldname [源文件的目录]
 * @param  [string] $newname [目标文件的目录]
 * @return [string]          [提示信息]
 */
function renameFolder($oldname, $newname) {
	if (checkFilename(basename($newname))) {
		//检测当前目录下是否存在同名文件
		$path = dirname($oldname);
		//获取当前文件的目录
		if (!file_exists($newname)) {
			//进行重命名
			if (rename($oldname, $newname)) {
				$mes = '重命名成功';
			}else{
				$mes = '重命名失败';
			}
		}else {
			$mes = '已经存在同名文件夹, 请重新命名';
		}
	}else {
		$mes = '非法文件夹名';
	}

	return $mes;
}


/**
 * [cutFolder 文件夹的剪切]
 * @param  [string] $src [源文件的目录]
 * @param  [string] $dst [目标文件的目录]
 * @return [string]      [提示信息]
 */
function cutFolder($src, $dst) {
	// 文件是否存在
	if (file_exists($dst)) {
		// 是否是一个目录
		if (is_dir($dst)) {
			// 是否存在同名文件夹
			if (!file_exists($dst.'/'.basename($src))) {
				if (rename($src, $dst.'/'.basename($src))) {
					$mes = '剪切成功';
				}else{
					$mes = '剪切失败';
				}
			}else{
				$mes = '存在同名文件夹';
			}
			
		}else{
			$mes = '不是一个文件夹';
		}
	}else{
		$mes = '目标文件夹不存在';
	}

	return $mes;
}


/**
 * [delFolder 删除文件夹]
 * @param  [string] $path [要删除文件的目录]
 * @return [string]       [提示信息]
 */
function delFolder($path) {
	$handler = opendir($path);
	while (false !== ($item = readdir($handler))) {
		if ($item != '.' && $item != '..') {
			if (is_file($path.'/'.$item)) {
				// 删掉文件
				unlink($path.'/'.$item);
			}
			if (is_dir($path.'/'.$item)) {
				$func = __FUNCTION__;
				$func($path.'/'.$item);
			}
		}
	}
	closedir($handler);
	// 删掉空文件夹，不能删除非空文件夹
	rmdir($path);
	return '删除成功';
}


 ?>
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


 ?>
<?php
header('content-type: text/html, charset = utf-8');

/**
 * 构建上传文件信息
 * 
 */
function getFiles() {
	$i = 0;
	$files = [];
	foreach ($_FILES as $file) {
		// 判断是单个多文件还是多个文件上传
		if (is_string($file['name'])) {
		// 多个单文件或者单文件上传
			$files[$i] = $file;
			$i++;
		// 多文件上传
		}elseif (is_array($file['name'])) {
			foreach ($file['name'] as $key => $value) {
				$files[$i]['name'] = $file['name'][$key];
				$files[$i]['type'] = $file['type'][$key];
				$files[$i]['tmp_name'] = $file['tmp_name'][$key];
				$files[$i]['size'] = $file['size'][$key];
				$files[$i]['error'] = $file['error'][$key];
				$i++;
			}
		}
	}
// 返回文件信息
	return $files;
}

//上传文件
function upload($fileInfo, $path = 'uploads', $allowExt = array('jpg', 'jpeg', 'png', 'gif', 'wbmp'), $maxSize = 2097152, $flag= true ){
	
	// 判断错误代码
	if ($fileInfo['error'] === 0) {
		// 如果没有错误的话，检测上传文件大小
		//$maxSize = 2097152; //2M 允许的最大值
		// 判断文件上传的大小
		if ($fileInfo['size'] > $maxSize) {
			$res['mes'] = $fileInfo['name'].'上传文件过大';
		}
		//允许的类型是一个数组
		if (!is_array($allowExt)) {
			$res['mes'] = $fileInfo['name'].'upload的中允许的文件类型参数是一个数组';
		}
		$ext = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
		//允许的类型
		//$allowExt = array('jpg', 'jpeg', 'png', 'gif', 'wbmp'); 
		// 检测上传文件的类型
		if (!in_array($ext, $allowExt)) {
			$res['mes'] = $fileInfo['name'].'上传的文件的类型不符合';
		}

		// 判断文件类型是否为真实的类型
		// 例如，本来是一个文本文件，但是用户把其扩展名改为jpg
		if ($flag) {
			if (!getimagesize($fileInfo['tmp_name'])) {
				$res['mes'] = $fileInfo['name'].'不是真正图片类型';
			}
		}

		// 判断是否通过HTTP POST 方式上传来的
		if (!is_uploaded_file($fileInfo['tmp_name'])) {
		   $res['mes'] = $fileInfo['name'].'文件不是通过HTTP POST上传来的';
		}
		//如果上面的中，有一个条件不满足，那么就直接显示错误
		// 终止程序，不执行下面成功的移动判断
		if(!empty($res)){
			return $res;
		}
		//如果名字相同的话，那么后面的而文件会覆盖前面的文件
		// 为了保证不进行覆盖的话。需要使用户上传的文件进行重命名
		// 从而确保唯一性。即使上传的是一样的内容。

		//$path = 'uploads'; //默认路径
		// 如果存在这个路径的话，创建这个
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
			chmod($path, 0777);
		}
		$uniName = md5(uniqid(microtime(true), true)).'.'.$ext;//确保文件名唯一
		// 判断错误代码，是否上传成功，不成功输出错误原因
		$destination = $path.'/'.$uniName;

		// 上传的临时文件路径，移动到指定路径中.
		if (!move_uploaded_file($fileInfo['tmp_name'], $destination)) {
			$res['mes'] = $fileInfo['name'].'文件移动失败';
		}
		$res['mes'] = $fileInfo['name'].'上传成功';
		$res['dest'] = $destination;
		return $res;
	}else {
		// 匹配代码
		switch ($fileInfo['error']) {
			case 1:
				$res['msg'] = "上传文件的大小超出了 upload_max_filesize约定值";
				break;
			case 2:
				$res['msg'] = "上传文件大小超出了HTML表单隐藏域属性的MAX＿FILE＿SIZE元素所指定的最大值";
				break;
			case 3:
				$res['msg'] = "文件只被部分上传";
				break;
			case 4:
				$res['msg'] = "没有上传任何文件";
				break;
			case 6:
				$res['msg'] = "找不到临时文件夹";
				break;
			case 7:
				$res['msg'] = "文件写入失败";
				break;
			case 8:
				$res['msg'] = "上传文件被PHP扩展程序中断";
				break;
		}
	}
	return $res;

}
?>    
<?php
header('content-type: text/html; charset=utf-8');
//$_FILE文件上传变量接受上传文件信息
$fileInfo = $_FILES['myfile'];  
//myfile为前端input type为file的name值
/*
	单文件信息$fileInfo
	Array
(
    [name] => hskdh_03.png
    [type] => image/png
    [tmp_name] => E:\wamp\wamp\tmp\phpB030.tmp
    [error] => 0
    [size] => 4532
)
*/

//数组中的各个信息
$filename = $fileInfo['name'];
$type = $fileInfo['type'];
$tmp_name = $fileInfo['tmp_name'];
$size = $fileInfo['size'];
$error = $fileInfo['error'];
$maxSize = 2097152; //2M 允许的最大值
$ext  = strtolower(end(explode('.', $filename)));//上传的类型
//或者使用pathinfo
// $ext = pathinfo($filename, PATHINFO_EXTENSION);
$allowExt = array('jpg', 'jpeg', 'png', 'gif', 'wbmp'); //允许的类型
$flag = true; //是否为真实图片类型
if ($error === 0) {
	// 判断文件上传的大小
	if ($size > $maxSize) {
		exit('上传的文件过大');
	}
	// 上传文件的类型的判断
	if (!in_array($ext, $allowExt)) {
		exit('上传的文件的类型怒符合');
	}

	// 判断文件类型是否为真实的类型
	// 例如，本来是一个文本文件，但是用户把其扩展名改为jpg
	if ($flag) {
		if (!getimagesize($tmp_name)) {
			exit('不是真正图片类型');
		}
	}

	// 判断是否通过HTTP POST 方式上传来的
	if (!is_uploaded_file($tmp_name)) {
	   exit('文件不是通过HTTP POST上传来的');
	}

	//如果名字相同的话，那么后面的而文件会覆盖前面的文件
	// 为了保证不进行覆盖的话。需要使用户上传的文件进行重命名
	// 从而确保唯一性。即使上传的是一样的内容。

	$path = 'uploads'; //默认路径
	// 如果存在这个路径的话，创建这个
	if (!file_exists($path)) {
		mkdir($path, 0777, true);
		chmod($path, 0777);
	}
	// $destination = $path.''.$filename; 这个会导致重名-
	$uniName = md5(uniqid(microtime(true), true)).'.'.$ext;//确保文件名唯一
	// 判断错误代码，是否上传成功，不成功输出错误原因
	$destination = $path.'/'.$uniName;


	// 上传的临时文件路径，移动到指定路径中.
	if (move_uploaded_file($tmp_name, $destination)) {
		// 移动成功
		echo '文件'.$filename.'上传成功';
	}else {
		//移动失败
		echo '文件'.$filename.'上传失败';
	}
}else {
	// 匹配代码
	switch ($error) {
		case 1:
			echo "上传文件的大小超出了 upload_max_filesize约定值";
			break;
		case 2:
			echo "上传文件大小超出了HTML表单隐藏域属性的MAX＿FILE＿SIZE元素所指定的最大值";
			break;
		case 3:
			echo "文件只被部分上传";
			break;
		case 4:
			echo "没有上传任何文件";
			break;
		case 6:
			echo "找不到临时文件夹";
			break;
		case 7:
			echo "文件写入失败";
			break;
		case 8:
			echo "上传文件被PHP扩展程序中断";
			break;
	}
}


?>  
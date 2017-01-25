<?php
header('content-type: text/html, charset = utf-8');
include_once 'uploadfun2.php';
$files = getFiles();
foreach ($files as $fileInfo) {
	// 保存错误信息
	$res = upload($fileInfo);
	echo $res['mes'].'<br>';
	// 保存上传成功的数组
	$uploadFiles[] = $res['dest'];
}
$uploadFiles = array_values(array_filter($uploadFiles));
print_r($uploadFiles);
?>  

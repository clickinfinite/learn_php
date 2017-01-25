<?php
header('content-type: text/html, charset = utf-8');
// 包含upload的function
include_once 'uploadfun1.php';
$fileInfo = $_FILES['myfile'];  
$fileMsg = upload($fileInfo);
print_r($fileMsg) ;
?>    
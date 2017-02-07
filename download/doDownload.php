<?php 
header('content-type:text/html, charset=utf-8');
$filename = $_GET['filename'];
header('content-disposition:attachment; filename='.basename($filename));
header('content-length:'.filesize($filename));
readfile($filename);
 ?>
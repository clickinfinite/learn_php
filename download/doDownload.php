<?php 
header('content-type:text/html, charset=utf-8');
$filename = $_GET['filename'];
header('content-disposition:attachment; filename='.basename($filename));
header('content-lenght:'.filesize($filename));
readfile($filename);
 ?>
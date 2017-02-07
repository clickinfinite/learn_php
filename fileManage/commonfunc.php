<?php 
header('content-type:text/html, charset=utf-8');

/**
 * [提示操作信息，并且跳转]
 * @param  [string] $mes [提示信息]
 * @param  [string] $url [跳转的url]
 */
function alertMes($mes, $url) {
	echo "<script>alert('{$mes}');location.href='{$url}';</script>";
}

 ?>
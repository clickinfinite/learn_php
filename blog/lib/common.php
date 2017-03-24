<?php 

// 公共函数


/**
 * [success 成功提示函数]
 * @param  string $mes [提示信息]
 * @return [type]      [description]
 */
function success($mes = '成功') {
	$result = 'success';
	include(ROOT.'/view/admin/info.html');
}


/**
 * [error 错误提示函数]
 * @param  string $mes [失败]
 * @return [type]      [description]
 */
function error($mes = '失败') {
	$result = 'error';
	include(ROOT.'/view/admin/info.html');
}


?>
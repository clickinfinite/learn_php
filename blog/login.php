<?php 
/*
登陆页面
 */

require('lib/init.php');

if (empty($_POST)) {
	include(ROOT.'/view/front/login.html');
}else {
	$name = trim($_POST['name']);
	$password = trim($_POST['password']);
	$sql = "SELECT * FROM user WHERE name= ".$name;
	$user = getRowData($sql);

	// 判断用户名或密码是否正确
	if (empty($user)) {
		error('用户名错误');

	// 如果用户名存在,是否与数据库中的password不对应
	// 那么就提示密码错误
	}else if(md5($user['salt'].$password) !== $user['password']){
		error('密码错误');

	// 都通过的话,设置cookie
	}else{
		// 名字的cookie
		setcookie('name', $user['name']);
		// 加密后的cookie
		setcookie('name', cCode[$user['name']]);
		header('Location:artlist.php');
	}
}













 ?>
<?php 

/*
	cookie计数器,浏览器每刷新一次
	数字相应的加1
 */


// 借助临时变量，来完成这个函数
	if (!isset($_COOKIE['num'])) {
		$num = 1;
		// 第一次设置cookie,使用$_COOKIE['num']
		// 在下一次才能获取到值,所以用变量
		// 来设置初始值
		setcookie('num', $num);
		// 服务器设置的cookie-----浏览器在下一次请求才能使用
		// 发送给服务器
	}else{
		// $_COOKIE['num']是上一次的值
		$num = $_COOKIE['num'] + 1;
		setcookie('num', $num);
	}

	echo $num;

// 如果setcookie，那么$_COOKIE想要获取cookie的值
// 需要在下一次请求中才能访问到
// （第一次以vip进行店里，然后被降为普通用户
// 下一次进店，你就是普通用户----这在下一次才能
// 起作用）



 ?>
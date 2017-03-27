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


/**
 * [getUserIp 获取用户的IP]
 * @return [sting] [用户的ip]
 */
function getUserIp() {
	/*
	$userIp设置为一个静态变量，因为访问环境变量
	消耗资源，所以采用一个静态变量
	 */
	static $userIp = null;
	if ($userIp !== null) {
		return $userIp;
	}

	/*
	简单仅使用全局变量（$_SERVER 或 $_ENV）
	$ip = $_SERVER['REMOTE_ADDR'];-----当在php生产环境中
	为了服务器安全，不能访问这个变量，这可以用下面的这种方式

	getenv() 使用示例-----获取一个环境变量的值
	$ip = getenv('REMOTE_ADDR');
	 */
	
	if (getenv('REMOTE_ADDR')) {
		// 一般web服务器的ip字段为REMOTE_ADDR
		$userIp = getenv('REMOTE_ADDR');
	}elseif (getenv('HTTP_CLIENT_IP')) {
		// 有的web服务器，例如iis,用户的ip字段为HTTP_CLIENT_IP
		$userIp = getenv('HTTP_CLIENT_IP');
	}else{
		// 有的经过代理上网，其ip字段为HTTP_X_FORWARDED_FOR
		$userIp = getenv('HTTP_X_FORWARDED_FOR');
	}

	return $userIp;
}


/**
 * [getpagination 分页]
 * @param  [type] $totalArticleNum [文章的总数]
 * @param  [type] $pageArticleNum  [每一页显示的文章数]
 * @param  [type] $curPage         [当前页码]
 * @return [type]                  [description]
 */
function getpagination($totalArticleNum, $pageArticleNum, $curPage) {
	// 向上取整---得到所需要的页码数
	$maxPage = ceil($totalArticleNum/$pageArticleNum);
	
	//假如我们在页面中只显示5个页码数 12345 23456...
	// curPage-2, curPage-1, curPage, curPage+1, curPage+2....
	//

	// 此时最左边的页面数为,可能为1, 也可能为$curPage-2
	// 取他们中最大的。例如 [1]2345789 --curPage为1,此时最左边1，或者-1
	// 当然不可能为-,应该为正数,所以为正数1，取这两者中最大的一位。
	
	$left = max(1, $curPage-2);

	// 此时最右边
	// 例如 [1]234---总数就只有4页，当前也为1,不足5页,$maxPage为4，$left+4=5,所以取最小的。
	$right = min($maxPage, $left+4);

	/*
	1 2 3 4 5 6 7 [8] 9
	当前也为8------$left为6,最右边为9
	此时我们可以发现一个问题，那就页码不足5页时，此时右边的是对的，而左边根据刚才算出的
	就是不对的，此时需要对左边重新计算
	 */
	
	$left = max(1, $right - 4);

	$page = array();

	for ($i=$left; $i <= $right ; $i++) { 
		// 赋值
		$_GET['page'] = $i;
		// http_build_query拼接查询参数字符串,后面添加的
		// 会追加在地址栏上面的参数，不会覆盖
		$page[$i] = http_build_query($_GET);

	}

	return $page;

}


/**
 * [createDir 创建文件上传目录]
 * @return [type] [description]
 */
function createDir() {
	// 创建一个联级的目录
	// 例如：upload/2017/03/04
	$path = '/upload'.date('Y/m/d');

	$abs = ROOT.$path;
	// true参数代表创建联级目录
	if (is_dir($abs) || mkdir($abs, 0777, true)) {
		return $path;
	}else{
		return false;
	}

}



/**
 * [randStr 生产随机字符串]
 * @param  integer $length [生成的随机字符串的位数]
 * @return [string]          [生产的随机字符串]
 */
function randStr($length=6) {
	// 把字符串打乱
	$str = str_shuffle('ABCDEFGHJKLMNOPQRSTUVWXYZabcdefghjkmnopkuvwxyz');
	$str = substr($str, 0, $length);
	return $str;

}


/**
 * [getExe 获取文件的后缀名]
 * @param  [string] $name [文件的路径]
 * @return [strng]       [文件的后缀名]
 */
function getExe($name) {
	return strrchr($name, '.');

	/*
	
	获取文件名的常用的五种方法
	$path_parts = pathinfo('/www/htdocs/inc/lib.inc.php');

	echo $path_parts['dirname'], "\n";
	echo $path_parts['basename'], "\n";
	echo $path_parts['extension'], "\n";
	echo $path_parts['filename'], "\n";

	/www/htdocs/inc
	lib.inc.php
	php
	lib.inc
	 */
}






















?>
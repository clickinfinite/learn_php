<?php 

/**
 * 文章详情页面
 */

// 从地址栏获取art_id,如果art_id不是合法的或者
// 在数据库总不存在的话，那么对其做出相应的错误处理
// ，当上面的检查都成功了，那么就输出该文章内容，数据
// 从数据库中取出数据，填充到art.html的模板中。


// 引入初始化
require('lib/init.php');

$artId = $_GET['art_id'];

// 判断art_id是否为数字或数字的字符串
if (!is_numeric($artId)) {
	// 不是数字的话，直接跳转到首页
	header('Location:index.php');
	exit();
}


// art_id是否存在于数据库中

$artSql = "SELECT * FROM art WHERE art_id = $artId";
if (!getRowData($artSql)) {
	// 如果art_id不存在数据库中，则跳转到首页
	header('Location:index.php');
	exit();
}

// 查到文章的具体内容
$artDetailSql = "SELECT title, catname, comm, pubtime, content, pic FROM cat INNER JOIN art ON cat.cat_id = art.cat_id WHERE art_id = $artId";
$artDetailRes = getRowData($artDetailSql);


// 如果查询sql,出错的话，提示错误
if (!$artDetailRes) {
	error('该文章没有查到');
	exit();
}


// 对于右侧的栏目进行取值
$catSql = "SELECT cat_id, catname FROM cat";
$catRes = getAllData($catSql);
if (!$catRes) {
	error('栏目查询出错');
	exit();
}


// 对于留言，这个会根据POST是否为空，来进行判断的
// 如果POST不为空的话，即有人进行了留言，会提交
// 后台，当然会对留言进行一系列验证，验证成功了，
// 则写入到数据库中，不成功的话，提示用户报错。
// 如果POST为空，则没有人写入留言，那么从数据库中
// 取出数据，展示留言。

if (!empty($_POST)) {
	//数据库查找数据，展示留言
	$comm = array();
	$comm['nick'] = trim($_POST['nick']);
	$comm['email'] = trim($_POST['email']);
	$comm['content'] = trim($_POST['content']);
	if (empty($comm['nick']) || empty($comm['email']) || empty($comm['content'])) {
		echo "昵称,email或者评论内容不能为空";
		exit();
	}
	$comm['pubtime'] = time();
	$comm['art_id'] = $artId;
	// 来访者的ip
	$comm['ip'] = sprintf("%u", ip2long(getUserIp()));
	$comRes = execMysql('comment', $comm);
	if ($comRes) {
		// 评论提交成功后，那么art表中num+1;
		$comNumSql = "UPDATE art SET comm = comm + 1 WHERE art_id = $artId";
		queryMysql($comNumSql);

		// 防止刷新，数据重复提交到后台，提交成功
		// 重定向到上一页
		$ref = $_SERVER['HTTP_REFERER'];
		header('Location:'.$ref);
	}
	// 插入失败的话，在art.html页面进行提示
}


// post为空的话，这查询数据库，取出所需要的字段
// 填充到模板中
$commSql = "SELECT nick, pubtime, content FROM comment WHERE art_id = $artId";
$commRes = getAllData($commSql);

// 引入模板
require(ROOT.'/view/front/art.html');


 ?>
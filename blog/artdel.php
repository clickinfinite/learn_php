<?php 

/**
 * 文章的删除
 */



// 根据前台传的art_id,从数据库中删除数据


// 引入初始化
require('lib/init.php');

$artId = $_GET['art_id'];

// 判断传过来的art_id值是否合法
if (!is_numeric($artId)) {
	error('文章的id,不是数字,请传入合法的文章id');
	exit();
}

// 判断传递过来的art_id,是否存在于数据库中。
$artSearchSql = "SELECT * FROM art WHERE art_id = ".$artId;
$artSearchRes = getOneData($artSearchSql);
if (!$artSearchRes) {
	error('文章不存在');
	exit();
}


//上面判断都通过的话，则可以对数据库中的数据进行删除。
$artDelSql = "DELETE FROM art WHERE art_id = $artId";
$artDelRes = queryMysql($artDelSql);
if (!$artDelRes) {
	error('文章删除失败');
}else{
	// success('文章删除成功');
	// 跳转到文章的列表页面
	header('Location:artlist.php');
}






 ?>
<?php 

/**
 * 评论的删除
 */



// 根据前台传的art_id,从数据库中删除数据

// 引入初始化
require('lib/init.php');

$commId = $_GET['comment_id'];


// 判断传过来的comment_id值是否合法
if (!is_numeric($commId)) {
	error('评论的id,不是数字,请传入合法的评论id');
	exit();
}

// 判断传递过来的comment_id,是否存在于数据库中。
$commSearchSql = "SELECT * FROM comment WHERE comment_id = ".$commId;
$commSearchRes = getOneData($commSearchSql);
if (!$commSearchRes) {
	error('评论不存在');
	exit();
}


// 获取文章的id,因为文章中有一个评论人数的字段，删除评论的时候
// 同时得更新这个字段的值
$artIdSql = "SELECT art_id FROM comment WHERE comment_id = ".$commId;
$artId = getOneData($artIdSql);
if (!$artId) {
	error('评论文章不存在');
	exit();
}


//上面判断都通过的话，则可以对数据库中的数据进行删除。
$commDelSql = "DELETE FROM comment WHERE comment_id = $commId";
$commDelRes = queryMysql($commDelSql);
if (!$commDelRes) {
	error('评论删除失败');
}else{
	$commNumSql = "UPDATE art SET comm = comm -1 WHERE art_id = ".$artId;
	queryMysql($commNumSql);
	// success('评论删除成功');
	// 跳转到评论的列表页面
	header('Location:commlist.php');
}


 ?>
<?php 

/**
 * 文章的添加
 */



// 先引入模板的html，如果没有post提交，那么从数据库取出栏目名称
// 放在页面中，如果post不为空的话，就判断提交的文章title，
// 栏目，文章内容是否为空，不为空才能进行提交到后台，不然报错
// 退出程序。


// 引入初始化
require('lib/init.php');

// 从数据查找栏目名称，展示给前台页面
$catSql = "SELECT * FROM cat";
$cat = getAllData($catSql);

/*
print_r($cat);
Array ( [0] => Array ( [cat_id] => 1 [catname] => 人生 [num] => 0 ) 
[1] => Array ( [cat_id] => 2 [catname] => 哲学 [num] => 0 ) 
[2] => Array ( [cat_id] => 3 [catname] => 技术 [num] => 0 ) 
[3] => Array ( [cat_id] => 4 [catname] => 历史 [num] => 0 ) ) 
 */


if (empty($_POST)) {
	include(ROOT.'/view/admin/artadd.html');
}else{
	// 判断文章的标题是是否为空
	$art['title'] = trim($_POST['title']);
	if (!$art['title']) {
		error('文章名不能为空');
		exit();
	}


	// 判断文章的栏目是否空
	$art['cat_id'] = trim($_POST['cat_id']);
	if (!is_numeric($art['cat_id'])) {
		error('您的栏目名称还没选择呢');
		exit();
	}

	// 判断文章内容是否为空
	$art['content'] = trim($_POST['content']);
	if (!$art['content']) {
		error('您还没有填写文内容呢');
		exit();
	}

	$art['pubtime'] = time();

	//如果都满足条件，这可以提交到后台，并写入数据库中
	$artInsertRes = execMysql('art', $art);
	if (!$artInsertRes) {
		error('文章发表失败');
	}else{
		success('文章发表成功');
	}



}

	

 ?>
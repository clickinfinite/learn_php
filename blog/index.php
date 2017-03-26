<?php 

// 引入初始化
require('lib/init.php');


// 取出多条数据，注意，用那些字段，取那些字段
// 不要一上来就用*,即管它有用没有，一下子就取出来

// 栏目下的详情文章，也是跳转到首页，根据cat_id进行判断

// @$catId = $_GET['cat_id'];
// @表示这行有错误或是警告不要输出


// 或者用isset或者empty进行ifelse判断
if (isset($_GET['cat_id'])) {
	// 如果这个变量已经设置了，进行where拼接
	$where = "AND cat.cat_id = {$_GET['cat_id']}";
}else{
	$where = '';
}

// 取出栏目相关的数据
$catSql = "SELECT cat_id, catname FROM cat";
$catRes = getAllData($catSql);

// 取出文章相关的数据
$artSql = "SELECT art_id, title, catname, comm, pubtime, content FROM cat INNER JOIN art ON cat.cat_id = art.cat_id WHERE 1 ".$where;
$artRes = getAllData($artSql);


// 加载首页
include(ROOT.'/view/front/index.html');
 ?>
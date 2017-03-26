<?php 

/**
 * 文章的编辑
 */



// 总体思路，先判断用户是否对该文章有编辑的权限，没有的话，就退出
// 有的话，就对文章就编辑，判断POST,是否为空，为空的话，就对从artlist
// 页面提交过来的art_id,则对art_id进行是否为数字和是否在数据库中存在
// 该文章，然后把从数据库中查到的内容，填充到该编辑模板中，成为默认值。
// 如果post不为空，就对文章的标题，内容，栏目进行判断，合法则插入数据库中。


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
$artSearchRes = getRowData($artSearchSql);

if (!$artSearchRes) {
	error('文章不存在');
	exit();
}


// 模板中有选择栏目的选项，所以需要对数据库中查找栏目表
$catSql = "SELECT * FROM cat";
$cat = getAllData($catSql);

if(!$cat) {
	error('栏目查询出错');
	exit();
}

// 判断POST是为为空，为空的话，根据art_id查到相应的数据填充到对应的模板中
if (empty($_POST)) {
	// 第一次点击进入，这个页面，则获取默认值
	include(ROOT.'/view/admin/artedit.html');
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


	// 上一次修改时间
	$art['lastup'] = time();

	//如果都满足条件，这可以提交到后台，并写入数据库中
	$artInsertRes = execMysql('art', $art, $act='UPDATE', 'art_id='.$artId);
	if (!$artInsertRes) {
		error('文章编辑失败');
	}else{
		//判断有无tag,没有则文章修改成功，
		//有的话直接删除原来的标签，再插入新的标签
		$tag = trim($_POST['tag']);
		// 删除所有tag表的所有tag,再INSERT插入新的tag
		// 因为使用update一个一个太麻烦，还是不如全部删除
		// 再重新插入
		// 
		
		if (empty($tag)) {
			success('文章修改成功');
		}else{
			// 删除tag
		 	$tagDelSql = "DELETE * FROM tag WHERE art_id = $artId";
		 	queryMysql($tagDelSql);

		 	// 重新添加tag
		 	$tagSql = "INSERT tag(art_id, tag) VALUES";
		 	$tag = explode(',', $tag);

		 	foreach ($tag as $tagitem) {
		 		$tagSql .= "(".$artId.",'".$tagitem."'),";
		 	}
		 	$tagSql = rtrim($tagSql, ",");

		 	if (queryMysql($tagSql)) {
		 		success('文章修改成功');
		 	}

		}
	}
}


 ?>
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

	// 图片上传
	if (!($_FILES['pic']['name'] == ' ') && $_FILES['pic']['error'] == 0) {
		// 图片上传不为空，且上传成功的话
		$des = createDir().'/'.randStr().getExe($_FILES['pic']['name']);
		if (move_uploaded_file($_FILES['pic']['tmp_name'], ROOT.$des)) {
			// 如果移动成功,在数据库中添加该pic的字段
			$art['pic'] = $des;
			// 字段保存的是相对路径，因为在linux等等系统没有c,e等等
			// 所以在数据库存的是相对路径
			// /upload/2017/03/28/JepWYG.jpg
			
			//加上缩略图
			$art['thumb'] = makeThumb($des);
		}
	}

	$art['pubtime'] = time();
	// 收集tag----这个是一个冗余字段
	// 但是为了查询更加方便，sql执行更快，可以添加
	$art['arttag'] = trim($_POST['tag']);

	//如果都满足条件，这可以提交到后台，并写入数据库中
	$artInsertRes = execMysql('art', $art);
	if (!$artInsertRes) {
		// 文章添加成功，将cat表即当前栏目下的文章数加+1;
		$catNumSql = "UPDATE cat SET num = num - 1 WHERE cat_id =".$art['cat_id'];
		queryMysql($catNumSql);
		error('文章发表失败');
	}else{
		// 判断是否有tag
		$art['tag'] = trim($_POST['tag']);
		// 没有tag,直接提示文章添加成功
		if ($art['tag'] == '') {
			// 文章添加成功，将cat表即当前栏目下的文章数加+1;
			$catNumSql = "UPDATE cat SET num = num + 1 WHERE cat_id =".$art['cat_id'];
			queryMysql($catNumSql);
			success('文章添加成功');
		}else{
			// 获取上一次insert操作产生的主键id
			$art_id = getLastId();
			// 插入tag 到tag表中
			/*
			INSERT tag(art_id, tag) VALUES($art_id, 'php'), 
			($art_id, 'javasript'),
			($art_id, 'css');
			同一文章，关联着多个标签。这个需要自己拼接sql,
			刚才我们封装的那个函数execMysql,这个是插入一行才能用
			 */
			$tagSql = "INSERT tag(art_id, tag) VALUES";
			// 我们假定tag的添加时通过,来进行分割的，所以，在post过来时，我们
			// 我们通过，进行分割，把其中内容分别插入数据库中
			$tag = explode(',', $art['tag']);

			foreach ($tag as $tagitem) {
				$tagSql .= "(".$art_id.",'".$tagitem."'),";
			}
			$tagSql = rtrim($tagSql, ",");

			// 执行sql
			if (queryMysql($tagSql)) {
				// 文章添加成功，将cat表即当前栏目下的文章数加+1;
				$catNumSql = "UPDATE cat SET num = num + 1 WHERE cat_id =".$art['cat_id'];
				queryMysql($catNumSql);
				success('文章添加成功');
			}else{
				// tag 添加失败,那么就把文章删掉，
				// 因为一个文章要添加成功，那么标签也要成功
				$tagDelSql = "DELETE FROM art WHERE art_id = $art_id";
				// 删除文章成功
				if (queryMysql($tagDelSql)) {
					// 文章添加成功，将cat表即当前栏目下的文章数加+1;
					$catNumSql = "UPDATE cat SET num = num - 1 WHERE cat_id =".$art['cat_id'];
					queryMysql($catNumSql);
					// 文章添加失败
					error('文章添加失败');
				}
			}

		}
		
	}



}

	

 ?>
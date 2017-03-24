<?php 
/**
 * 添加栏目的页面
 */

// 引入初始化
require('lib/init.php');


if (empty($_POST)) {
	// 如果post的请求为空的话，那么就显示本页面的模板
	require(ROOT.'/view/admin/catadd.html');
}else{
	// 不为空的话，判断前端页面提交过来的值，
	// 不能为空，且去掉前后空格，也不能为空
	// 当然，在具体的开发过程中，还有其他的验证条件
	
	$cat['catname'] = trim($_POST['catname']);
	if (empty($cat['catname'])) {
		error('栏目名称不能为空');
		exit();
	}

	//如果前面的判断通过的话，连接数据库查询是否已经存在
	//相同的栏目名，这提示不能创建相同的栏目名
	 
		// 查看是否重复的栏目名
		$sql = "SELECT COUNT(*) FROM cat WHERE catname = '{$cat['catname']}'";

		// 返回一个资源
		$rs = queryMysql($sql);

		/*
		// mysqli_query returns false if something went wrong with the query
		if($result === FALSE) { 
		    yourErrorHandler(mysqli_error($mysqli));
		}
		else {
		    // as of php 5.4 mysqli_result implements Traversable, so you can use it with foreach
		    foreach( $result as $row ) {
		        ...		
		 */
		if ($rs === false) {
			echo '出错了';
		}else{
			if (mysqli_fetch_row($rs)[0] != 0 ) {
				//  mysqli_fetch_row() expects parameter 1 to be 
				//  mysqli_result, boolean given in 
				//  这个函数需要一个mysqli_result的参数，你给了Boolean的参数
				error('栏目名称已经存在，请重新命名');
				exit();
			}else{
				if (!execMysql('cat', $cat)) {
			// $addSql = "INSERT cat(catname) VALUES('{$cat['catname']}')";
					echo mysqli_error();
				}else{
					 success('添加成功');
				}
				
			}
		}
}

 ?>
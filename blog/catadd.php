<meta charset="utf-8">
<?php 
/**
 * 添加栏目的页面
 */


if (empty($_POST)) {
	// 如果post的请求为空的话，那么就显示本页面的模板
	require('view/admin/catadd.html');
}else{
	// 不为空的话，判断前端页面提交过来的值，
	// 不能为空，且去掉前后空格，也不能为空
	// 当然，在具体的开发过程中，还有其他的验证条件
	
	$catname = trim($_POST['catname']);
	if (empty($catname)) {
		exit('栏目名称不能为空');
	}



	//如果前面的判断通过的话，连接数据库查询是否已经存在
	//相同的栏目名，这提示不能创建相同的栏目名
	 
	 //连接数据库
	$conn = mysqli_connect('localhost', 'root', 'ann0707', 'blog');
	if (mysqli_connect_errno($conn)) {
		// 连接失败
		echo '连接mysq失败'.mysqli_connect_error();
	}else{
		// 连接成功
		// 设置字符集
		mysqli_query($conn, 'SET NAMES utf8');

		// 查看是否重复的栏目名
		$sql = "SELECT COUNT(*) FROM cat WHERE catname = '{$catname}'";
		$rs = mysqli_query($conn, $sql);

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
			var_dump(mysqli_fetch_row($rs));
			if (mysqli_fetch_row($rs) != 0 ) {
				//  mysqli_fetch_row() expects parameter 1 to be 
				//  mysqli_result, boolean given in 
				//  这个函数需要一个mysqli_result的参数，你给了Boolean的参数
				echo '栏目名称已经存在，请重新命名';
				exit();
			}else{
				$addSql = "INSERT CAT(catname) VALUES('{$catname}')";
				if (!mysqli_query($conn, $addSql)) {
					echo mysqli_errno();
				}else{
					echo '添加成功';
				}
			}
		}
	}
	// 关闭数据库
	mysqli_close($conn);

}




 ?>
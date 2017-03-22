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
	
	$cat['catname'] = trim($_POST['catname']);
	if (empty($cat['catname'])) {
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
		$sql = "SELECT COUNT(*) FROM cat WHERE catname = '{$cat['catname']}'";
		$rs = mysqli_query($conn, $sql);
		if (mysqli_fetch_row($rs)[0] !=0 ) {
			echo '栏目名称已经存在，请重新命名';
			exit();
		}else{
			$addSql = "INSERT CAT(catname) VALUES('{$cat['catname']}')";
			if (!mysqli_query($conn, $addSql)) {
				echo mysqli_errno();
			}else{
				echo '添加成功';
			}

		}
	}


}




 ?>
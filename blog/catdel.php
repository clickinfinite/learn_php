<meta charset="utf-8">
<?php 

/**
 * 栏目删除
 */


 //连接数据库
$conn = mysqli_connect('localhost', 'root', 'ann0707', 'blog');
if (mysqli_connect_errno($conn)) {
	// 连接失败
	echo '连接mysq失败'.mysqli_connect_error();
}else{
	// 连接成功
	// 设置字符集
	mysqli_query($conn, 'SET NAMES utf8');

	// 判断cat_id是否为数字，因为cat_id是从地址栏中获取的，
	// 可以人为的在地址栏进行修改,提交到后台
	// catdel.php?cat_id=1----所以必须对cat_id进行删除
	// 不然，mysql删除where cat_id= '非数字'会进行报错
	
	$catid = $_GET['cat_id'];  //获取的是一个string的数字
	if (!is_numeric($catid)) {
		//判断栏目是否为数字或者数字字符串
		echo '不存在该栏目，检测栏目id是否正确';
		exit();
	}

	// 到这里，需要检测栏目id是否存在，如果没有栏目id
	// 即人为的输入数字，那么在nysql中查找的话，还是
	// 会报错。
	
	$catSql = "SELECT COUNT(*) FROM cat WHERE cat_id = '{$catid}'";
	$result = mysqli_query($conn, $catSql);

	if ($result === false) {
		echo "栏目sql查询出错了";
		exit();
	}else{
		// $result如果查到了就存在栏目id
		// 如果没有查到则不存在栏目id
		$catRow = mysqli_fetch_row($result);
		if ($catRow[0] == 0) {
			echo "栏目名不存在";
			exit();
		}

	}

	//栏目下有文章，则不能进行删除
	$artSql = "SELECT COUNT(*) FROM art WHERE cat_id = '{$catid}'";
	$artResult = mysqli_query($conn, $artSql);
	if ($artResult === false) {
		echo "栏目下文章sql查询出错了";
		exit();
	}else{
		// $result如果查到了就存在栏目id
		// 如果没有查到则不存在栏目id
		$artRow = mysqli_fetch_row($artResult);
		if ($artRow[0] != 0) {
			echo "该栏目下有文章,不能删除";
			exit();
		}
	}


	// 删除判断都完成了，则可以进行删除
	$delSql = "DELETE FROM cat WHERE cat_id = '{$catid}'";
	$delRes = mysqli_query($conn, $delSql);
	if ($delRes === false) {
		echo "删除发生错误";
		exit();
	}else{
		// $result如果查到了就存在栏目id
		// 如果没有查到则不存在栏目id
		echo "删除成功";
	}
	
}

mysqli_close($conn);

 ?>
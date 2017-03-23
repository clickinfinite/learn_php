<meta charset="utf-8">
<?php 

/**
 * 栏目列表页面
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
	$sql = "SELECT * FROM  cat";
	$result = mysqli_query($conn, $sql);

	// 判断查询是否出错
	if ($result === false) {
		echo "查询sql出错了";
	}else{
		$catlist = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$catlist[] = $row;
		}
		/*
			//print_r($catlist);
			Array ( 
			[0] => Array ( [cat_id] => 1 [catname] => 人生 [num] => 0 ) [1] => Array ( [cat_id] => 2 [catname] => 哲学 [num] => 0 ) [2] => Array ( [cat_id] => 3 [catname] => 技术 [num] => 0 ) [3] => Array ( [cat_id] => 5 [catname] => 生物 [num] => 0 ) 
			) 
		 */
	}
}
require('view/admin/catlist.html');
mysqli_close($conn);

 ?>
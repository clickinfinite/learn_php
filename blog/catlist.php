<?php 

/**
 * 栏目列表页面
 */

 //连接数据库
require('lib/init.php');

$sql = "SELECT * FROM  cat";
$catlist = getAllData($sql);
// 判断查询是否出错
// if ($result === false) {
// 	echo "查询sql出错了";
// }else{
// 	$catlist = array();
// 	while ($row = mysqli_fetch_assoc($result)) {
// 		$catlist[] = $row;
// 	}
	/*
		//print_r($catlist);
		Array ( 
		[0] => Array ( [cat_id] => 1 [catname] => 人生 [num] => 0 ) [1] => Array ( [cat_id] => 2 [catname] => 哲学 [num] => 0 ) [2] => Array ( [cat_id] => 3 [catname] => 技术 [num] => 0 ) [3] => Array ( [cat_id] => 5 [catname] => 生物 [num] => 0 ) 
		) 
	 */
// }
require(ROOT.'/view/admin/catlist.html');
 ?>
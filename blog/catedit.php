<?php 

/**
 * 栏目编辑
 */
// 进入模板页面，如果没有post，那么栏目名称
// input的值，为$_GET的栏目id对于的栏目名称
// 如果用户输入了，则修改栏目id对应的栏目名称

// 引入初始化
require('lib/init.php');

	// 从catlist.html----编辑获取cat_id
	$catid = $_GET['cat_id'];

	if (empty($_POST)) {
		// 从数据库中, 查询栏目id对应的栏目名称
		$getNameSql = "SELECT catname FROM cat WHERE cat_id = '{$catid}'";

		$cat = getRowData($getNameSql);
		require(ROOT.'/view/admin/catedit.html');
		/*$NameRes = mysqli_query($conn, $getNameSql);
		if ($NameRes === false) {
			echo "栏目名称sql查询出错了";
			exit();
		}else{
			$NameRow = mysqli_fetch_assoc($NameRes);
			 
			var_dump($NameRow);
			 结果是一个数组
			 array (size=1)
  			'catname' => string '技术' (length=6)
			 
			$cat = $NameRow;
			require('view/admin/catedit.html');
		}*/
	}else{
		// 修改cat_id对于栏目名称d
		// 先判断栏目名称是否为空
		
		$catName['catname'] = trim($_POST['catname']);

		if ($catName['catname'] == '') {
			error("栏目名称不能为空");
			exit();
		}


		// $updateNameSql = "UPDATE cat SET catname = '{$catname}' WHERE cat_id = '{$catid}'";
		$updateNameRes = execMysql('cat', $catName, $act='UPDATE', $where="cat_id={$catid}");

		if (!$updateNameRes) {
			error("mysql中,更新栏目名称失败");
		}else{
			success("栏目名称修改成功");
		}

	}

	

 ?>
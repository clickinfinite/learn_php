<?php 

/**
 * 评论列表
 */



// 从数据库中,查找评论,然后遍历评论,放在模板中。


// 引入初始化
require('lib/init.php');

// 查询所有的评论数据
$comListSql = "SELECT * FROM comment";

// 把查询到的信息保存的二维数组，保存到$comm变量
$comm = getAllData($comListSql);

require(ROOT.'/view/admin/commlist.html');	

 ?>
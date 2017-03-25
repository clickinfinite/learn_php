<?php 

/**
 * 文章列表
 */



// 从数据库中，查找文章，然后遍历文章
// 放在模板中


// 引入初始化
require('lib/init.php');

// 使用左连接擦查询文章相关信息以及栏目表中的栏目名称
$artListSql = "SELECT art.*, cat.catname FROM art LEFT JOIN cat ON art.cat_id = cat.cat_id";

// 把查询到的信息保存的二维数组，保存到$art变量
$art = getAllData($artListSql);

require(ROOT.'/view/admin/artlist.html');	

 ?>
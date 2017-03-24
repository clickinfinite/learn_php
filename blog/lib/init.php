<?php 

// 初始化
header('Content-type:text/html;charset=utf8');

// 魔术常量的值，取决于写在那个文件中，不会
// 受到include和include的影响


/*
echo __DIR__."<br/>";
echo __FILE__."<br/>";
echo __LINE__;
E:\wamp\www\test1\lib-----该文件的所在的目录
E:\wamp\www\test1\lib\init.php----该文件的目录名加上文件名
11------该文件中，这句话所在的行数
 */



// 因为，在文件中include与require，写的相对路径
// 会因为某些路径不对，导致文件加载不出来而出错
// 所以，在文件之间来回的引用肯定会出错，所以不要
// 使用相对路径，用绝对路径-----初始化当前的环境信息
// 计算出当前网站的根路径在哪里


// 计算出当前根目录
/*
如需设置常量，请使用 define() 函数 - 它使用三个参数：
首个参数定义常量的名称
第二个参数定义常量的值
可选的第三个参数规定常量名是否对大小写敏感。默认是 false。
 */
define('ROOT', dirname(__DIR__));
require(ROOT.'/lib/mysql.php');
require(ROOT.'/lib/common.php');

?>
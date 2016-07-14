<html>
<head>
  <meta charset="utf-8">
  <title>留言本的存储小练习</title>
</head>
<body>
<p>留言本的存储小练习</p>
<?php
/* 
  php打开文件 fopen(filename, mode)

  第一个参数是打开的文件名，第二个参数是打开的模式
  注意打开当前目录下的文件是用-----./
  第二个参数先了解一个a(append),即追加模式，不删除前面的
  内容，在后面添加内容。
  这两个键key即在前端的form表单中的name值
  $_post这个数组里面的内容---$_post[title],$_post[content],

  在微软的记事本上面没有看到换行，那是因为微软的换行不是
  \n----而是\r\n,可以用sublime打开，就会有换行出现了

*/
// 从前端获取的值,加上一个换行符，代表追加的一行一行的分开
$str = $_POST['title'].','.$_POST['content'].'\n';

$fh = fopen('./msg.txt', 'a'); //打开文件赋值给一个变量

// 写文件，进入打开文件的变量,对于第二个参数应该是从前端获取的
fwrite($fh, $str);

// 关闭资源文件
fclose($fh);

echo "ok";
?>
</body>
</html>


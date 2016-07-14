<html>
<head>
  <meta charset="utf-8">
  <title>留言本的读取小练习</title>
</head>
<body>
<p>留言本的读取小练习</p>
<?php
// 地址栏的读取方式,手动的在地址栏进行输入查询
$tid = $_GET['tid'];

// 打开得到的文件,r代表只读模式,打开的路径赋值给$fh
$fh = fopen('./msg.txt', 'r');
// 单行模式，就只读取一行，且打印的是一个数组
// print_r(fgetcsv($fh));
// 如果后面行的内容没有，那就读不出来

// 打印出你要的哪一行,先定义一个变量取到第一行
$i = 1;

// 如果想要全部打印出来，可以循环
while (($row=fgetcsv($fh)) != false) {
  //判读只要能读出来，就打印出来
  // print_r($row);
  // 判断是否是你想要的哪一行，手动输入的模式
  if ($i == $tid) {
    print_r($row);
  }
  $i++;
}
?>
</body>
</html>


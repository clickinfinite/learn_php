<html>
<head>
  <meta charset="utf-8">
  <title>Bob's Auto Parts - Order Results</title>
</head>
<body>
<p>对数组以及字符串的拼接和post以及get的简单了解</p>
<?php
// 对于地址栏的查询
/*
  对于字符串的拼接(是两个字符串中间用.号连接);
  $str1 = "小明";
  $str2 = "的裤子";
  $str = $str1.$str2;

  对于数组的定义
  $arr = array('001'=>'小明的裤子','002'=>'小红的口红');
  取得数组里面的值是数组名加上键名(key);
  echo $arr['001']; 会打印出小明的裤子

  $_GET和$_POST的区别
  在浏览器的地址栏中输入?tid=3&xid=5，print_r($_GET);
  http://localhost/index.php?tid=3&xid=5
  会打印一个数组 tid =3, xid =5
  地址栏用$_GET的数组是?tid=3&xid=5(这个数组是系统预定义的)
  print_r($_GET);
  用&的连接的是数组的每一项
  GET提交是从地址栏获取的，能看见
  POST提交时在浏览器上面是看不见的，但是后台能看见
*/
  $str1 = "小明";
  $str2 = "的裤子";
  $str = $str1.$str2;
  echo $str;
  print_r($_GET);
?>
</body>
</html>


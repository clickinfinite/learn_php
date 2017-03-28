<?php 
/*
退出登陆
 */


// 设置为null,且立即过期
setcookie('name', null, 0);
header('Location:login.php');

 ?>
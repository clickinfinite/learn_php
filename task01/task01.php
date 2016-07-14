<!DOCTYPE HTML>
<html>
    <head>
    	<meta charset="utf-8">
        <title>php的小任务</title>
    </head>
    <body>
		<h3>任务</h3>
		<p>打印一到一百的数字，但是遇到数字为3的倍数的时候，打印Fizz代替数字<br>
		5的倍数用Buzz代替数字，如果是3的倍数又是5的倍数，那么就打印abcde</p>
		<p>PHP 中的变量用一个美元符号后面跟变量名来表示。变量名是区分大小写的。 $this 是一个特殊的变量，它不能被赋值。 </p>
        <?php
        // 变量初始化为0；
           $i = 0;
           // 存放的数字
           $j ;
           while($i<100){
            	$i++;
           	// 对输出的值进行判断
           	// 先判断同时是3与5的倍数
           	if (($i%3 == 0) && ($i%5 == 0)  ) {
          		$j = "abcde";
          		echo $j,"<br/>";
          		continue;
          	// 再判断是3的倍数
           	}else if ($i%3 == 0) {
           		$j = "Fizz";
           		echo $j,"<br/>";
           		continue;
           	// 再判断5的倍数
           	}else if($i%5 == 0){
           		$j = "Buzz";
           		echo $j,"<br/>";
           		continue;
           	// 最后再输出数字
           	}else{
           		// 为什么是一个，加<br/>，而不是js的加号
           		echo $i,"<br/>";
           	}
           
           	
           }
        ?>

    </body>
</html>
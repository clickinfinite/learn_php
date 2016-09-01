<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php 
//题目1： 有一分数序列：2/1, 3/2,5/3,8/5,13/8,21/13...求出这个数列的前20项之和
	echo "hello world";
	$arr = [];
	$sum = 0;
	$fenz = 2;
	$fenm = 1;
	// 有序数列
	for ($i=0; $i < 20; $i++) { 
		$arr[$i] = $fenz/$fenm;
		$sum += $arr[$i];
		$fenz = $fenz + $fenm;
		$fenm = $fenz - $fenm;
	}
	var_dump($sum);
//题目2 假如某人有100.000现金，每经过一次路口需要进行缴费。缴费规则是当他现金大于
//50.000时，每次需要交5%，如果现金小于等于50,000每次交5000。请问此人可以经过多少个路口 

	$price=100000;  // 开始拥有的现金
	$cross=0; //路口数

	//判断条件是如果用户的钱少于5000，那么就不能通过了
	while ($price >= 5000) {
		if ($price > 50000) {
			$price = $price - $price*0.05 ;
		}else {
			$price = $price -5000;
		}

		$cross ++;
	}

	echo $cross."<br>";

    //for循环是while的变形
    for($i = 100000, $cnt = 0; $i >= 5000; ){
        if($i > 50000){
            $i *= 0.95;
        }else{
            $i -= 5000;        
        }
        
        $cnt += 1;
        
    }
	echo $cnt."<br>";

	//题目3 打印99乘法表
	$num = [1, 2, 3, 4, 5, 6, 7, 8, 9];
	$len = count($num);

	for ($j=0; $j < $len; $j++) { 
		for ($k=0; $k < $len; $k++) { 
			echo $num[$j]*$num[$k]; 
		}
	}

	echo "<br>";

	//题目4 求1到100以内的素数 质数（prime number）又称素数，除了1和它本身以外不再有其他因数。
	//在一般领域，对正整数n，如果用2到开根号之间的所有整数去除，均无法整除，则n为质数。
	//质数大于等于2 不能被它本身和1以外的数整除

	for($i=1;$i<=100;$i++){
		  $k=0;
		  for($j=1;$j<$i;$j++){
		  	//对于输出值的前面元素进行检查，只要能除以前面的数,
		      if($i%$j==0){
		      	//只能除以1和本身，那么就是$k的值为1，不然就是$k大于1;
		   		$k++; 
		   	}
		   }
		 if($k==1){
		 	echo $i;
			echo "&nbsp;&nbsp;";
		 }
	  }
?>


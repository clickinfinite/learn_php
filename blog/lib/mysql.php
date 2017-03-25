<?php 
/**
 * mysql相关操作的函数
 */



/**
 * [connectMysql 连接数据库]
 * @return [resource] [数据库返回的资源类型]
 */
function connectMysql() {
	// 静态变量使得connectMysql函数在同一个页面 数据库只连接一次
	static $conn = null;
	if ($conn === null) {
		$cfg = require(ROOT.'/lib/config.php');
		// 还没有进行数据库的连接,来进行数据库连接
		$conn = mysqli_connect($cfg['host'], $cfg['username'], $cfg['password'], $cfg['db']);
		if (mysqli_connect_errno($conn)) {
			// 连接失败
			echo '连接mysq失败'.mysqli_connect_error();
			exit();
		}else{
			// 连接成功
			// 设置字符集
			mysqli_query($conn, 'SET NAMES'.$cfg['charset']);
		}
	}

	// 返回一个资源resource
	return $conn;
}



/**
 * [queryMysql sql语句的执行]
 * @param  [string] $sql [sql语句]
 * @return [mixed]      [返回布尔值/数组]
 */
function queryMysql($sql) {
	$res = mysqli_query(connectMysql(), $sql);

	// 查询失败
	if ($res === false) {
		// mysqli_error() 函数返回最近调用函数的最后一个错误描述。
		mysqlLog($sql."n".mysqli_error(connectMysql()));
		return $res;
	}

	// 查询成功
	mysqlLog($sql);
	return $res;

}



/**
 * [mysqlLog 日志]
 * @param  [string] $log [记录的信息]
 * @return [type]      [description]
 */
function mysqlLog($str) {
	// 生成的日志文件的名字
	$path = ROOT.'/log/'.date('Ymd', time()).'.txt';
	$log = "------------------------------------------------------\n".date('Y/m/d H:i:s', time())."\n".$str."\n"."------------------------------------------------------\n";
	file_put_contents($path, $log, FILE_APPEND);
}




/**
 * [getAllData 查询select语句并返回多行，适用于查询多条数据]
 * @param  [string] $sql [select语句]
 * @return [array/mixed]      [查询成功返回二位数组，失败返回false]
 */
function getAllData($sql) {
	// 查询的结果
	$result = queryMysql($sql);

	if (!$result) {
		// mysql查询出错
		echo "查询sql出错";
		return false;
	}else{
		// mysql查询正确
		$arr = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$arr[] = $row;
		}
	}

	return $arr;
}


/**
 * [getRowData 查询select语句并返回一行数据]
 * @param  [string] $sql [description]
 * @return [mixed/array]      [成功返回一维数组或者false]
 */
function getRowData($sql) {
	$result = queryMysql($sql);
	return $result ? mysqli_fetch_assoc($result) : false;
}



/**
 * [getOneData 查询select语句并返回一个单元]
 * @param  [string] $sql [查询的select语句]
 * @return [mixed/string]      [查询到的话返回一位数组中第一个值，没有查到返回false]
 */
function getOneData($sql) {
	$result = queryMysql($sql);
	if (!$result) {
		// mysql查询出错
		echo "查询sql出错";
		return false;
	}else{
		// mysql查询正确
		$row = mysqli_fetch_row($result);
		return $row[0];
	}
}






/**
 * [execMysql 自动拼接insert 和 update sql语句,并且调用queryMysql() 去执行sql]
 * @param  [string]  $table [表名]
 * @param  [array]   $data  [接收到的数据,一维数组]
 * @param  string    $act   [$act 动作 默认为'insert']
 * @param  string    $where [$where 防止update更改时少加where条件]
 * @return [bool]           [insert 或者update 插入成功或失败 ]
 */
function execMysql($table, $data, $act='INSERT', $where='0') {

	/*
	implode函数----字符串的拼接
	<?php
		$arr = array('Hello','World!','Beautiful','Day!');
		echo implode(" ",$arr);
	?>
	Hello World! Beautiful Day!

	array_keys----返回的是一个索引数组，值为key
	array_values----返回的是一个索引数组，值为value
	 */
	
	if ($act == 'INSERT') {
		$sql = "INSERT $table(";
		$sql .= implode(',', array_keys($data)).") VALUES ('";
		$sql .= implode("','", array_values($data))."')";
		return queryMysql($sql);
	}else if($act == 'UPDATE') {
		$sql = "UPDATE $table SET ";
		foreach ($data as $key => $value) {
			// UPDATA table set catname = 'xx';
			$sql .= $key . "='" . $value . "',";
		}
		//从字符串右侧移除字符
		$sql = rtrim($sql, ',') . " WHERE ".$where;
		return queryMysql($sql);
	}

}


/**
 * 拼接字符串的---参考下面的真实数据
 * INSERT
 * $data = array('title'=>'今天的空气' , 'content'=>'空气质量优' , 'pubtime'=>12345678,'author'=>'baibai');
   insert art (title,content,pubtime,author) values ('今天的空气','空气质量优','12345678','baibai');

   // UPDATE
   update art set title='今天的空气',conte='空气质量优',pubtime='12345678',author='baibai' where art_id=1;
 */



/**
 * [getLastId 取得上一步insert 操作产生的主键id]
 * @return [number] [id]
 */
function getLastId() {
	// 假设 websites 表有一个自动生成的 ID 字段。返回最后一次查询中的 ID：
	return mysqli_insert_id();
}



?>
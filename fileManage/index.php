<?php 
require_once 'dirfunc.php';
require_once 'filefunc.php';
$path = 'file';
$info = readDirectory($path);
?>
<!DOCTYPE html>
<html>
<head lang="zh-cmn-Hans">
    <meta charset="UTF-8">
    <title>WEB在线文件管理</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<h2>WEB在线文件管理</h2>
	<ul>
		<li><a href="index.php"></a>主目录</li>
		<li>新建文件</li>
		<li>新建文件夹</li>
		<li>上传文件</li>
		<li>返回上级目录</li>
	</ul>
	<table>
		<tr>
			<th>编号</th>
			<th>名称</th>
			<th>类型</th>
			<th>大小</th>
			<th>是否可读</th>
			<th>是否可写</th>
			<th>是否可执行</th>
			<th>创建时间</th>
			<th>修改时间</th>
			<th>访问时间</th>
			<th>操作</th>
		</tr>
		<?php
		//如果返回的数组中存在文件 
			if ($info['file']) {
				$i = 0;
				// 则开始遍历文件
				foreach ($info['file'] as $val) {	
		 ?>
		 <!-- 在php标签外的html等内容 就自动当做是php的输出了 -->
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $val; ?></td>
				<td><?php echo filetype($path.'/'.$val) ?></td>
				<td><?php echo transBytes(filesize($path.'/'.$val)) ?></td>
				<td><?php if(is_readable($path.'/'.$val)) {echo '可读';}else{echo '不可读';}  ?></td>
				<td><?php if(is_writable($path.'/'.$val)) {echo '可写';}else{ echo '不可写';}  ?></td>
				<td><?php if(is_executable($path.'/'.$val)) {echo '可执行';}else{ echo '不可执行';}  ?></td>
				<td><?php echo date('Y-m-d H:i:s', filectime($path.'/'.$val)) ?></td>
				<td><?php echo date('Y-m-d H:i:s', filemtime($path.'/'.$val)) ?></td>
				<td><?php echo date('Y-m-d H:i:s', fileatime($path.'/'.$val)) ?></td>
				<td>
					<a href="#">查看</a>
					<a href="#">修改</a>
					<a href="#">重命名</a>
					<a href="#">复制</a>
					<a href="#">剪切</a>
					<a href="#">删除</a>
					<a href="#">下载</a>
				</td>
			</tr>
		 <?php 
		 	$i++;
		 		}
		 	}
		  ?>
		<!-- 
			上面可以这样理解$i++为foreach的内容
		 -->
	</table>
</body>
</html>
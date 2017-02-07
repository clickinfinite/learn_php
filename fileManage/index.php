<?php 
require_once 'dirfunc.php';
require_once 'filefunc.php';
require_once 'commonfunc.php';
$path = 'file';
// 查询所有post get cookie的值
$act = $_REQUEST['act'];
$filename = $_REQUEST['filename'];
$info = readDirectory($path);
$redirect = "index.php?path={$path}";
// 创建文件
if ($act == 'createfile') {
	$mes = createFile($path.'/'.$filename);
	alertMes($mes, $redirect);
}elseif ($act == 'showcontent') {
	//查看文件内容
	$content = file_get_contents($filename);
	$newContent = highlight_string($content, true);
	// 把文件的内容以只读的方式显示在文本域中
	//echo "<textarea readonly='readonly'>{$content}</textarea>";
	//高亮显示字符串的PHP代码
	//highlight_string($content);
	//高亮显示文件中的PHP代码
	//highlight_file($filename)
	//判断是否存在内容，有内容才显示，没有内容给用户提示
	if (strlen($content)) {
		$str = <<<DOG
		<div class='file-content'>{$newContent}</div>
DOG;
		echo $str;
	}else {
		alertMes('文件没有内容，请先编辑再查看', $redirect);
	}
}elseif ($act == 'editcontent') {
	//修改文件
	//得到文件中的内容
	$content = file_get_contents($filename);
	// 要对文件内容进行编辑，必须把文件放入多行文本框中，
	// 或者hmtl的在线编辑器中
	$str = <<<DOG
	<form action="index.php?act=doEdit" method="post" class="edit-content">
		<textarea name='content'>{$content}</textarea>
		<input type="hidden" name='filename' value="{$filename}">
		<input type="submit" value='确认修改'>
	</form>
DOG;
echo $str;
}elseif ($act == 'doEdit') {
	//修改文件操作
	$content = $_REQUEST['content'];
	if (file_put_contents($filename, $content)) {
		$mes = '文件修改成功';
	}else {
		$mes = '文件修改失败';
	}
	alertMes($mes, $redirect);
}elseif ($act == 'renamefile') {
	//重命名文件名
	 $str = <<<DOG
	<form action="index.php?act=doRename" method="post" class="edit-content">
		请填写新的文件名<input type="text" name="newname" placeholder="请填写新的文件名">
		<input type="hidden" name='filename' value="{$filename}">
		<input type="submit" value='确认重命名'>
	</form>
DOG;
	echo $str;
}elseif ($act == 'doRename') {
	//实现重命名的操作
	$newname = $_REQUEST['newname'];
	//接收传进来的新名字
	$mes = renameFile($filename, $newname);
	alertMes($mes, $redirect);
}elseif ($act == 'delFile') {
	//删除文件的操作
	$mes = delFile($filename);
	alertMes($mes, $redirect);
}elseif ($act == 'download') {
	//完成下载的操作
	downloadFile($filename);
}
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
		<li id="createFile">新建文件</li>
		<li id="createFolder">新建文件夹</li>
		<li id="uploadFile">上传文件</li>
		<li id="backDir">返回上级目录</li>
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
				<?php 
				//得到文件扩展名
					$ext = pathinfo($val, PATHINFO_EXTENSION);
					$imgExt = array('git', 'jpg', 'jpeg', 'png');
					if (in_array($ext, $imgExt)) {
					?>
						<a href="#" title="查看" onclick="showPic('<?php echo $val; ?>', '<?php echo $path.'/'.$val?>')">查看</a>
					<?php
					}else{
				 	?>
					<a href="index.php?act=showcontent&filename=<?php echo $path.'/'.$val; ?>" title="查看">查看</a>
					<?php 
						} 
					?>
					<a href="index.php?act=editcontent&filename=<?php echo $path.'/'.$val; ?>" title="修改">修改</a>
					<a href="index.php?act=renamefile&filename=<?php echo $path.'/'.$val; ?>" title="重命名">重命名</a>
					<a href="index.php?act=copy&filename=<?php echo $path.'/'.$val; ?>" title="复制">复制</a>
					<a href="index.php?act=move&filename=<?php echo $path.'/'.$val; ?>" title="剪切">剪切</a>
					<a href="#" onclick="delFile('<?php echo $path.'/'.$val; ?>')" title="删除">删除</a>
					<a href="index.php?act=download&filename=<?php echo $path.'/'.$val; ?>" title="下载">下载</a>
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
	<!-- 显示图片文件 -->
	<div class="show-img"></div>
	<!-- 遮罩层 -->
	<div class="shadow"></div>
	<!-- 主要的操作 -->
	<form action="index.php" class="main-handle">
		<div class="create-file">
			<h3>创建文件</h3>
			<div>文件名：<input type="text" name="filename" placeholder="请输入文件名"></div>
			<!-- 这个隐藏域是文件创建在那个路径下 -->
			<input type="hidden" name="path" value="<?php echo $path ?>">
			<!-- 这个隐藏域是因为创建文件文件夹..操作，都是在index.php这一个页面完成，所以需要区分各种操作 -->
			<input type="hidden" name="act" value="createfile">
			<input type="submit" value="创建文件">
		</div>
	</form>
	<script src="fileManage.js"></script>
</body>
</html>
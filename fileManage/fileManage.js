// 创建文件
var createFile = document.getElementById('createFile');
var	createFileBox = document.querySelector('.create-file');
var shadow = document.querySelector('.shadow');
var showImg = document.querySelector('.show-img');
var fileContent = document.querySelector('.file-content');

createFile.addEventListener('click', function(){
	createFileBox.style.display = 'block';
	shadow.style.display = 'block';
}, false);

shadow.addEventListener('click', function(){
	this.style.display = 'none';
	createFileBox.style.display = 'none';
}, false);

/**
 * [图片文件的预览]
 * @param  {[string]} name [图片的文件名]
 * @param  {[string]} src  [图片的地址]
 */
function showPic(name, src) {
	var str = '<h3>' + name + '</h3><img src="'+src+'">';
	showImg.innerHTML= str;
	showImg.style.display = 'block';
	if (fileContent) {
		fileContent.style.display = 'none';
	}
}

/**
 * [删除文件]
 * @param  {[string]} filename [文件路径]
 */
function delFile(filename) {
	if (window.confirm('您确定要删除文件吗？删除之后文件无法恢复')) {
		location.href = 'index.php?act=delFile&filename=' + filename;
	}
}
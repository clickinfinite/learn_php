<?php  

/**
* 
*/
class upload{

	protected $fileName;
	protected $maxSize;
	protected $allowMime;
	protected $allowExt;
	protected $uploadPath;
	protected $imgFlag;
	protected $fileInfo;
	protected $error = null;
	protected $ext = null;
	protected $uniName = null;
	protected $destination = null;


	//构造函数，一开始就执行的函数
	public function __construct($fileName = 'myfile', $uploadPath ='./uplaods', $imgFlag= true, $maxSize=5242880, $allowExt=array('jpeg', 'jpg', 'png', 'gif'), $allowMime=array('image/jpeg', 'image/png','image/jpg', 'image/gif'))
	{
		$this ->fileName = $fileName;
		$this ->maxSize = $maxSize;
		$this ->allowMime = $allowMime;
		$this ->allowExt = $allowExt;
		$this ->uploadPath = $uploadPath;
		$this ->imgFlag = $imgFlag;
		$this ->fileInfo = $_FILES[$this->fileName];
	}

	/**
	 * 检测文件是否出错
	 * @return boolean
	 */
	protected function checkError() {
		// var_dump($this->ext);
		if (!$this ->fileInfo == null) {
			if ($this ->fileInfo['error'] > 0) {
				switch ($this ->fileInfo['error']) {
					case 1:
						$this->error = "上传文件的大小超出了 upload_max_filesize约定值";
						break;
					case 2:
						$this->error = "上传文件大小超出了HTML表单隐藏域属性的MAX＿FILE＿SIZE元素所指定的最大值";
						break;
					case 3:
						$this->error = "文件只被部分上传";
						break;
					case 4:
						$this->error = "没有上传任何文件";
						break;
					case 6:
						$this->error = "找不到临时文件夹";
						break;
					case 7:
						$this->error = "文件写入失败";
						break;
					case 8:
						$this->error = "上传文件被PHP扩展程序中断";
						break;
				}
				return false;
			}else {
				return true;
			}
		}else {
			$this->error = "文件上传出错,fileName参数未正确传入";
			return false;
		}
		
	}

	/**
	 * 检测文件是否在限制的大小之内
	 * @return boolean
	 */
	public function checkSize() {
		if ($this ->fileInfo['size'] > $this ->maxSize) {
			$this->error = '上传文件过大';
			return false;
		}
		return true;
	}

	/**
	 * 检测文件扩展名是否是规定的类型
	 * @return boolean
	 */
	public function checkExt() {
		$this->ext = strtolower(pathinfo($this->fileInfo['name'], PATHINFO_EXTENSION));
		if (!in_array($this->ext, $this->allowExt)) {
			$this->error = '文件类型不符合规定的上传类型';
			return false;
		}
		return true;
	}


	/**
	 * 检测文件的MIME类型
	 * @return boolean
	 */
	public function checkMime() {
		if (!in_array($this->fileInfo['type'], $this->allowMime)) {
			$this->error = '文件上传的MIME类型不符合规范';
			return false;
		}
		return true;
	}

	/**
	 * 检测文件是否为真实的图片类型
	 * @return boolean
	 */
	public function checkTrueImg() {
		if ($this->imgFlag) {
			if (!getimagesize($this->fileInfo['tmp_name'])) {
				$this->error = '文件不是真实的图片类型';
				return false;
			}
			return true;
		}
	}


	/**
	 * 检测文件是否通过HTTPpost方法传过来的
	 * @return boolean
	 */
	public function checkHTTPPost() {
		if (!is_uploaded_file($this->fileInfo['tmp_name'])) {
			$this->error = '文件不是通过HTTPpost上传过来的';
			return false;
		}
		return true;
	}


	/**
	 * 显示错误
	 */
	protected function showError() {
		exit('<span style="color:red">'.$this->error.'</span>');
	}



	/**
	 * 检测目录不存在，则创建目录
	 */
	protected function checkUploadPath() {
		if (!file_exists($this ->uploadPath)) {
			mkdir($this ->uploadPath, 0777, true);
			chmod($this ->uploadPath, 0777);
		}
		$this->uniName = md5(uniqid(microtime(true), true)).'.'.$this->ext;//确保文件名唯一
		// 判断错误代码，是否上传成功，不成功输出错误原因
		$this->destination = $this ->uploadPath.'/'.$this->uniName;

	}


	/**
	 * 上传文件
	 */
	public function uploadFile()
	{
		// 满足服务器对上传文件的各种限制的话，就上传
		if ($this->checkError() && $this->checkSize() && $this->checkExt() && $this->checkMime() && $this->checkTrueImg() && $this->checkHTTPPost()) {
			// 创建上传文件存放的目录
			$this->checkUploadPath();
			// 移动目录
			if (move_uploaded_file($this->fileInfo['tmp_name'], $this->destination)) {
				return $this->destination;
			}else{
				$this->error = '文件移动失败';
				$this->showError();
			}

		// 不然的话，显示错误
		}else {
			$this->showError();
		}
	}
}

?>
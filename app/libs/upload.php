<?php
	class UploadLib
	{
		var $config = array(
			'fileField' => 'myfile',
			'destDir' => 'uploads',
			'maxFileSize' => 1048576,
			'extAllowed' => array('png', 'jpg', 'jpeg', 'gif'),
			'randomName' => false
		);

		var $error = "";

		public function checkType($type, $ext)
		{
			$types = array(
				'image/png' => array('png'),
				'image/jpeg' => array('jpg', 'jpeg', 'jpe'),
				'image/gif' => array('gif'),
				'application/msword' => array('doc', 'docx'),
				'application/vnd.ms-excel' => array('xls', 'xlsx'),
				'application/vnd.ms-powerpoint' => array('ppt', 'pptx', 'pps'),
				'application/pdf' => array('pdf'),
				'text/plain' => array('txt'),
				'application/zip' => array('zip')
			);

			return in_array($ext, $types[$type]);
		}

		public function getRandomName($ext)
		{
			$fileName = time() . ((int) rand() % 1000 ) . ((int) rand() % 1000 ) . strrev(time()) . "." . $ext;
			return $fileName;
		}

		public function getExt($fileName)
		{
			$path_info = pathinfo($fileName);
			if (! isset($path_info['extension'])) return false;
    		return strtolower($path_info['extension']);
		}

		public function setConfig($config)
		{
			foreach ($config as $key => $value) {
				$this->config[$key] = $value;
			}
		}

		public function uploadFile()
		{
			$config = $this->config;

			if (isset($_FILES[$config['fileField']]))
			{
				$file = $_FILES[$config['fileField']];
				
				$fileType = $file['type'];
				$fileExt = $this->getExt($file['name']);

				if (in_array($fileExt, $config['extAllowed']))
				{
					if ($this->checkType($fileType, $fileExt))
					{
						if ($file['size'] <= $config['maxFileSize'])
						{
							$fileName = ($config['randomName']) ? $this->getRandomName($fileExt) : $file['name'];
							$targetPath = $config['destDir'] . "/" . $fileName;
							move_uploaded_file($file['tmp_name'], $targetPath);
							return $targetPath = $config['destDir'] . "/" . $fileName;
						}
					}
					else
					{
						$this->error = "Wrong file type !";
						return false;
					}
				}
				else
				{
					$this->error = "Wrong file type !";
					return false;
				}
			}
			else
			{
				$this->error = "File not found !";
				return false;
			}
		}
	}
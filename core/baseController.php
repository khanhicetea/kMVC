<?php

	class baseController
	{
		var $objects = array();
		var $db = null;
		var $segments = array();

		public function __construct($segments)
		{
			if (is_array($segments))
				$this->segments = $segments;
		}

		public function __destruct()
		{
			$this->db = null;
		}

		public function __get($name)
		{
			if (isset($this->objects[$name]))
				return $this->objects[$name];
			return false;
		}

		public function __set($name, $value)
		{
			if (is_object($value))
				$this->objects[$name] = $value;
			return false;
		}

		public function loadModel($modelPath)
		{
			if (! is_file(APP_DIR . "/models/" . $modelPath . ".php"))
			{
				die("$modelPath is not exists !");
			}

			// Load DB Driver
			if ($this->db === null)
			{
				$this->db = mysql_connect( DB_HOST , DB_USER , DB_PASS);
				if (!$this->db)
					die("Couldn't connect to database server !");

				// Select DB Name
				mysql_select_db(DB_NAME , $this->db);
				mysql_set_charset('utf8', $this->db); 
			}

			// Hook model
			require_once(APP_DIR . "/models/" . $modelPath . ".php");

			$modelName = ucfirst(basename(APP_DIR . "/models/" . $modelPath . ".php", ".php")) . "Model";

			if (! class_exists($modelName))
				die("Class $modelName is not found !");

			// Set new class
			$this->$modelName = new $modelName($this->db);
		}

		public function loadLib($libFile)
		{
			if (! is_file(APP_DIR . '/libs/' . $libFile . '.php'))
				die("Library $libFile is not found !");

			require_once(APP_DIR . '/libs/' . $libFile . '.php');

			$libName = ucfirst($libFile) . "Lib";
			if (! class_exists($libName))
				die("Class $libName is not found !");

			$this->$libName = new $libName();
		}

		public function loadView($fileName, $data = array(), $return_string = false)
		{
			require_once(CORE_DIR . '/rain.tpl.class.php');

			raintpl::configure("base_url", null );
	        raintpl::configure("tpl_dir", APP_DIR . "/views/" );
	        raintpl::configure("cache_dir", APP_DIR . "/cache/" );

	        $tpl = new RainTPL;

	        foreach ($data as $key => $val)
	        {
	            $tpl->assign($key, $val);
	        }
	        $tpl->assign("baseURL", baseURL());

	        if ($return_string)
	        {
	            $html = $tpl->draw( $fileName, true );
	            return $html;
	        }
	        else
	        {
	            $tpl->draw( $fileName, false );
	        }
		}

		public function input($name)
		{
			$data = isset($_POST[$name]) ? $_POST[$name] : null;
			return $data;
		}

		public function setUserdata($name, $value)
		{
			$_SESSION[$name] = $value;
		}

		public function getUserdata($name)
		{
			return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
		}

		public function removeUserdata($name = null)
		{
			if ($name == null)
			{
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
			}
			else
			{
				unset($_SESSION[$name]);
			}
		}
	}
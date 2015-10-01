<?php

	function stripSlashesDeep($value) {
		$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
		return $value;
	}

	function removeMagicQuotes() {
	if ( get_magic_quotes_gpc() ) {
		$_GET    = stripSlashesDeep($_GET   );
		$_POST   = stripSlashesDeep($_POST  );
		$_COOKIE = stripSlashesDeep($_COOKIE);
	}
	}

	/** Check register globals and remove them **/

	function unregisterGlobals() {
	    if (ini_get('register_globals')) {
	        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
	        foreach ($array as $value) {
	            foreach ($GLOBALS[$value] as $key => $var) {
	                if ($var === $GLOBALS[$key]) {
	                    unset($GLOBALS[$key]);
	                }
	            }
	        }
	    }
	}

	function antiXSS()
	{
		// Anti XSS
		require_once(CORE_DIR . '/htmlpurifier/library/HTMLPurifier.auto.php');
		$purifier = new HTMLPurifier();
		foreach ($_POST as $key => $value) {
			$_POST[$key] = $purifier->purify($value);
		}
	}

	function baseURL()
	{
        $protocol = 'http://';
        $path = $_SERVER['PHP_SELF'];
        $path_parts = pathinfo($path);
        $directory = $path_parts['dirname'];
        $directory = ($directory == "/") ? "" : $directory;
        $host = $_SERVER['HTTP_HOST'];
        return $protocol . $host . $directory;
	}

	function dump($var, $die = true)
	{
		echo "<pre>";
		print_r($var);
		echo "</pre>";
		if ($die === true)
			die();
	}

	function filterSQL($value)
	{
		$value = is_array($value) ? array_map('filterSQL', $value) : mysql_real_escape_string($value);
		return $value;
	}

	function setTypeSQL($value)
	{
		if (is_array($value))
			return array_map('setTypeSQL', $value);
		if (is_numeric($value))
			return $value;
		return "'" . $value . "'";
	}

	function isAssocArray($arr)
	{
		return (array_keys($arr) !== range(0, count($arr) - 1));
	}

	function redirect($uri = '', $method = 'location', $http_response_code = 302)
	{
		if ( ! preg_match('#^https?://#i', $uri))
		{
			$uri = baseURL() . "/" . $uri;
		}

		switch($method)
		{
			case 'refresh'	: header("Refresh:0;url=".$uri);
				break;
			default			: header("Location: ".$uri, TRUE, $http_response_code);
				break;
		}
		exit;
	}
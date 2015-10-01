<?php
	////////////////////////////////////////////////////////////
	// kMVC
	// Coded by KhanhND
	// Date : 14/04/2012
	// IDE : Sublime Text 2
	////////////////////////////////////////////////////////////
	
	// Session start
	session_start();

	// Precompile
	define("APP_DIR", "app");
	define("CORE_DIR", "core");

	// Include config
	require_once(APP_DIR . "/config/config.php");
	require_once(CORE_DIR . "/preload.php");

	// Preload functions
	removeMagicQuotes();
	unregisterGlobals();
	antiXSS();

	// URL
	$url = isset($_GET['url']) ? trim($_GET['url']) : "";
	$url = rtrim($url, "/");

	// Bootstrap
	require_once(CORE_DIR . "/bootstrap.php");
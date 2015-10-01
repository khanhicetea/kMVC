<?php
	// Explode segments
	$url = ($url == "") ? DEFAULT_CONTROLLER : $url;
	$segments = explode("/", $url);

	// Include Controller Base & Model Base
	require_once(CORE_DIR . "/baseController.php");
	require_once(CORE_DIR . "/baseModel.php");

	// Bootstrap
	$controllerFolder = APP_DIR . "/controllers/";
	$controllerIndexed = NULL;
	$pathFile = "";
	for ($i = 0; $i < count($segments); $i++)
	{
		$arrPath = array_slice($segments, 0, $i + 1);
		$pathFile = $controllerFolder . implode("/", $arrPath) . ".php";

		if (is_file($pathFile))
		{
			$controllerIndexed = $i;
			break;
		}
	}

	if ($controllerIndexed === NULL)
		die("Main controller is not found !");

	require_once($pathFile);

	// Construct main controller
	$controllerName = ucfirst($segments[$controllerIndexed]) . "Controller";

		// Check class exists
	if (! class_exists($controllerName))
		die("Class $controllerName is not found !");

	$mainController = new $controllerName($segments);
	
	// Call the action
	$actionIndexed = $controllerIndexed + 1;
	$actionName = isset($segments[$actionIndexed]) ? $segments[$actionIndexed] : "index";

		// Check method exists
	if (! method_exists($mainController, $actionName))
		die("Function $actionName in $controllerName is not found !");

	call_user_func_array(array($mainController, $actionName), array_slice($segments, $actionIndexed + 1));
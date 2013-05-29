<?php

	/**
	** The main public entry point to the system. This file manages dependecies, loads essential modules etc...
	** @author Hassan Qulqass 
	**/
	
	//Set time zone (PHP usually throws an error)
	date_default_timezone_set('Europe/London');

	//Setup main system configurations
	define('SYSTEM_ROOT' , '/Users/pseudoh/Dev/web/aston/cs2410/www'); //Path to the website on disk
	define('SYSTEM_PATH' , SYSTEM_ROOT.'/system'); //Path to the system's directory
	define('APP_PATH' , SYSTEM_ROOT.'/application'); //Path to the application's directory
	define('MODELS_PATH' , APP_PATH.'/models'); //Path to the application model's directory
	define('CONTROLLERS_PATH', APP_PATH.'/controllers'); //Path to the application controller's directory
	define('VIEWS_PATH', APP_PATH.'/views'); //Path to the application views' directory
	define('LIBRARIES_PATH', APP_PATH.'/libraries'); //Path to the application's libraries directory

	//Load base components
	require_once(SYSTEM_PATH.'/router.php'); //Automates Controller invocation
	require_once(SYSTEM_PATH.'/controller.php'); //The base controller
	require_once(SYSTEM_PATH.'/model.php'); //The base model
	require_once(SYSTEM_PATH.'/view.php'); // Provides functionality to simplify loading views
	require_once(SYSTEM_PATH.'/database.php'); // A database wrapper
	require_once(SYSTEM_PATH.'/helpers.php'); // A set of helper functions and wrappers

	//Load the application's main configurations file
	require_once(APP_PATH.'/config.php'); // A set of helper functions and wrappers

	//Start sessions if enabled
	if (ENABLE_SESSIONS) 
		session_start();

	//Load auto-load libraries
	$auto_libraries = unserialize(AUTOLOAD_LIBRARIES);
	foreach ($auto_libraries as $library) {
		include_library($library);
	}

	//Initialise Router
	Router::route();


?>
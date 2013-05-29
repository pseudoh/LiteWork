<?php

/**
** Defines the global configuration values used across the application
**
** @author Hassan Qulqass - pseudoh.com
**/

	/*
	** Application Configurations  
	*/
	define('APP_URL' , 'http://192.168.0.5:8888/aston/cs2410/www'); //The URL to the application
	define('RESOURCES_URL', APP_URL.'/resources'); //The URL to resources
	define('RESOURCES_PATH', SYSTEM_ROOT.'/resources'); //The system path to resources
	define('INDEX_PAGE' , ''); //The request handler page. Leave blank if using mod_rewrite in .htaccess

	/*
	** Sessions
	*/
	define('ENABLE_SESSIONS', TRUE); //set to TRUE to enable sessions

	/*
	** Database Configurations
	*/
	define('DB_HOST', 'localhost');
	define('DB_PORT', 3306);
	define('DB_USER', 'root');
	define('DB_PASS', 'root');
	define('DB_DATABASE', 'astonclubnews');
	define('DB_AUTOLOAD', TRUE); //Set to TRUE to automatically load the database library

	/*
	** Routing
	** Defines any rerouting of requests
	** e.g reroute mylongpagerequest to shortrequest
	*/
	$routes = array(
		'' => 'home', //Default controllers
		'login' => 'auth/login',
		'logout' => 'auth/logout',
		'register' => 'auth/register',
		'resetpass' => 'auth/resetpass',
		'myastonnews/events.json' => 'myastonnews/get_events_json',
		'404' => 'errors/error_404' //routes 404 error to a view
	);

	define('ROUTES', serialize($routes)); //Serialise the routes array and define as constant

	/*
	** Auto-loading
	** Defines libraries that are required to be autloaded per request
	** prevent the need to include common libraries across all pages
	*/
	$autoload_libraries = array(
		'authentication',
	);
	define('AUTOLOAD_LIBRARIES', serialize($autoload_libraries));


	/*
	** Uploader
	** Defines the settings of the file upload library
	*/
	define('UPLOAD_PATH', RESOURCES_PATH.'/upload'); //The system path to the uploads directory
	define('UPLOAD_MAX_SIZE', 2000); //The maximum size upload limit

	/*
	** Views
	** Defines the setting of the View library
	*/
	define('VIEW_MASTER', 'master'); //The name of the master template view
	define('CSS_URL', RESOURCES_URL.'/css'); //The URL to the css directory
	define('JS_URL', RESOURCES_URL.'/js'); //The URL to the javascript directory
	define('IMAGES_URL', RESOURCES_URL.'/images'); //The URL to the images directory
?>
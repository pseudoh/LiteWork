<?php

/**
** Defines the global configuration values used across the application
**
** @author Hassan Qulqass - pseudoh.com
**/

	/*
	** Application Configurations  
	*/
	define('APP_URL' , ''); //The URL to the application
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
	define('DB_USER', '');
	define('DB_PASS', '');
	define('DB_DATABASE', '');
	define('DB_AUTOLOAD', TRUE); //Set to TRUE to automatically load the database library

	/*
	** Routing
	** Defines any rerouting of requests
	** e.g reroute mylongpagerequest to shortrequest
	*/
	$routes = array(
		'' => 'home', //Default controllers
	);

	define('ROUTES', serialize($routes)); //Serialise the routes array and define as constant

	/*
	** Auto-loading
	** Defines libraries that are required to be autloaded per request
	** prevent the need to include common libraries across all pages
	*/
	$autoload_libraries = array(
		
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
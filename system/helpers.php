<?php

/**
** Helper functions used across the system
**
** @author Hassan Qulqass - pseudoh.com
**/	

/**
** Loads a model class
** @param model - The name of the model to load
**/
function include_model($model) {
	include_once(MODELS_PATH.'/'.$model.'.php');
}

/**
** Loads a library class
** @param library - The name of the library to load
**/
function include_library($library) {
	include_once(LIBRARIES_PATH.'/'.$library.'.php');
}

/**
** Redirects the request to a specific URL. 
** If set to local redirection (see remote param), the methods automaticaly includes the 
** application's url. All that is needed is the name of the controller/page
** @param to - The page/url to redirect to
** @param remote - Specifies whether the page to redirect to is outside the applications' url
**/
function redirect($to, $remote = false) {
	if ($remote) { //Remote Redirect
			header("Location: $to");
	} else { //Local redirect
		if (INDEX_PAGE != null) {  //index page is set
			header('Location: '.APP_URL.'/'.INDEX_PAGE.'?'.$to);
		} else { //index page not set. Usually due to mod_rewrite beign enabled
				header('Location: '.APP_URL.'/'.$to);
		}
	}
}

/**
** Returns the value of a request param POST or GET
** @param name - The name of the request field
** @return String - The value of the request field
**/ 
function get_request($name) {
	if (isset($_REQUEST[$name])) {
		return $_REQUEST[$name];
	} else {
		return '';
	}
}

?>
<?php

/**
** Authentication controller. For login and logout
**
** @author Hassan Qulqass - pseudoh.com
**/

include_library('form_validator');

class Auth extends Controller {

	/** Constructor. Always executed **/
	public function __construct() {
		View::load('index');
	}


}

?>
<?php

/**
** Routes a URI request to appropriate controller and calls appropriate methods while passing parameteres. 
** The class parses the query string of the URL, parse the controllers name, method, and parameters to call
** and then loads the controller and call the method with approriate parameters.
**
** @author Hassan Qulqass - pseudoh.com
**/

class Router {

	/**
	** Called by the systems index file to route the current request
	**/
	public static function route() {
		$query = $_SERVER['QUERY_STRING']; //Get request query
		Router::go($query); //Parse and go to request
	}

	/**
	** Parses a request and loads the appropriate controller
	** @param page - The page/query to parse and navigate to
	**
	**/
	public static function go($page) {

		//Check for a defined route. 
		//If a match is found then navigate to the new page
		$page = Router::reroute($page);

		//Parse the request and split by the slash
		// e.g http://example.com/event/delete/1
		// would be parsed to 
		// controller: event
		// method in controller: delete
		// parameter to pass to method: 1
		$request = explode('/', $page); 
		$controller = array_shift($request); //get the controllers name
		$controller_params = array_values($request); //Get the method name and parameters

		//Load the controller and pass params
		Router::load_controller($controller, $controller_params);
	}

	/**
	** Reroutes a request if a routing is pre-defined
	** @param route - the page to reroute
	** @return new route
	**/
	private static function reroute($route) {
		$routes = unserialize(ROUTES); 

		//check whether there is a rerouting
		if (isset($routes[$route])) {
			return $routes[$route]; //return new route
		} else {
			return $route; //keep same route
		}
	}

	/**
	** Check whether a routing rule is defined in the config file
	** @param route - the page to reroute
	** @return Boolean
	**/
	private static function route_exists($route) {
		$routes = unserialize(ROUTES); //convert the ROUTES constant back to array
		return isset($routes[$route]);
	}

	/**
	** Returns the current page (controller) requested
	** @return String - current controller's name
	**/
	public static function get_page() {
		$query = $_SERVER['QUERY_STRING'];

		$request = explode('/', $query);
		$controller = array_shift($request);
		
		return $controller;
	}

	/**
	** Handles errors in rerouting. Either reroutes to view if routing defined
	** or display a friendly error
	**/
	private static function error($error) {
		//Check if a route exist for the error

		if (Router::route_exists($error)) {
			Router::go($error);
		} else { 
			//if no route defined dislay error
			echo '<h1>'.$error.'</h1>';
		}
		
	}

	/**
	** Loads the requested controller, call the request method and pass params
	** @param controller - The name of the controller
	** @param params - contains method name and any params
	**/
	private static function load_controller($controller, $params) {

		//Construct the path to the controller
		$controller_path = CONTROLLERS_PATH.'/'.$controller.'.php';

		//Escape string of each param - sql injection prevention
		$params = array_map('mysql_real_escape_string', $params);

		if (file_exists($controller_path)) {
			//Load controller's file
			include_once($controller_path);

			//the controller's class name
			$controller_class = ucfirst(trim($controller));

			//Check if controller's class name exist in the loaded file
			if (class_exists($controller_class)) {

				//Create a new instance of the controller
				$controller_object = new $controller;

				//Extract method to call in the controller's object
				$method = trim(array_shift($params));

				//if mehtod no specified pre-set to "index"
				if ($method == '') {
					$method = 'index';
				}

				//check if method to call exists
				if (method_exists($controller_object, $method)) {
					//Call the method and pass any parameters available
					call_user_func_array(array($controller_object, $method), $params);
					return;
				} 

			} 
 		} 

 		//Throw 404 error if request not found/fulfilled
 		Router::error('404');
	}

}


?>
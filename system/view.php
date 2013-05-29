<?php

/**
** Facilitates loading of views/pages and provides a basic templating system.
** The templating system is based on a master page that defines the common html elements and 
** defines sections that are populated by sub-pages.
** This is accompliahsed by output buffering.
**
** @author Hassan Qulqass - pseudoh.com
**/

class View {

	/** The data to pass to the view  (variables) **/
	private static $data = array();
	/** The current open/buffering section's name **/
	private static $open_section = '';

	/**
	** Starts a section buffer in a sub-page.
	** All data within the call of this and the call of the end_section method 
	** will be buffered and stored by the sections' name which will be accessed by the master page
	**@param section_name - The name of the section to store the buffer in
	**/	
	public static function start_section($section_name) {
		ob_start(); //Start an output buffer
		View::$open_section = $section_name; //Store the section's name
	}

	/**
	** Ends a section's buffer that has been started by start_section
	**/ 
	public static function end_section() { 
		//Check if there is a section waiting to be closed
		if (!empty(View::$open_section)) {
			View::$data[View::$open_section] = ob_get_clean(); //Close buffer, return and store content in data array
			View::$open_section = ''; //Reset open section
		}
	}

	/**
	** Load the content of a specific section. Usually called by a master page
	** It ouputs the contents stored in a section buffer by the methods (start_section and end_section)
	** @param section - The name of the section
	**/ 
	public static function load_section($section) {
		if (isset(View::$data[$section])) //if section exist
			echo View::$data[$section]; //Echo the section's content
	}

	/**
	** Checks whether a specfic section is defined
	** @param section - The name of the section
	** @return Boolean
	**/
	public static function is_section_defined($section) {
		return isset(View::$data[$section]);
	}

	/**
	** Loads the master template and a specific view and output to page
	** @param view - The name of the view to load
	** @param data - An array of data to pass to the master page and view. e.g ['my_variable' => $my_variable]
	**/
 	public static function load($view, $data = array()) {
		//Check if the master view is defined
		if (defined('VIEW_MASTER')) {
			$template = VIEW_MASTER; //Get the master view defined in the config file
			echo View::load_content($view, $data); //Load the sub-view
			echo View::load_content($template, $data); //Load the master view
		} 

	}

	/**
	** Load the content of a view file
	** @param view - The name of the view to load
	** @param data - An array of data to pass to the master page and view. e.g ['my_variable' => $my_variable]
	**/
	private static function load_content($view, $data) {
		//Construct the path to the view
		$view_path = VIEWS_PATH.'/'.$view.'.tpl';
		ob_start(); //Start buffer
		if (file_exists($view_path)) { //if view file exists
			extract($data); //convert data to variables
			include($view_path); //load view's data
		}
		return ob_get_clean(); //Output buffer
	}

}

?>
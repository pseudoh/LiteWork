<?php

/**
** Provides authentication capabilities.
** @author Hassan Qulqass - pseudoh.com
**/

include_model('user');

class Authentication {

	/** Used to cache user object during requests **/
	private static $user = NULL;

	/**
	** Autenticates a user
	** @param username - The username of the user (Email in this case)
	** @param password - The password of the account
	** @return Boolean - True if authentication was successful, False otherwise
	**/
	public static function login($username, $password) {

		//Get the user details by email
		$user = User::get_by_email($username);

		if ($user) { //If user exists

			//Check if passwords match
			if ($password == $user->password) {
				Authentication::$user = $user; //Store the user object for later access
				$_SESSION['user'] = $user->user_id; //Create the session and store the users id
				return TRUE;
 			} else {
 				throw new Exception('Incorrect Password', 102); //Password is incorrect, throw error
 			}
		} else {
			throw new Exception('Username not found', 101); //User not found, throw error
		}

		return FALSE;
	}

	/**
	** Returns the User object of the current logged in user
	** @return User object
	**/
	public static function get_user() {
		//Check if user is logged in first
		if (Authentication::is_logged_in()) {
			//If the user variable doesn;t contain a user object in other words
			//if the user hasn't already been loaded from the database in the current execution
			//load it otherwise use the object in the user variable
			if (Authentication::$user == NULL)
				Authentication::$user = User::get_by_id($_SESSION['user']);
			return Authentication::$user;
		} else {
			return NULL;
		}
	}

	/**
	** Check whether there is a logged in user
	** @return Boolean
	**/
	public static function is_logged_in() {
		return isset($_SESSION['user']);
	}

	/**
	** Logs out the current logged in user
	**/
	public static function logout() {
		unset($_SESSION['user']);
		session_destroy();
	}

}

?>
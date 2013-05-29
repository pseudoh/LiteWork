<?php

/**
** A Singleton Database wrapper that provides a common and easy wrapper to the database engine being used.
** Curretly implemented to use PDO
**
** @author Hassan Qulqass - pseudoh.com
**/

class Database {

	/** The connection handle to the database **/
	private $db_handle = null;

	/** Stores the singleton instance **/
	private static $instance = null;

	/**
	** Returns the database instance/connection
	** @return Database instance
	**/
	public static function get_connection() {
        if (static::$instance === null) {
            static::$instance = new Database;
        }
        return static::$instance->db_handle;
	}

	/** 
	** Class constructor
	**/
	private function __construct() {
		//If database is set to autload in config file
		//connect once the class is constructor
		if (DB_AUTOLOAD) 
			$this->connect();
	}

	/**
	** Connects to the database
	** @param db - The name of the database to connect to - Default is read from config file
	**/
	public function connect($db = DB_DATABASE) {
		$host = DB_HOST;
		$db = DB_DATABASE;
		try {
			$this->db_handle = new PDO("mysql:host=$host;dbname=$db", DB_USER, DB_PASS);
			$this->db_handle->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); 
			$this->db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
		    echo 'ERROR: ' . $e->getMessage();
		}
	}

}
?>
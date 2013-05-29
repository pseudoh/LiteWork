<?php

/**
** The base Model class that provides all common grounds to all models in the application.
**
** @author Hassan Qulqass - pseudoh.com
**/

class Model {

	/**
	** Executes a mysql query
	** @param query - The query string to execute
	** @param fetch - Indicates whether the query is a fetch query (SELECT) or not (UPDATE, INSERT, DELETE) 
	** to help determine the return value
	** @return Query result/Insert id
	**/
	protected static function do_query($query, $fetch = TRUE) {
			$db = Database::get_connection();

			$query = $db->prepare($query);
			
			$query->setFetchMode(PDO::FETCH_CLASS, get_called_class());

			if ($query->execute() && $query->rowCount() > 0) {
					if ($db->lastInsertId() == 0 && $fetch) {
						return $query->fetchAll();
					}
					else {
						return $db->lastInsertId();
					}
			} else {
				return NULL;
			}

	}
}

?>
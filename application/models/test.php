<?php

/**
** Models the clubs table in the database and provides CRUD and helper functions.
** @author Hassan Qulqass - pseudoh.com
**/

include_model('event'); //Include the event model

class Club extends Model {

	/**
	** The name of the clubs' table in the database
	**/
	protected static $table = "clubs";

	/**
	** Creates a new club
	** @param name - The name of the club
	** @param description - The description of the club
	** @param user_id - The id of the user that is the owner of the id
	** @return Result - Club's id
	**/
	public static function create($name, $description, $user_id) {
		$query = Club::do_query("INSERT INTO ".Club::$table." (name, description, user_id) VALUES ('$name', '$description', $user_id);");
		return $query;
	}

	/**
	** Deletes a club by id
	** @param id - The id of the club
	** @return query result
	**/
	public static function delete($id) {
		$query = Club::do_query("DELETE FROM ".Club::$table." WHERE club_id=$id;", FALSE);
		return $query;
	}

	/**
	** Updates a club's details
	** @param name - The name of the club
	** @param description - The description of the club
	** @param user_id - The id of the user that is the owner of the id
	** @return query result
	**/
	public static function update($club_id, $name, $description) {
		$query = Club::do_query("UPDATE ".Club::$table." SET name='$name', description='$description' WHERE club_id=$club_id;", FALSE);
		return $query;
	}

	/**
	** Retrieves a club by id
	** @param id - The id of the club
	** @return Club object containing the fields and values and helper functions
	**/
	public static function get_by_id($id) {
		$query = Club::do_query("SELECT * FROM ".Club::$table." WHERE club_id='$id';");
		return ($query != NULL) ? $query[0] : $query;
	}

	/**
	** Retrieves all clubs in the database
	** @return An array of club objects containing the fields and values and helper functions
	**/
	public static function get_all() {
		$query = Club::do_query('SELECT * FROM '.Club::$table.' ORDER BY name;');
		return $query;
	}

	/**
	** Retrieves all clubs owned by a specific user
	** @param user_id - The id of the user
	** @return An array of club objects containing the fields and values and helper functions
	**/
	public static function get_owned_by($user_id) {
		$query = Club::do_query('SELECT * FROM '.Club::$table." WHERE user_id='$user_id' ORDER BY name;");
		return $query;
	}

	/**
	** Retrieves a list of clubs matching a search query applied to the club's name
	** @param query - Search query
	** @return An array of club objects containing the fields and values and helper functions
	**/
	public static function search($query) {
		$query = Club::do_query('SELECT * FROM '.Club::$table." WHERE name LIKE '%$query' ORDER BY name;");
		return $query;
	}

	/**
	** Retrieves a list of the most popular clubs based on number of subscriptions
	** @param limit - The maximum number of clubs to retrieve - Default is 3
	** @return An array of club objects containing the fields and values and helper functions
	**/
	public static function get_most_popular($limit = 3) {
		$query = Club::do_query("SELECT subscriptions.*, count(subscriptions.club_id), clubs.* FROM subscriptions INNER JOIN clubs ON subscriptions.club_id = clubs.club_id GROUP BY subscriptions.club_id ORDER BY count(subscriptions.club_id) LIMIT 0, $limit;");
		return $query;
	}

	/**
	** Retrieves a list of upcoming events belonging to the current Club object
	** @return An array of Event
	**/
	public function get_upcoming_events() {
		$query = Event::get_club_upcoming_events($this->club_id);
		return $query;
	}

	/**
	** Retrieves a list of events that have expired belonging to the current Club object
	** @return An array of Event
	**/
	public function get_previous_events() {
		$query = Event::get_club_previous_events($this->club_id);
		return $query;
	}
	
}

?>
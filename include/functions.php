<?php
// require_once("db_connect.php");

//TODO: declare global connection

/**
 * establishes connection with db
 */
function connect() {
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBNAME);
	if(mysqli_connect_errno()) {
		die("Database connection failed. <br/>" . mysqli_connect_error($conn) . 
			"(" . mysqli_connect_errno() . ") <br/>");
	}
	
	return $connection;
}

function validate_name($name) {
	// name cannot have number of characters
	if(preg_match('/[A-Za-z ]/', $name)) {
		return True;
	} else {
		return False;
	}
}

//TODO: return a User object?
function validate_registration() {
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$email = $_POST["email"];
	$password = $_POST["password"];

	// first and last name should not have special characters
	// if(!empty($first_name)) {
	// 	return False;
	// }

	// email is in the form of *@*

	/* available pw characters are the combination of alpha-numerical chars and 
		[`~!@#$%^&*()-_=+;:'",<.>/?] */

	// month day and year has to be selected
	if(isset($_POST["month"]) && $_POST["month"] != "month"
	&& isset($_POST["day"]) && $_POST["day"] != "day"
	&& isset($_POST["year"]) && $_POST["year"] != "year"
	// Gender field is required
	&& isset($_POST["gender"])
	
	) {
		return True;
	} else {
		return False;
	}
}

function save_user_to_db($user, $connection) {
	$query = "";
	$query .= "INSERT INTO user (";
	// fields of user class
	$query .= "first_name, last_name, email, password, ";
	$query .= "birth_month, birth_day, birth_year, gender";
	$query .= ") VALUES (";

	$query .= ( 
				"'" . $user->get_first_name() 	. "'," .
				"'" . $user->get_last_name() 	. "'," .
				"'" . $user->get_email() 		. "'," .
				"'" . $user->get_password() 	. "'," .
				"'" . $user->get_birth_month()	. "'," .
				"'" . $user->get_birth_day() 	. "'," .
				"'" . $user->get_birth_year()	. "'," .
				"'" . $user->get_gender() . "'" );
	$query .= ");";
	
	// echo $query;
	return mysqli_query($connection, $query);

	// echo "<p>Error in inserting new user into db</p>";

}

//TODO: function that adds friend to record
//TODO: function that removes friend from record

?>

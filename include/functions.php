<!-- author: Jia Sheng Ma -->
<?php
// require_once("db_connect.php");
require_once("../src/constants.php");
require("../src/user.php");
//TODO: declare global connection

/**
 * establishes connection with db
 */
function connect() {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

    if(mysqli_connect_errno()) {
    	die("Database connection failed. <br />" .
    		mysqli_connect_error($connection) . " (" . 
    		mysqli_connect_errno() . ") <br />");
    }

    // debug
    echo "[DEBUG] Connection: " . mysqli_get_host_info($connection) . "<br/>";
	
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
	$query .= "INSERT INTO USERS_TABLE (";
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

	return mysqli_query($connection, $query);

}

/**
 * Retrieves user info from database whose email is $user_email
 */
function loadUser($user_email, $password, $connection) {
    $query = "SELECT * FROM " . USERS_TABLE .
    			" WHERE email='".
    			mysqli_real_escape_string($connection, $user_email) .
    			"' AND password='" .
    			mysqli_real_escape_string($connection, $password) 
    			."';";
    echo "$query";
    $result = mysqli_query($connection, $query);
    if(!($user_data = mysqli_fetch_assoc($result))) {
        return NULL;
    } else {
        $user = new User;
        $user->set_first_name($user_data['first_name']);
        $user->set_last_name($user_data['last_name']);
        $user->set_email($user_data['email']);
        $user->set_password($user_data['password']);
        $user->set_birth_month($user_data['birth_month']);
        $user->set_birth_day($user_data['birth_day']);
        $user->set_birth_year($user_data['birth_year']);
        $user->set_gender($user_data['gender']);
        return $user;
    }

}
//TODO: function that adds friend to record
//TODO: function that removes friend from record

?>

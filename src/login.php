<?php 
// require_once("db_connect.php");

$user_email = $_POST["email"];
$password = $_POST["password"];
echo "[DEBUG]$user_email" . " " . $password . "<br>";

// try to access this user's info from db, if success, redirect to main page
// if failure, redirect back to index
$query = "SELECT * FROM user ".
			" WHERE email='".
			mysqli_real_escape_string($connection, $user_email) .
			"' AND password='" .
			mysqli_real_escape_string($connection, $password) 
			."';";
echo "[DEBUG] QUERY: $query";
$result = mysqli_query($connection, $query);

if(!($user_data = mysqli_fetch_assoc($result))) {
	echo "email and password did not match <br/>";
	// rediect back to login page
	// redirect to main.php
    // header("Location: index.php");
} else {
	// redirect to main.php
    // TODO: use user data to populate main.php
    echo '[DEBUG] Redirecting to '.$user_email;
    // header("Location: main.php");
}
?>

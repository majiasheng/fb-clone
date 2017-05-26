<?php 
require_once("../include/functions.php");

$user_email = $_POST["email"];
$password = $_POST["password"];

$connection = connect();
echo "[DEBUG] user: $user_email" . " pw:" . $password . "<br>";
echo "[DEBUG] Connection: " . mysqli_get_host_info($connection) . "<br/>";

// try to access this user's info from db, if success, redirect to main page
// if failure, redirect back to index
$query = "SELECT * FROM users ".
			" WHERE email='".
			mysqli_real_escape_string($connection, $user_email) .
			"' AND password='" .
			mysqli_real_escape_string($connection, $password) 
			."';";
// echo "[DEBUG] QUERY: $query";
$result = mysqli_query($connection, $query);

if(!($user_data = mysqli_fetch_assoc($result))) {
	echo "email and password did not match <br/>";
	// rediect back to login page
	// redirect to main.php
    header("Location: index.php");
} else {
	// redirect to main.php
    // TODO: use user data to populate main.php
    // echo '[DEBUG] Redirecting to '.$user_email;
    header("Location: main.php");
}
?>

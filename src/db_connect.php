<?php
	// include "constants.php";
define("DB_SERVER",	"127.0.0.1");
define("DB_USER", 	"majiasheng");
define("DB_PASSWORD", "Notfound404");
define("DB_NAME",		"fb");
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

if(mysqli_connect_errno()) {
	die("Database connection failed. <br />" .
		mysqli_connect_error($connection) . " (" . 
		mysqli_connect_errno() . ") <br />");
}

echo "connection: " . mysqli_get_host_info($connection) . "<br/>";
	
?>

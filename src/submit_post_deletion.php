<?php
require_once("../include/functions.php");
session_start();
$user = $_SESSION['user'];
$pdo = connect();

if(isset($_POST)) {
	if(!delPostFromDB($user->get_email(), $pdo, $_POST['post__id'])){
	    echo "Error occurred while deleting <br>";
	} else {
		echo "Succeed";
	}
	unset($_POST);
}


?>

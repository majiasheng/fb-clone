<?php
require_once("../include/functions.php");
session_start();
$user = $_SESSION['user'];
$pdo = connect();

if(isset($_POST)) {
	// if(!updatePostContent($_POST['post__id'], $_POST['new_content'], $pdo)){
	if(!updatePostContent($_POST['new_content'], $_POST['post__id'], $pdo)){
	    echo "uh oh, something went wrong when updating <br>";
	} else {
		echo "Succeed";
	}
	unset($_POST);
}

?>

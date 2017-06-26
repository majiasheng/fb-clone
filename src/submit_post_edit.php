<?php
require_once("../include/functions.php");
session_start();
$user = $_SESSION['user'];
$pdo = connect();

if(isset($_POST['new_content'])) {
	// echo $_POST['new_content'] ." | ". $_POST['post__id'];
	// if(!updatePostContent("dididididid", $_POST['post__id'], $pdo)){
	if(!updatePostContent($_POST['new_content'], $_POST['post__id'], $pdo)){
	    echo "uh oh, something went wrong when updating <br>";
	} else {
		echo "Succeed";
	}
	unset($_POST);
}

?>

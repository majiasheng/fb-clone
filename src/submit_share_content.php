<?php

require_once("../include/functions.php");
require_once("../include/loads/load_images.php");

session_start();

$user = $_SESSION['user'];
$info = $_SESSION['user_info'];
$pdo = connect();

// Check if this post belongs to current user.

if(isset($_POST) && isset($_POST['post_id'])) {

	$result = checkBelongToUser((int)$_POST['post_id'], $user->get_email() ,$pdo);

	// This post belongs to a friend.
	if (is_null($result['content'])) {
		//get the post_content
		$content = getShareContent((int)$_POST['post_id'], $pdo);

		// save the post content to the user's timeline
		$save_result = savePostToDB($user->get_email(), $pdo, $content['content']);
		
	}
    unset($_POST);
}

?>

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
		$assoc_arr= getShareContent((int)$_POST['post_id'], $pdo);
		$content = $assoc_arr['content'];
		$author_email = $assoc_arr['author_email'];

		// save the post content to the user's timeline
		$save_result = savePostToDB($author_email, $user->get_email(), $pdo, $content);

		// first we have to get the post_id;
		$latest_post = get_latest_share_post($user->get_email(), $author_email, $pdo)[0];

		$latest_post_id = $latest_post['id'];

		// load all of the comments based on the save result.
		$comments = load_comments((int)$_POST['post_id'], $pdo);

		// Now save the comments into the DB based on the latest_post_id.
		foreach($comments as $c){
			saveCommentToDB($c->getAuthor(), $latest_post_id, $pdo, $c->getCommentContent());
		}

	}

    unset($_POST);

}

?>

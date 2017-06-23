<?php
require_once("../include/functions.php");
session_start();

$user = $_SESSION['user'];
$info = $_SESSION['user_info'];
$pdo = connect();

$email = $user->get_email();

if(isset($_POST) && ("" != trim($_POST['post_id']))) {
	// return if the user liked this post or not.
	$checkNull = checkNullLikeState((int)$_POST['post_id'], $user->get_email(), $pdo);

	if(is_null($checkNull['id'])){
		// echo "LIKE";
		likePost((int)$_POST['post_id'], $user->get_email(), $pdo);
	}
	else
	{
		// echo "UNLIKE";
		unlikePost((int)$_POST['post_id'], $email, $pdo);
	}

	$like_count = getLikeCount((int)$_POST['post_id'], $pdo)["count(liked)"];

	unset($_POST);
}

?>

<i class="fa fa-thumbs-up"><?php echo $like_count ?></i>


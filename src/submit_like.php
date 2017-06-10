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

	// var_dump($checkNull);
	if(is_null($checkNull['id'])){
		linkPost((int)$_POST['post_id'], $user->get_email(), $pdo);
	}

	$val = checkLikeStat((int)$_POST['post_id'], $email, $pdo);

	// if user hasn't liked this post.
	if($val['liked'] == 0){
		$state = 1;
		updateLikeStat((int)$_POST['post_id'], $email, $state, $pdo);
		incLikesDB((int)$_POST['post_id'], $pdo);

	}else{
		// user liked the post.
		$state = 0;
		updateLikeStat((int)$_POST['post_id'], $email, $state, $pdo);
		decLikesDB((int)$_POST['post_id'], $pdo);
	}

	$post = load_one_post((int)($_POST['post_id']) , $pdo);
	$like_count = $post[0]["like_count"];

	// var_dump($val);
	unset($_POST);
}


?>

<i class="fa fa-thumbs-up"><?php echo $like_count ?></i>


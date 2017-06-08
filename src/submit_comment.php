<?php
require_once("../include/functions.php");
session_start();

$user = $_SESSION['user'];
$info = $_SESSION['user_info'];
$pdo = connect();

// if(isset($_POST) && isset($_POST['post_comment_content']) && ("" != trim($_POST['post_comment_content']))) {
//     //FIXME: $user->get_email() <= not really, $user can be anyone
//     if(!saveCommentToDB($user->get_email(), $_POST['post__id'], $pdo, $_POST['post_comment_content'])){
//         echo "Error occurred while commenting <br>";
//     }
//     // unset($_POST);

// }

// $posts = loadPosts($user->get_email(), $pdo);
?>
<div class="comment__content__p"> <?php var_dump($_POST) ?></div>

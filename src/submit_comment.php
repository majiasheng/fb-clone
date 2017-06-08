<?php
require_once("../include/functions.php");
session_start();

$user = $_SESSION['user'];
$info = $_SESSION['user_info'];
$pdo = connect();

if(isset($_POST) && isset($_POST['post_comment_content'])) {
    //FIXME: $user->get_email() <= not really, $user can be anyone

    if(("" != trim($_POST['post_comment_content']))){
    	if(!saveCommentToDB($user->get_email(), $_POST['post__id'], $pdo, $_POST['post_comment_content'])){
        	echo "Error occurred while commenting <br>";
    	}

    }  

    $comments = load_comments($_POST['post__id'], $pdo);
    unset($_POST);

}

foreach ($comments as $c):

?>
<div class="comment__content__p"><?php echo $c->getCommentContent() ?></div>

<?php endforeach ?>

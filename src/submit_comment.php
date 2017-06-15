<?php
require_once("../include/functions.php");
require_once("../include/loads/load_images.php");

session_start();

$user = $_SESSION['user'];
$info = $_SESSION['user_info'];
$pdo = connect();
$comments = null;
if(isset($_POST) && isset($_POST['post_comment_content'])) {

    if(("" != trim($_POST['post_comment_content']))){
    	if(!saveCommentToDB($user->get_email(), $_POST['post__id'], $pdo, $_POST['post_comment_content'])){
        	echo "Error occurred while commenting <br>";
    	}

    }  

    $comments = load_comments($_POST['post__id'], $pdo);
    $post = load_one_post((int)$_POST['post__id'], $pdo);

    unset($_POST);
}

if(!is_null($comments)):

foreach ($comments as $c):
$pic = load_profile_email($c->getAuthor());

?>

<div class="comment__details">  
    <img src="<?php echo $pic ?>" class="comment__pic">
    <div class="commenter">
        <p class="comment__header__info info__commentor"><a href="javascript:void(0);"><?php echo getUserNameByEmail($c->getAuthor(), $pdo) ?></a></p>
        <p class="comment__content__p"><?php echo $c->getCommentContent() ?></p>

        <p class="comment__header__info info__comment__date"><?php echo $c->getCommentTime() ?></p>
    </div>
</div>

<?php endforeach ?>

<?php endif ?>

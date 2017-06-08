<?php
require_once("../include/functions.php");
session_start();

$user = $_SESSION['user'];
$info = $_SESSION['user_info'];
$pdo = connect();

if(isset($_POST) && ("" != trim($_POST['post_content']))) {
	if(!savePostToDB($user->get_email(), $pdo, $_POST['post_content'])) {
		echo "Error occurred while saving posting <br>";
	}
	unset($_POST);
}

$posts = loadPosts($user->get_email(), $pdo);


?>

<?php foreach($posts as $p):  

	$comments = load_comments($p->getPostID(), $pdo);


?>

	<!-- <div class="middle__posts"> -->
	<div class="post__header">
		<img src="../rsrc/img/photos/p11.jpeg" class="post__header__author-photo">
		<p class="post__header__info info__author"><a class=""><?php echo $user->get_first_name() . " " . $user->get_last_name() ?></a></p>
		<p class="post__header__info info__date"><?php echo $p->getPostTime() ?></p>
	</div>
	<div class="post__content">
		<p class="post__content__p"><?php echo $p->getContent() ?></p>
	</div>

	<div class="comment__content">
		<p class="comment__content__p"></p>
		<p><?php echo $p->getPostId()?></p>
	</div>


	<div class="post__actions">
		<div class="actions--setting actions--decor"><i class="fa fa-thumbs-up"></i></div>
		<div class="actions--setting actions--decor"><i class="fa fa-share"></i></div>
		<div class="actions--setting actions--decor actions__comment"></div>

		<form action="" method="POST" id="post_comment_form">
			<input type="text" name="post_comment_content" placeholder="Write some comment"/>
			<input type="hidden" name="post__id" value="<?php $p->getPostId(); ?>" />
			<button type="submit">
				<i class="fa fa-comment"></i>
			</button>
		</form>

		<!-- <div class="actions--setting actions--decor actions__comment"><i class="fa fa-comment"></i></div> -->
	</div>
	<br><br>
<?php endforeach; ?>
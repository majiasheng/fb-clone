<?php
require_once("../include/functions.php");
require_once("../include/loads/load_images.php");
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

$profile_pic = load_profile($user);

?>

<?php foreach($posts as $p):  
	$comments = load_comments($p->getPostID(), $pdo);
    $name = getUserNameByEmail($p->getAuthorEmail(), $pdo);

    include "../src/template/post_content.html";
    endforeach;
?>

	
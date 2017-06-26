<?php
require("../include/functions.php");
require_once("../include/loads/load_images.php");
session_start();
$pdo = connect();

if(isset($_POST) && ("" != trim($_POST['post_to_friend']))) {
    if(isFriend($_SESSION['user']->get_email(), $_POST['NPC_email'], $pdo)) {        
        savePostToDB($_SESSION['user']->get_email(), 
            $_POST['NPC_email'], 
            $pdo, 
            $_POST['post_to_friend']
        );

        // redirect to self to prevent resubmission by refreshing
        // $self = $_SERVER['REQUEST_URI'];
        // header("Location: $self");
    } else {
        //TODO: make popup window
        $msg = "Be " . getUserNameByEmail($_POST['NPC_email'], $pdo) . "'s friend first :)";
        echo $msg;
    }
} 

$posts = loadPosts($_POST['NPC_email'], $pdo);

$profile_pic = load_profile($_SESSION['user']);

foreach($posts as $p):  
    $comments = load_comments($p->getPostID(), $pdo);
    $name = getUserNameByEmail($p->getAuthorEmail(), $pdo);

    include "../src/template/post_content.php";
endforeach;

unset($_POST);
?>

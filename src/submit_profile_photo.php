<?php
require_once("../include/functions.php");
session_start();

$user = $_SESSION['user'];
$info = $_SESSION['user_info'];
$pdo = connect();

// save images to local filesystem
if(isset($_FILES['profile_image'])){
    $errors= array();
    // $file_name = $_FILES['profile_image']['name'];
    $file_size = $_FILES['profile_image']['size'];
    $file_tmp = $_FILES['profile_image']['tmp_name'];     // temporarily stored
    $file_type = $_FILES['profile_image']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['profile_image']['name'])));

    $expensions= array("jpeg","jpg","png");

    // TODO: change echo to js alert
    if(in_array($file_ext,$expensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }

    if($file_size > 2097152) {
        $errors[]='File size must be excately 2 MB';
    }

    // save image to rsrc/ folder if no error
    if(empty($errors)==true) {
        // create dir named with user email 
        $path = PATH_TO_USERS.$user->get_email()."/profile";
        // create dir if not exist
        if (!is_dir($path)) {
            // umash to get the actual permission 0777; default umask is 022
            $oldmask = umask(0);
            mkdir($path, 0777, true);
            umask($oldmask);
        }    
        // upload image to the user's folder
        move_uploaded_file($file_tmp, PATH_TO_USERS.$user->get_email()."/profile/profile_img");
    }else{
        print_r($errors);
    }
}
header("Location: main.php");
?>

	
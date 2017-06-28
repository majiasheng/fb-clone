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
        $_SESSION['error'] = "extension not allowed, please choose a JPEG or PNG file.";
    }

    if($file_size > 2097152) {
        $errors[]='File size must be less than 2 MB';
        $_SESSION['error'] = 'File size must be less than 2 MB';
    }

    // save image to rsrc/ folder if no error
    if(empty($errors)==true) {
        // TODO: first image name incorrect
        $image_index = $user->get_num_profile();
        // upload image to the user's folder
        move_uploaded_file($file_tmp, PATH_TO_USERS.$user->get_email()."/profile/profile_img".($image_index+1));

        // save to db
        $image_index++;
        $user->set_num_profile($image_index);
        saveNumProfile($user, $pdo);
    } else {
        print_r($errors);
    }
} else {
    $_SESSION['error'] = "No image being uploaded";
}
header("Location: main.php");
?>

	
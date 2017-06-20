<?php
require_once("../include/functions.php");
session_start();

$user = $_SESSION['user'];
$info = $_SESSION['user_info'];
$pdo = connect();
// save images to local filesystem
if(isset($_FILES['cover_image'])){
    $errors= array();
    // $file_name = $_FILES['cover_image']['name'];
    $file_size = $_FILES['cover_image']['size'];
    $file_tmp = $_FILES['cover_image']['tmp_name'];     // temporarily stored
    $file_type = $_FILES['cover_image']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['cover_image']['name'])));

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
        // $path = PATH_TO_USERS.$user->get_email()."/cover";
        // create dir if not exist

        // upload image to the user's folder
        $image_index = $user->get_num_cover()+1;          // name the file according to index

        move_uploaded_file($file_tmp, PATH_TO_USERS.$user->get_email()."/cover/cover_img".$image_index);

        // set num of cover image
        $image_index++;
        $user->set_num_cover($image_index);
        saveNumCover($user, $pdo);

    } else {
        print_r($errors);
    }
}
header("Location: main.php");
?>

	
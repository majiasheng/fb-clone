<?php
require_once("../include/functions.php");
session_start();

$user = $_SESSION['user'];
$info = $_SESSION['user_info'];
$pdo = connect();

if (isset($_POST) && (isset($_POST["workplace"]) 
|| isset($_POST["education"]) 
|| isset($_POST["current_city"]) 
|| isset($_POST["hometown"]) 
|| isset($_POST["relationship"]) 
|| isset($_POST["description"]))) {
    // the getters are for ajax to output
    if (isset($_POST["workplace"])) {
        $info->set_workplace($_POST["workplace"]);
        echo $info->get_workplace();                   
    }
    else if (isset($_POST["education"])) {
        $info->set_education($_POST["education"]);
        echo $info->get_education();  
    }
    else if (isset($_POST["current_city"])) {
        $info->set_current_city($_POST["current_city"]);
        echo $info->get_current_city();  
    }
    else if (isset($_POST["hometown"])) {
        $info->set_hometown($_POST["hometown"]);
        echo $info->get_hometown();  
    }
    else if (isset($_POST["relationship"])) {
        $info->set_relationship($_POST["relationship"]);
        echo $info->get_relationship();  
    }
    else if (isset($_POST["description"])) {
        $info->set_description($_POST["description"]);
        echo $info->get_description(); 
    }
    save_info_to_db($user->get_email(), $info, $pdo);

}
?>

	
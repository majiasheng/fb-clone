<?php

require_once("../include/functions.php");
require_once("../include/loads/load_images.php");

session_start();

$user = $_SESSION['user'];
$info = $_SESSION['user_info'];
$pdo = connect();

?>
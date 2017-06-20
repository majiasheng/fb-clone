<!-- author: Jia Sheng Ma -->
<?php 
session_start();

require_once("../include/functions.php");

if(!isset($_POST)) {
    /*  if no post request but landed on this page 
        redirect back to index.php
    */
    header("Location: index.php");
}

$user_email = $_POST["email"];
$password = $_POST["password"];

$pdo = connect();
// echo "[DEBUG] user: $user_email" . " pw:" . $password . "<br>";

// try to load user with give email and password
$user = loadUser($user_email, $password, $pdo);
// var_dump($user);

if(is_null($user)) {
    $_SESSION['error'] = "Email and password did not match <br/>";
    // rediect back to login page
    header("Location: index.php");
} else {

    $_SESSION['loggedin'] = True;
    $_SESSION['user_email'] = $user_email;
    $_SESSION['user'] = $user;
    $info = load_user_info($user_email, $pdo);    // load user info
    $_SESSION['user_info'] = $info;
    // redirect to main.php
    echo 'Redirecting to '. $user->get_first_name();
    header("Location: main.php");
}
?>

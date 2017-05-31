<!-- author: Jia Sheng Ma -->
<?php 
require_once("../include/functions.php");
require_once("user.php");
$user_email = $_POST["email"];
$password = $_POST["password"];

$connection = connect();
echo "[DEBUG] user: $user_email" . " pw:" . $password . "<br>";
echo "[DEBUG] Connection: " . mysqli_get_host_info($connection) . "<br/>";

// try to load user with give email and password
$user = loadUser($user_email, $password, $connection);

if(is_null($user)) {
    echo "email and password did not match <br/>";
    // rediect back to login page
    header("Location: index.php");
} else {
    // redirect to main.php
    echo 'Redirecting to '. $user->get_first_name();

    session_start();
    $_SESSION['loggedin'] = True;
    $_SESSION['user_email'] = $user_email;
    $_SESSION['user'] = $user;
    $_SESSION['connection'] = $connection;
    header("Location: main.php");
}
?>

<?php
/**
 * For listing all friends, used in user profile
 */
session_start();
require_once("../include/functions.php");
$pdo = connect();
$friends = $_SESSION['friends'];

// load every friend of the user, group by name
echo "<ul>";
foreach($friends as $f) {
    echo "<li>";
    // display profile picture 
    // echo 
    //TODO: href to user's home page
    echo "<a href=#>" . getUserNameByEmail($f, $pdo) . "</a>";
    echo "</li>";
}
echo "</ul>";
?>

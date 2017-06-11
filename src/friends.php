<?php
/**
 * For listing all friends, used in user profile
 */
session_start();
require_once("../include/functions.php");
$pdo = connect();

/* if $_SESSION['friends'] is not set, meaning not logged in, 
    then redirect back to main.php
*/
if(!isset($_SESSION['friends'])) {
    header("Location: main.php");
}

// list of friends are default to the logged in users'
$friends = $_SESSION['friends'];
// if there's a get request, change the friends 
if(isset($_GET['user'])) {
    $friends = loadFriends($_GET['user'], $pdo);
}


// load every friend of the user, group by name
echo "<ul>";
foreach($friends as $f) {
    echo "<li>";
    // display profile picture 
    // echo 
    //TODO: href to user's home page
    echo "<a href=\"NPC.php?user=" . $f . "\">". getUserNameByEmail($f, $pdo) . "</a>";
    echo "</li>";
}
echo "</ul>";
?>

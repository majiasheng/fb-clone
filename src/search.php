<!-- author: Jia Sheng Ma <jiasheng.ma@yahoo.com> -->
<?php
require_once("../include/functions.php");
session_start();
$user = $_SESSION['user'];

if(!isset($_GET['search']) || trim($_GET['search']=="")) {
    header("Location: main.php");
}



$pdo = connect();
$keyword = $_GET['search'];
//TODO: exclude self
$matches = getUserIfMatch($user->get_email(), $keyword, $pdo);
if(count($matches) == 0) {
    echo "No matches with \"$keyword\"";
} else {
    echo "<h2>Result</h2>";
    echo "<ul>";
    foreach($matches as $m) {
        if($m['email']==$user->get_email()) {
            continue;
        }
        echo "<li>";
        //TODO: echo profile pic
        // echo 
        // TODO: href to user's home page
        echo "<a href=\"NPC.php?user=". $m['email'] . "\">" . $m['first_name'] . " " . $m['last_name'] . "</a>";
        echo "</li>";
    }
    echo "</ul>";
}

?>
</div>
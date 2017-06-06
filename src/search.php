<?php
require_once("../include/functions.php");
session_start();
$user = $_SESSION['user'];

?>


<?php
if(!isset($_GET['search'])) {
    header("Location: main.php");
}
$pdo = connect();
$keyword = $_GET['search'];
/*TODO: run sql query on names or emails in database
        to match with the GET request
*/
//TODO: exclude self
$matches = getUserIfMatch($keyword, $pdo);

if(count($matches) == 0) {
    echo "No matches with \"$keyword\"";
} else {
    echo "<h2>Result</h2>";
    echo "<ul>";
    foreach($matches as $m) {
        echo "<li>";
        // echo 
        // TODO: href to user's home page
        echo "<a href=#>" . $m['first_name'] . " " . $m['last_name'] . "</a>";
        echo "</li>";
    }
    echo "</ul>";
}

?>
</div>
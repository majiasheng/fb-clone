<?php

if(!isset($_GET)) {
    header("Location: main.php");
}
$keyword = $_GET['search'];
/*TODO: run sql query on names or emails in database
        to match with the GET request
*/
echo "TODO: run sql query on names or emails in ".
    "database to match with the GET request";
?>
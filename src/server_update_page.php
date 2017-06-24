<?php

require_once("../include/functions.php");
session_start();

$user = $_SESSION['user'];
$pdo = connect();

$friends = loadFriends($user->get_email(), $pdo);




header("Content-Type: text/event-stream");
// header("Cache-Control: no-cache");
header("Connection: keep-alive");

echo "data: {$friends[0]}\n\n";
ob_flush();
flush();

?>
<?php

require_once("../include/functions.php");
session_start();

$user = $_SESSION['user'];
$pdo = connect();

$friends = $_SESSION['friends'];

header("Content-Type: text/event-stream");
// header("Cache-Control: no-cache");
header("Connection: keep-alive");


// pass an associate array of friends to the client side.
echo 'data: ' . json_encode($friends) . "\n\n";

ob_flush();
flush();

?>
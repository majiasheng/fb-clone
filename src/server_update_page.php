<?php

$voice = "hello world";

header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("Connection: keep-alive");

$lastId = $_SERVER["HTTP_LAST_EVENT_ID"];
if (isset($lastId) && !empty($lastId) && is_numeric($lastId)) {
    $lastId = intval($lastId);
    $lastId++;
} else {
    $lastId = 0;
}

function sendMessage($message){
    echo "data: $message\n\n";
    ob_flush();
    flush();
}
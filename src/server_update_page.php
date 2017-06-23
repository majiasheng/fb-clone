<?php

header("Content-Type: text/event-stream");
// header("Cache-Control: no-cache");
header("Connection: keep-alive");

$voice = "hello world";

echo "data: $voice\n\n";
ob_flush();
flush();


?>
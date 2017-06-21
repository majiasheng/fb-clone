<?php

function sendMessage(){

	header('Content-Type: text/event-stream\n\n');
    header('Cache-Control: no-cache');	

	$time = date('r');
	echo "data: The server time is {$time}\n\n";
	flush();
}

?>
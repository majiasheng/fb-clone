<!-- author: Jia Sheng Ma -->
<?php
session_start();

require 'constants.php';

$dsn = "mysql:host=".DB_SERVER.";dbname=".DB_NAME."charset=".CHARSET;
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $opt);

?>
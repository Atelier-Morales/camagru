<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$DB_DSN = 'mysql:host=localhost:3307;dbname=test;charset=utf8';
$DB_USER = 'root';
$DB_PASSWORD = 'fernan';
try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $ex) {
    echo "An Error occured! : ".$ex->getMessage();
}

?>

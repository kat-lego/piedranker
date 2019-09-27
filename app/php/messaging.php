<?php 
require_once('database_handler.php');

$assignid = $_GET['assignid'];
$userMessage = $_GET['userMessage'];

$dbh = new DatabaseHandler();
//$dbh->insert_message_data($assignid, $userMessage);
$dbh->close_connection();

?>

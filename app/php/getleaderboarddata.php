<?php
require_once('database_handler.php');

$assignid = $_GET['assignid'];
$default = $_GET['default'];
$ordering = $_GET['ordering'];
$numQ = $_GET['numberofquestions'];

$dbh = new DatabaseHandler();
echo json_encode($dbh->format_submission_data($assignid,$numQ,$default,$ordering));
$dbh->close_connection();
?>

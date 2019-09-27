<?php 
require_once('database_handler.php');

$courseid = $_GET['courseid'];
$assignid = $_GET['assignid'];
$userMessage = $_GET['userMessage'];


$dbh = new DatabaseHandler();

if(isset($userMessage)){
  $dbh->insert_message_data($assignid, $courseid, "'".$userMessage."'");
} else {
  echo json_encode($dbh->get_message_data($assignid));
}

$dbh->close_connection();

?>

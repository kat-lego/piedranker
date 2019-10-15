<?php

require_once('config.php');

class DatabaseHandler {
  public $connection;

  public function __construct(){
    $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
  }

  public function close_connection(){
    return $this->connection->close();
  }

  public function get_data($stmt){
    $stmt->execute();
    $data = null;

    if (!($res = $stmt->get_result())) {
      echo "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    for ($row_no = ($res->num_rows - 1); $row_no >= 0; $row_no--) {
      $res->data_seek($row_no);
      $data[] = $res->fetch_assoc();
    }
    if($data)
      return $data;
    else
      return false;
  }

  public function get_assignments($courseid){
    $A = TABLE_PREFIX.'customfeedback_assignment';
    $B = TABLE_PREFIX.'assign';
    $C = TABLE_PREFIX.'course';
    $sql = "SELECT $A.mode,
                   $A.language,
                   $A.number_of_questions,
                   $A.default_score,
                   $A.ordering,
                   $B.id,
                   $B.name,
                   $B.duedate,
                   $B.teamsubmission,
                   $B.teamsubmissiongroupingid,
                   $C.shortname
            FROM $A,$B,$C
            WHERE $A.id = $B.id AND
                  $B.course = $C.id AND
                  $C.id = ?
            ";

    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("i", $courseid);
    $data = $this->get_data($stmt);

    if($data){
      return $data;
    }else{
      return false;
    }
    
  }

  public function get_formatted_assignments($courseid){
    if($data = $this->get_assignments($courseid)){
      $data1 = array();
      foreach($data as $key=>$value){
        $id = $value['id'];
        unset($value['id']);
        $data1[$id] = $value;
      }
      $data1 = json_encode($data1);
      return $data1;
    }else{
      return false;
    }
  }

  public function get_assingment_data($assign_id){
    $sql = "SELECT mdl_customfeedback_assignment.mode,
                   mdl_customfeedback_assignment.language,
                   mdl_customfeedback_assignment.number_of_questions,
                   mdl_customfeedback_assignment.default_score,
                   mdl_customfeedback_assignment.ordering,
                   mdl_assign.course,
                   mdl_assign.name,
                   mdl_assign.duedate,
                   mdl_assign.teamsubmission,
                   mdl_assign.teamsubmissiongroupingid
            FROM mdl_customfeedback_assignment,mdl_assign
            WHERE mdl_assign.id = ? AND
                  mdl_customfeedback_assignment.id = mdl_assign.id;
           ";
    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("i", $assign_id);

    $data = $this->get_data($stmt);
    if($data){
      return reset($data);
    }else{
      return false;
    }
  }

  public function get_message_data($assign_id) {
    $sql = "SELECT message, timestamp 
            FROM mdl_chat_messages 
            WHERE chatid = '$assign_id'
            ORDER BY timestamp DESC;";
    
    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("i", $assign_id);
    $data = $this->get_data($stmt);

    if($data){
      return $data;
    }else{
      return false;
    }
  }

  public function insert_message_data($assignid, $courseid, $userMessage){
    $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
	// Check connection
	if($link === false){
	    die("ERROR: Could not connect. " . mysqli_connect_error());
	}
    
    $dateTime = new DateTime;
    $dt = $dateTime->format('U');

    $sql = "INSERT INTO mdl_chat_messages (chatid, userid, message, timestamp)
	    VALUES ($courseid, 2, $userMessage, $dt)";
    
	if(mysqli_query($link, $sql)){
	    echo "Message sent successfully.";
            header("Location: http://1710409.ms.wits.ac.za/piedranker/app/php/rankings.php?assignid=$assignid&courseid=$courseid");
	} else{
	    echo "ERROR: Not able to execute $sql. " . mysqli_error($link);
	}
        mysqli_close($link);
  }

  public function get_submission_data($assign_id){
    $A = TABLE_PREFIX.'customfeedback_submission';
    $B = TABLE_PREFIX.'user';

    $sql = "SELECT $A.question_number,
                   $A.score,
                   $A.no_of_submittions,
                   $A.status,
                   $B.id,
                   $B.username,
                   $B.firstname,
                   $B.lastname
            FROM $A,$B
            WHERE $A.user_id=$B.id AND
                  $A.assign_id = ?
          ";
    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("i", $assign_id);

    $data = $this->get_data($stmt);

    if($data){
      return $data;
    }else{
      return false;
    }
  }


  public function format_submission_data($assign_id,$n,$default,$order){
    
    if($data = $this->get_submission_data($assign_id)){

      $tree = array();
      foreach ($data as $key => $value) {
        if(!array_key_exists($value["id"], $tree)){
          $user = array();
          $user["total_score"] = 0;
          $user["username"] = $value["username"];
          $user["firstname"] = $value["firstname"];
          $user["lastname"] = $value["lastname"];
          for($i=0;$i<$n;$i++){
            $question = array();
            $question["score"]=$default;
            $question["no_of_submittions"]=0;
            $question["status"]=-1;
            $user[$i] = $question;
          }
          $tree[$value["id"]] = $user;
        }

        $question = array();
        $question["score"]=($value["status"]==4)?$value["score"]:$default;
        $question["no_of_submittions"]=$value["no_of_submittions"];
        $question["status"]=$value["status"];
        $tree[$value["id"]][intval($value["question_number"])] = $question;
        $tree[$value["id"]]["total_score"]+=$question["score"];

      }

      if($order == 0){
        usort($tree, function($a, $b) { return $a["total_score"] - $b["total_score"]; });
      }
      else{
        usort($tree, function($a, $b) { return $b["total_score"] - $a["total_score"]; });
      }

      return $tree;
    }else{
      return false;
    }
  }

  function format_group_submission_data($assign_id,$n,$default,$order){
    if($data = $this->get_group_submission_data($assign_id)){

      $tree = array();
      foreach ($data as $key => $value) {
        if(!array_key_exists($value["id"], $tree)){
          $user = array();
          $user["total_score"] = 0;
          $user["teamname"] = $value["name"];
          for($i=0;$i<$n;$i++){
            $question = array();
            $question["score"]=$default;
            $question["status"]=-1;
            $user[$i] = $question;
          }
          $tree[$value["id"]] = $user;
        }

        $question = array();
        $question["score"]=($value["status"]==4)?$value["score"]:$default;
        $question["status"]=$value["status"];
        $tree[$value["id"]][intval($value["question_number"])] = $question;
        $tree[$value["id"]]["total_score"]+=$question["score"];

      }

      if($order == 0){
        usort($tree, function($a, $b) { return $a["total_score"] - $b["total_score"]; });
      }
      else{
        usort($tree, function($a, $b) { return $b["total_score"] - $a["total_score"]; });
      }

      return $tree;
    }else{
      return false;
    }
  }

  public function get_group_submission_data($assign_id){
    $A = TABLE_PREFIX.'customfeedback_group_subs';
    $B = TABLE_PREFIX.'groups';
    
    $sql = "SELECT $A.question_number,
                   $A.score,
                   $A.status,
                   $B.id,
                   $B.name
            FROM $A,$B
            WHERE $A.group_id=$B.id AND
                  $A.assign_id = ?
          ";
    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("i", $assign_id);

    $data = $this->get_data($stmt);

    if($data){
      return $data;
    }else{
      return false;
    }
  }


}
?>

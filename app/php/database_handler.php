<?php

class DatabaseHandler {
  private $servername;
  private $username;
  private $password;
  private $dbname;
  protected $connection;

  public function __construct(){
    $this->servername = "127.0.0.1";
    $this->username = "username";
    $this->password = "password";
    $this->dbname = "moodle";
    $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
  }

  public function close_connection(){
    $this->connection->close();
  }

  private function get_data($stmt){
    $stmt->execute();

    if (!($res = $stmt->get_result())) {
      echo "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    for ($row_no = ($res->num_rows - 1); $row_no >= 0; $row_no--) {
      $res->data_seek($row_no);
      $data[] = $res->fetch_assoc();
    }
    return $data;
  }

  public function get_assingment_data($assign_id){
    $sql = "SELECT mdl_customfeedback_assignment.mode,
                   mdl_customfeedback_assignment.language,
                   mdl_customfeedback_assignment.number_of_questions,
                   mdl_customfeedback_assignment.default_score,
                   mdl_customfeedback_assignment.ordering,
                   mdl_assign.course,
                   mdl_assign.name,
                   mdl_assign.duedate
            FROM mdl_customfeedback_assignment,mdl_assign
            WHERE mdl_assign.id = ? AND
                  mdl_customfeedback_assignment.id = mdl_assign.id;
           ";
    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("i", $assign_id);

    $data = $this->get_data($stmt);
    // var_dump($data);
    return reset($data);
  }

  public function get_submission_data($assign_id){
    $sql = "SELECT mdl_customfeedback_submission.question_number,
                   mdl_customfeedback_submission.score,
                   mdl_customfeedback_submission.no_of_submittions,
                   mdl_customfeedback_submission.status,
                   mdl_user.id,
                   mdl_user.username,
                   mdl_user.firstname,
                   mdl_user.lastname
            FROM mdl_customfeedback_submission,mdl_user
            WHERE mdl_customfeedback_submission.user_id=mdl_user.id AND
                  mdl_customfeedback_submission.assign_id = ?
          ";
    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("i", $assign_id);

    $data = $this->get_data($stmt);
    // echo var_dump($data);
    // echo "done getting data";
    return $data;
  }

  public function format_submission_data($assign_id,$assign){
    $data = $this->get_submission_data($assign_id);
    $n = $assign["number_of_questions"];
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
          $question["score"]=$assign["default_score"];
          $question["no_of_submittions"]=0;
          $question["status"]=-1;
          $user[$i] = $question;
        }
        $tree[$value["id"]] = $user;
      }

      $question = array();
      $question["score"]=($value["status"]==4)?$value["score"]:$assign["default_score"];
      $question["no_of_submittions"]=$value["no_of_submittions"];
      $question["status"]=$value["status"];
      $tree[$value["id"]][intval($value["question_number"])] = $question;
      $tree[$value["id"]]["total_score"]+=$question["score"];

    }

    if($assign["ordering"] == 0){
      usort($tree, function($a, $b) { return $a["total_score"] - $b["total_score"]; });
    }
    else{
      usort($tree, function($a, $b) { return $b["total_score"] - $a["total_score"]; });
    }
    // $tree = json_encode($tree);
    // echo $tree;

    return $tree;
  }

  // public function get_leaderboard_data($assign_id){
  //   $n = get_assingment_data($assign_id)[0][];
  //   echo $n;
  //   $data = get_submission_data($assign_id);
  // }


}
?>

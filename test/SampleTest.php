<?php

use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
	public function test_close_connection(){
		$ranker = new DatabaseHandler();
		$this->assertTrue($ranker->close_connection());
	}

	public function test_get_data(){
		$ranker = new DatabaseHandler();
		$sql = "SELECT * FROM mdl_customfeedback_assignment WHERE id = ?";
		$id = 71;
		$stmt = $ranker->connection->prepare($sql);
		$stmt->bind_param("i", $id);
		$res = json_encode($ranker->get_data($stmt));
		$expected ='[{"id":71,"mode":"Fastest Mode","language":"Python","number_of_questions":1,"ordering":0,"default_score":100000}]';
		$ranker->close_connection();
		$this->assertEquals($res,$expected);
	}

	public function test_get_assignments(){
		$ranker = new DatabaseHandler();
		$res = json_encode($ranker->get_assignments(10));
		$expected = '[{"mode":"Fastest Mode","language":"Python","number_of_questions":1,"default_score":100000,"ordering":0,"id":74,"name":"Assemly Lab1","duedate":1566601200,"teamsubmission":0,"teamsubmissiongroupingid":0,"shortname":"aaa"},{"mode":"Fastest Mode","language":"Python","number_of_questions":1,"default_score":100000,"ordering":0,"id":72,"name":"fukl","duedate":1566255600,"teamsubmission":0,"teamsubmissiongroupingid":0,"shortname":"aaa"}]';
		$this->assertEquals($res,$expected);

		$res = $ranker->get_assignments(1000);
		$this->assertTrue(!$res);
		$ranker->close_connection($expected, $res);
	}

	public function test_get_formatted_assignments(){
		$ranker = new DatabaseHandler();
		$res = $ranker->get_formatted_assignments(10);
		$expected = '{"74":{"mode":"Fastest Mode","language":"Python","number_of_questions":1,"default_score":100000,"ordering":0,"name":"Assemly Lab1","duedate":1566601200,"teamsubmission":0,"teamsubmissiongroupingid":0,"shortname":"aaa"},"72":{"mode":"Fastest Mode","language":"Python","number_of_questions":1,"default_score":100000,"ordering":0,"name":"fukl","duedate":1566255600,"teamsubmission":0,"teamsubmissiongroupingid":0,"shortname":"aaa"}}';
		$this->assertEquals($res,$expected);

		$res = $ranker->get_assignments(1000);
		$this->assertTrue(!$res);
		$ranker->close_connection($expected, $res);
	}

	public function test_get_assingment_data(){
		$ranker = new DatabaseHandler();
		$res = json_encode($ranker->get_assingment_data(72));
		$expected = '{"mode":"Fastest Mode","language":"Python","number_of_questions":1,"default_score":100000,"ordering":0,"course":10,"name":"fukl","duedate":1566255600,"teamsubmission":0,"teamsubmissiongroupingid":0}';
		$this->assertEquals($res,$expected);

		
		$res = $ranker->get_assingment_data(1000);
		$this->assertTrue(!$res);
		$ranker->close_connection($expected, $res);
	}

	public function test_get_submission_data(){
		$ranker = new DatabaseHandler();
		$res = json_encode($ranker->get_submission_data(72));
		$expected ='[{"question_number":0,"score":56.667,"no_of_submittions":4,"status":4,"id":2,"username":"architect","firstname":"Admin","lastname":"User"}]';
		$this->assertEquals($res,$expected);

		$res = $ranker->get_assingment_data(1000);
		$this->assertTrue(!$res);
		$ranker->close_connection($expected, $res);
	}

	public function test_format_submission_data(){
		$ranker = new DatabaseHandler();
		$res = json_encode($ranker->format_submission_data(72,1,100,1));
		$expected = '[{"total_score":56.667,"username":"architect","firstname":"Admin","lastname":"User","0":{"score":56.667,"no_of_submittions":4,"status":4}}]';
		$this->assertEquals($res,$expected);

		$res = json_encode($ranker->format_submission_data(72,1,100,0));
		$expected = '[{"total_score":56.667,"username":"architect","firstname":"Admin","lastname":"User","0":{"score":56.667,"no_of_submittions":4,"status":4}}]';
		$this->assertEquals($res,$expected);

		$res = $ranker->format_submission_data(1000,1,100,0);
		$this->assertTrue(!$res);

		$ranker->close_connection();
	}

	public function test_format_group_submission_data(){
		$ranker = new DatabaseHandler();
		$res = json_encode($ranker->format_group_submission_data(112,1,1000,0));
		$expected = '[{"total_score":0,"teamname":"terminators","0":{"score":"0.000","status":4}},{"total_score":1000,"teamname":"The holes","0":{"score":1000,"status":6}}]';
		$this->assertEquals($res,$expected);

		$res = $ranker->format_submission_data(1000,1,100,0);
		$this->assertTrue(!$res);

		$ranker->close_connection($expected, $res);
	}

	public function test_get_group_submission_data(){
		$ranker = new DatabaseHandler();
		$res = json_encode($ranker->get_group_submission_data(112));
		$expected = '[{"question_number":0,"score":"0.000","status":6,"id":12,"name":"The holes"},{"question_number":0,"score":"0.000","status":4,"id":11,"name":"terminators"}]';
		$this->assertEquals($res,$expected);

		$res = $ranker->get_assingment_data(1000);
		$this->assertTrue(!$res);
		$ranker->close_connection($expected, $res);
	}





}

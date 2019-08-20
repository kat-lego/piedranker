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
		$expected = '[{"id":71,"mode":"Fastest Mode","language":"Python","number_of_questions":1,"ordering":0,"default_score":0}]';
		$ranker->close_connection($expected, $res);
		$this->assertEquals($res,$expected);
	}

	public function test_get_assignments(){
		$ranker = new DatabaseHandler();
		$res = json_encode($ranker->get_assignments(10));
		$expected = '[{"mode":"Fastest Mode","language":"Python","number_of_questions":1,"default_score":0,"ordering":0,"id":74,"name":"Assemly Lab1","duedate":1566601200,"shortname":"aaa"},{"mode":"Fastest Mode","language":"Python","number_of_questions":1,"default_score":0,"ordering":0,"id":72,"name":"fukl","duedate":1566255600,"shortname":"aaa"}]';
		$this->assertEquals($res,$expected);

		$res = $ranker->get_assignments(1000);
		$this->assertTrue(!$res);
		$ranker->close_connection($expected, $res);
	}

	public function test_get_formatted_assignments(){
		$ranker = new DatabaseHandler();
		$res = $ranker->get_formatted_assignments(10);
		$expected = '{"74":{"mode":"Fastest Mode","language":"Python","number_of_questions":1,"default_score":0,"ordering":0,"name":"Assemly Lab1","duedate":1566601200,"shortname":"aaa"},"72":{"mode":"Fastest Mode","language":"Python","number_of_questions":1,"default_score":0,"ordering":0,"name":"fukl","duedate":1566255600,"shortname":"aaa"}}';
		$this->assertEquals($res,$expected);

		$res = $ranker->get_assignments(1000);
		$this->assertTrue(!$res);
		$ranker->close_connection($expected, $res);
	}

	public function test_get_assingment_data(){
		$ranker = new DatabaseHandler();
		$res = json_encode($ranker->get_assingment_data(72));
		$expected = '{"mode":"Fastest Mode","language":"Python","number_of_questions":1,"default_score":0,"ordering":0,"course":10,"name":"fukl","duedate":1566255600}';
		$this->assertEquals($res,$expected);

		
		$res = $ranker->get_assingment_data(1000);
		$this->assertTrue(!$res);
		$ranker->close_connection($expected, $res);
	}

	public function test_get_submission_data(){
		$ranker = new DatabaseHandler();
		$res = json_encode($ranker->get_submission_data(72));
		$expected = '[{"question_number":0,"score":30,"no_of_submittions":2,"status":4,"id":2,"username":"architect","firstname":"Admin","lastname":"User"}]';
		$this->assertEquals($res,$expected);

		$res = $ranker->get_assingment_data(1000);
		$this->assertTrue(!$res);
		$ranker->close_connection($expected, $res);
	}

	public function test_format_submission_data(){
		$ranker = new DatabaseHandler();
		$res = json_encode($ranker->format_submission_data(72,1,100,1));
		$expected = '[{"total_score":30,"username":"architect","firstname":"Admin","lastname":"User","0":{"score":30,"no_of_submittions":2,"status":4}}]';
		$this->assertEquals($res,$expected);

		$res = json_encode($ranker->format_submission_data(72,1,100,0));
		$expected = '[{"total_score":30,"username":"architect","firstname":"Admin","lastname":"User","0":{"score":30,"no_of_submittions":2,"status":4}}]';
		$this->assertEquals($res,$expected);

		$res = $ranker->format_submission_data(1000,1,100,0);
		$this->assertTrue(!$res);

		$ranker->close_connection($expected, $res);
	}



}

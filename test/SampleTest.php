<?php

use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{

	public function testTomething(){
		$ranker = new DatabaseHandler();
		$n = $ranker->get_assingment_data(69);
		// $arr = json_encode(array(69 => $n));
		// var_dump($arr);
		$data = $ranker->format_submission_data(69,$n);
		for($i=1;$i<=5;$i++){
			$data[$i] = $data[0];
		}
		var_dump(json_encode($data));
	}

}

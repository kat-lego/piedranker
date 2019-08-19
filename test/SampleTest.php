<?php

use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{

	public function testTomething(){
		$ranker = new DatabaseHandler();
		$assignments = $ranker->get_formatted_assignments(10);
		var_dump($assignments);
		// $n = $assignments['number_of_questions'];
		// $default = $assignments['default_score'];
		// $order = $assignments['ordering'];
		// $ranker->format_submission_data(72,$n,$default,$order);
		$ranker->close_connection();
	}

}

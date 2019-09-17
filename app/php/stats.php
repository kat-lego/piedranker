<?php
	require_once('database_handler.php');
	$assignid = $_GET['assignid'];
	$courseid = $_GET['courseid'];
	$questionnum = $_GET['question_num'];
	
	
	$dbh = new DatabaseHandler();
	$assignmentList = $dbh->get_formatted_assignments($courseid);
	// $assignmentList =  '{"69":{"mode":"OptiMode","language":"Python","number_of_questions":1,"default_score":1000,"ordering":0,"course":2,"name":"df","duedate":1566255600}}';
	$dbh->close_connection();
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../css/stats_style.css">
	<link href="https://fonts.googleapis.com/css?family=Lexend+Exa|Pacifico|Ubuntu&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<script src="../javascript/script.js"></script>
	<script src="../javascript/stats_script.js"></script>

    <script type="text/javascript">	
		var assignid;
		var courseid;
		var question_num;
		var assignmentList; //json with data about assignments
		var leaderboardData; //json with leaderboard data

		function loadPageData(){
            assignmentList = <?php echo $assignmentList; ?>;
			assignid = <?php echo $assignid; ?> ;
			question_num = <?php echo $questionnum;?>;
			courseid = <?php echo $courseid; ?> ;
            // console.log(assignmentList[assignid]);
			fillTitle();
			fill_question_Heading(question_num);
			prepareTableHeader();
			fetch_leaderboard_data(assignid, question_num);
			autoUpdate2();
		}

		function autoUpdate2(){
			setInterval(function() {
				fetch_leaderboard_data(assignid, question_num);
			}, 5000);
		}


		
	</script>

	<title>Pied Ranks</title>
</head>
<body onload="loadPageData()">
	<div class= "page">
		<div class= "header">
			<div class="logo_container">
			<h1>Pied </br> Ranks </h1>
			</div>

			<div class="title">
			<h1 id = "h1_title"> Assignment name <br/> Assignment mode </h1>
			</div>

			<div class= "question_header">
			 <h1 id = "q_heading"> Question i </br> Statistics </h1>
			</div>


		</div>

		<input type="text" id="searchInput" onkeyup="searchFunction()" placeholder="Search for names..">
		<div class="row">
		  <div class="column1">
		  	<table class="content-table" id="leaderboard">
				<thead>
					<tr>
					<th>Rank</th>
					<th>Name</th>
					<th>Points</th>
					</tr>
				</thead>
				<tbody>
					<tr>
					<td>1</td>
					<td>Name1</td>
					<td>88,110</td>
					</tr>

					<tr>
					<td>1</td>
					<td>Name1</td>
					<td>88,110</td>
					</tr>

					<tr>
					<td>1</td>
					<td>Name1</td>
					<td>88,110</td>
					</tr>

					<tr>
					<td>1</td>
					<td>Name1</td>
					<td>88,110</td>
					</tr>

					<tr>
					<td>1</td>
					<td>Name1</td>
					<td>88,110</td>
					</tr>


				</tbody>
			</table>

		  </div>
		  <div class="column2">
		  	<table class="content-table" id="stats_table">
		  		<thead>
					<tr>
					<th>Statistics</th>
					<th></th>
					</tr>
				</thead>

		  	</table>
		  </div>
		</div>




	</div>

</body>
</html>

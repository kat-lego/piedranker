<?php
require_once('database_handler.php');
$assignid = $_GET['assignid'];
$courseid = $_GET['courseid'];


$dbh = new DatabaseHandler();
$assignmentList = $dbh->get_formatted_assignments($courseid);
// $assignmentList =  '{"69":{"mode":"OptiMode","language":"Python","number_of_questions":1,"default_score":1000,"ordering":0,"course":2,"name":"df","duedate":1566255600}}';
$dbh->close_connection();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Lexend+Exa|Pacifico|Ubuntu&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<script src="../javascript/script.js"></script>

  <script type="text/javascript">
		var assignid;
		var courseid;
		var assignmentList; //json with data about assignments
		var leaderboardData; //json with leaderboard data

		function preparedata(){
            assignmentList = <?php echo $assignmentList; ?>;
			assignid = <?php echo $assignid; ?> ;
			courseid = <?php echo $courseid; ?> ;
            // console.log(assignmentList[assignid]);
            loadLeaderboardData(assignid);
            fillTitle();
            fillNav();
		}

	</script>

	<title>Pied Ranks</title>
</head>
<body onload="preparedata()">
	<div class= "page">
		<div class= "header">
		
			<div class="sidenav_icon">
			<div class="icon" onclick="openNav()">
				<svg viewBox="0 0 24 24" x="0px" y="0px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				<g id="menu">
				<path d="M3,18h18v-2H3V18z M3,13h18v-2H3V13z M3,6v2h18V6H3z"></path>
				</g>
				</svg>
			</div>

			<div class="logo_container">
			<h1>Pied </br> Ranks </h1>
			</div>

			</div>


			<div class="title">
			<h1 id = "h1_title"> Assignment name <br/> Assignment mode </h1>
			</div>

			<div class="right_pad"></div>

		

		</div>

		<input type="text" id="searchInput" onkeyup="searchFunction()" placeholder="Search for names..">
		<div class = "leaderboard_container">
		<table class="content-table" id="leaderboard">
		<thead>
			<tr>
			<th>Rank</th>
			<th>Name</th>
			<th>Points</th>
			<th>Team</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			<td>1</td>
			<td>Name1</td>
			<td>88,110</td>
			<td>Cloud9</td>
			</tr>
			<tr>
			<td>2</td>
			<td>Qwert</td>
			<td>72,400</td>
			<td>Optic</td>
			</tr>
			<tr>
			<td>3</td>
			<td>Nick</td>
			<td>52,300</td>
			<td>dcode</td>
			</tr>
					<tr>
			<td>4</td>
			<td>Domenic</td>
			<td>88,110</td>
			<td>dcode</td>
			</tr>
			<tr>
			<td>5</td>
			<td>Sally</td>
			<td>72,400</td>
			<td>Students</td>
			</tr>
			<tr>
			<td>6</td>
			<td>Nick</td>
			<td>52,300</td>
			<td>dcode</td>
			</tr>
					<tr>
			<td>Car</td>
			<td>Domenic</td>
			<td>88,110</td>
			<td>dcode</td>
			</tr>


		</tbody>
		</table>
	</div>
		<div id="mySidenav" class="sidenav">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		</div>
	</div>

</body>
</html>

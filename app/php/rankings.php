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

	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<script src='https://kit.fontawesome.com/a076d05399.js'></script>

  <script type="text/javascript">
	    var type = "leaderboard";
		var type2 = "teamsboard";
		var assignid;
		var courseid;
		var assignmentList; //json with data about assignments
		var leaderboardData; //json with leaderboard data
		var prev_data = null;

		function preparedata(){
			assignmentList = <?php echo $assignmentList; ?>;
			assignid = <?php echo $assignid; ?> ;
			courseid = <?php echo $courseid; ?> ;
			//console.log(assignmentList[assignid]);
			var assign = assignmentList[assignid];
			prepareTable(assign.number_of_questions);
			loadMessageData(courseid);
			
			loadLeaderboardData(assignid, type);
            //loadLeaderboardData(assignid, type2);
            fillTitle();
			fillNav();
			//autoUpdate();
		}

		function autoUpdate(){
			setInterval(function() {
				loadLeaderboardData(assignid, type);
				//loadLeaderboardData(assignid, type2);
			}, 5000);
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

			<!--<h1><button id = "myBtn" class= "button1"> View Teams <i class='fas fa-users'></i></button></h1>
			
			<!-- The Modal 
				<div id="myModal" class="modal">

  				<!-- Modal content 
  				<div class="modal-content">
    				<span class="close">&times;</span>
                                <p> Leaderboard for teams </p><br>
                                <p> If initial of name A-M, then you are in BLUE TEAM </p><br>
                                <p> If initial of name N-Z, then you are in RED TEAM </p>
                                <table class="content-table" id="teamsboard">
		<thead>
			<tr>
			<th>Team Name</th>
			<th>Points</th>
			</tr>
		</thead>
		</table>
  				</div>

				</div> -->

				<button class="open-button" onclick="openForm()">Chat</button>

				<div class="chat-popup" id="myForm">
				 <form action="messaging.php" class="form-container">
				    <h1>Chat</h1>

				    <label for="msg"><b>Messages</b></label>
                                   
		                    <div id="messageBody" class="ex3">
                                    <!--Holding messages-->
 				    	 <!-- <div class="container">
					  <img src="/w3images/bandmember.jpg" alt="User" style="width:100%;">
					  <p>Hello. How are you today?</p>
					  <span class="time-right">11:00</span>
					</div>

					<div class="container darker">
					  <img src="/w3images/avatar_g2.jpg" alt="User" class="right" style="width:100%;">
					  <p>Hey! I'm fine. Thanks for asking!</p>
					  <span class="time-left">11:01</span>
					</div>

					<div class="container">
					  <img src="/w3images/bandmember.jpg" alt="User" style="width:100%;">
					  <p>Sweet! So, what do you wanna do today?</p>
					  <span class="time-right">11:02</span>
					</div>

					<div class="container darker">
					  <img src="/w3images/avatar_g2.jpg" alt="User" style="width:100%;">
					  <p>Nah, I dunno. Play soccer.. or learn more coding perhaps?</p>
					  <span class="time-left">11:05</span>
					</div>

                                        <div class="container">
					  <img src="/w3images/bandmember.jpg" alt="User" style="width:100%;">
					  <p>Sweet!</p>
					  <span class="time-right">11:06</span>
					</div>-->
                                    </div>

				    <form action="messaging.php" method="get" class="form-container">
				    <textarea id = "userMessage" placeholder="Type message.." name="userMessage" required></textarea>
                                    <input type='hidden' name='courseid' value="<?php echo $courseid; ?>" />
				    <input type='hidden' name='assignid' value="<?php echo $assignid; ?>" />

				    <button type="submit" class="btn">Send</button>
				    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
				  </form>

				</div>

			<div class="right_pad"></div>
		</div>

		<input type="text" id="searchInput" onkeyup="searchFunction()" placeholder="Search for names..">
		<div class = "leaderboard_container">
		<table class="content-table" id="leaderboard">
		</table>
	</div>
		<div id="mySidenav" class="sidenav">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		</div>
	</div>

</body>
</html>



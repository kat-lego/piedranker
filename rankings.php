<?php

$assignid = $_GET['assignid'];
$assignmentList =  '{"69":{"mode":"OptiMode","language":"Python","number_of_questions":1,"default_score":1000,"ordering":0,"course":2,"name":"df","duedate":1566255600}}';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Lexend+Exa|Pacifico|Ubuntu&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<script src="index.js"></script>

    <script type="text/javascript">
        var assignid;
		var assignmentList; //json with data about assignments
		var leaderboardData; //json with leaderboard data

		function preparedata(){
            assignmentList = <?php echo $assignmentList; ?>;
            console.log(assignmentList[69]);
            assignid = <?php echo $assignid;?>;
            // loadLeaderboardData(assignid);
            fillTitle();
            fillNav();
		}

	</script>

	<title>Pied Ranks</title>
</head>
<body onload="preparedata()">
	<div class= "header">
	  <div class="inner_header">
	    <div class="sidenav_icon">
	      <div class="icon" onclick="openNav()">
	   	     <svg viewBox="0 0 24 24" x="0px" y="0px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <g id="menu">
               <path d="M3,18h18v-2H3V18z M3,13h18v-2H3V13z M3,6v2h18V6H3z"></path>
              </g>
             </svg>
	      </div>
	    </div>

	    <div class="logo_container">
	      <h1>Pied Ranks </h1>
	    </div>

	    <div class="title">
		 <h1 id = "h1_title"> Assignment name <br/> Assignment mode </h1>
	    </div>

	  </div>

	</div>

	<input type="text" id="searchInput" onkeyup="myFunction()" placeholder="Search for names..">

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
	      <td>Domenic</td>
	      <td>88,110</td>
	      <td>dcode</td>
	    </tr>
	    <tr>
	      <td>2</td>
	      <td>Sally</td>
	      <td>72,400</td>
	      <td>Students</td>
	    </tr>
	    <tr>
	      <td>3</td>
	      <td>Nick</td>
	      <td>52,300</td>
	      <td>dcode</td>
	    </tr>
	    	    <tr>
	      <td>1</td>
	      <td>Domenic</td>
	      <td>88,110</td>
	      <td>dcode</td>
	    </tr>
	    <tr>
	      <td>2</td>
	      <td>Sally</td>
	      <td>72,400</td>
	      <td>Students</td>
	    </tr>
	    <tr>
	      <td>3</td>
	      <td>Nick</td>
	      <td>52,300</td>
	      <td>dcode</td>
	    </tr>
	    	    <tr>
	      <td>1</td>
	      <td>Domenic</td>
	      <td>88,110</td>
	      <td>dcode</td>
	    </tr>
	    <tr class="active-row">
	      <td>2</td>
	      <td>Sally</td>
	      <td>72,400</td>
	      <td>Students</td>
	    </tr>
	    <tr>
	      <td>3</td>
	      <td>Nick</td>
	      <td>52,300</td>
	      <td>dcode</td>
	    </tr>
	    	    <tr>
	      <td>1</td>
	      <td>Domenic</td>
	      <td>88,110</td>
	      <td>dcode</td>
	    </tr>
	    <tr class="active-row">
	      <td>2</td>
	      <td>Sally</td>
	      <td>72,400</td>
	      <td>Students</td>
	    </tr>
	    <tr>
	      <td>3</td>
	      <td>Nick</td>
	      <td>52,300</td>
	      <td>dcode</td>
	    </tr>
	    	    <tr>
	      <td>1</td>
	      <td>Domenic</td>
	      <td>88,110</td>
	      <td>dcode</td>
	    </tr>
	    <tr class="active-row">
	      <td>2</td>
	      <td>Sally</td>
	      <td>72,400</td>
	      <td>Students</td>
	    </tr>
	    <tr>
	      <td>3</td>
	      <td>Nick</td>
	      <td>52,300</td>
	      <td>dcode</td>
	    </tr>

	  </tbody>
	</table>

	<div id="mySidenav" class="sidenav">
  	<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
	</div>

	<div>
		FOOTER
	</div>



</body>
</html>
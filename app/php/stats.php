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
			fetch_leaderboard_rows(assignid, question_num);
		}

		function fill_question_Heading(q){
  			var t =  document.getElementById("q_heading");
  			t.innerHTML = "Question "+ q + "</br>" + "Statistics";
		}

		function prepareTableHeader(){
			var table = document.getElementById("leaderboard");
			var id = table.id;
			var newt = document.createElement("table");
			newt.id = id;
			newt.className = "content-table";
			table.parentNode.replaceChild(newt, table);

			//add table header
			var head = document.createElement("thead");
			var html = "<tr> <th>Rank</th> <th>Name</th> <th>Score</th> </tr>";
			head.innerHTML = html;
			newt.appendChild(head);
		}

		function fetch_leaderboard_rows(id,q){
			var assign = assignmentList[id];

			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					fill_statistics_table(this,q);
					fill_leaderboard_rows(this,q);
				}
			};

			var request = "../php/getleaderboarddata.php?assignid="+id+"&default="+assign.default_score+"&ordering="+assign.ordering+"&numberofquestions="+assign.number_of_questions;
			console.log(request);
			xhttp.open("GET", request , true);
			xhttp.send();

		}

		function fill_statistics_table(xhttp,q){
			var data = JSON.parse(xhttp.responseText);
			var table = document.getElementById("stats_table");
			//add body
			var body = document.createElement("tbody");
			var html = "";
			var record = [0,-1,0,0,0,-1,0,-1,0,-1,0,0,0,0];
			
			var sum = 0;
			
			for(row in data) {
				var question =data[row][q];
				if(question != null){
					if(record[question.status] != -1){
						record[question.status]+=1;
					}else{
						record[13]+=1;
					}
					
					sum+=1;
				}
				
			}
			for(var i=0;i<14;i++){
				if(record[i]!=-1){
				html+="<tr>";
				html+="<td>"+return_status_string(i)+" </td> ";
				html+="<td>"+record[i]+"</td>";
				html+="</tr>";
				}
			}
			html+="<tr>";
			html+="<td>Total Submissions</td> ";
			html+="<td>"+sum+"</td>";
			html+="</tr>";

			body.innerHTML = html;
			table.appendChild(body);

		}

		function return_status_string(status){
				if(status == 0)
                    return "Judge in progress";
				else if(status == 2)
                    return "Compilation Error";
				else if(status == 3)
                    return "Presentation Error";
				else if(status == 4)
                    return "Accepted";
                else if(status == 6)
                    return "Incorrect";
            	else if(status ==  8)
                    return  "Time Limit Exceeded";
                else if(status == 11)
                    return "Memory Limit Exceeded";
                else if(status == 12)
                    return  "Run-time Error";
                else
                    return "Other";
		}

		function fill_leaderboard_rows(xhttp, q){
			var data = JSON.parse(xhttp.responseText);
			var table = document.getElementById("leaderboard");

			//add body
			var body = document.createElement("tbody");
			var html = "";

			var pos =-1;
			var x = null;
			for(row in data) {
				if(x!=data[row].total_score){
				pos++;
				x = data[row].total_score;
				}

				html+="<tr>";
				html+="<td>"+pos+" </td> ";
				html+="<td>"+data[row].firstname+" "+data[row].lastname+"</td>";
					
				html+="<td>"+data[row][q].score+"</td>";
				
				html+="</tr>";
			}
			body.innerHTML = html;
			table.appendChild(body);
			// console.log(data);
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

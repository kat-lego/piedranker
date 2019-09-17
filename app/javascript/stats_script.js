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

function fetch_leaderboard_data(id,q){
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
  var e = table.getElementsByTagName("tbody")[0];
  if(e)table.removeChild(e);
  var n = assignmentList[assignid].number_of_questions;
  console.log("flash");
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
          return "Judging in progress";
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
  var e = table.getElementsByTagName("tbody")[0];
  if(e)table.removeChild(e);
  var n = assignmentList[assignid].number_of_questions;
  console.log("flash");
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

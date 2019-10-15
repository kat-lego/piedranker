


/* Set the width of the side navigation to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "25%";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

function fillTitle(){
  var assign = assignmentList[assignid];
  var t =  document.getElementById("h1_title");
  t.innerHTML = assign.name + "</br>" + assign.mode;
}

function fillNav() {
  var type = "leaderboard";
  var type2 = "teamsboard";
  var nav = document.getElementById("mySidenav");
  var h = document.createElement('h2');
  h.innerHTML = assignmentList[assignid].shortname;
  nav.append(h);
  var html = "";
  for (var key in assignmentList) {
    if (assignmentList.hasOwnProperty(key)) {
      var a = document.createElement('span');
      a.id = key;
      a.innerHTML = assignmentList[key].name;
      nav.appendChild(a);
      a.addEventListener("click",function(){
        assignid = this.id;
        var assign = assignmentList[assignid];
        prepareTable(assign.number_of_questions);
        loadLeaderboardData(this.id, type);
        loadLeaderboardData(assignid, type2);
        fillTitle();
      });

    }
  }
}

function prepareTable(n){
  var table = document.getElementById("leaderboard");
  var id = table.id;
  var newt = document.createElement("table");
  newt.id = id;
  newt.className = "content-table";
  table.parentNode.replaceChild(newt, table);
  //add table header
  var head = document.createElement("thead");


  var assign = assignmentList[assignid];
  var html = "";
  if(assign["teamsubmission"]){
    html = "<tr> <th>Rank</th> <th>Team Name</th>";
  }else{
    html = "<tr> <th>Rank</th> <th>Name</th>";
  }
  // console.log(n);
  for(var i =0;i<n;i++){
    html+=" <th> <a href = '../php/stats.php?assignid="+assignid+"&courseid="+courseid+"&question_num="+i+"'>Question"+i+"</a></th> ";
  }
  html+="<th>Total Points</th> </tr>";
  head.innerHTML = html;
  newt.appendChild(head);
}

function loadLeaderboardData(id, type) {
  var assign = assignmentList[assignid];
  if(assign.teamsubmission){
    loadGroupLeaderBoardData(id,type);
    return;
  }


  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      fillLeaderboard(this, type);
    }
  };

  var request = "../php/getleaderboarddata.php?assignid="+id+"&default="+assign.default_score+"&ordering="+assign.ordering+"&numberofquestions="+assign.number_of_questions;
  // console.log(request);
  xhttp.open("GET", request , true);
  xhttp.send();

}

function loadGroupLeaderBoardData(id, type){
  var assign = assignmentList[assignid];
  
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    
    if (this.readyState == 4 && this.status == 200) {
      fillGroupLeaderboard(this, type);
    }
  };

  var request = "../php/getGroupLeaderboardData.php?assignid="+id+"&default="+assign.default_score+"&ordering="+assign.ordering+"&numberofquestions="+assign.number_of_questions;
  console.log(request);
  xhttp.open("GET", request , true);
  xhttp.send();
}

function loadMessageData(id) {
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      fillMessageBoard(this);
    }
  };

  var request = "../php/messaging.php?assignid="+id;
  // console.log(request);
  xhttp.open("GET", request , true);
  xhttp.send();
}

function fillMessageBoard(xhttp){
  var data = JSON.parse(xhttp.responseText);
  console.log(data);
  var messageBoard = document.getElementById("myForm");

  var body = document.getElementById("messageBody");
  var html = "";

  for(row in data){ 
     html+= "<div class='container'> <img src='/w3images/bandmember.jpg' alt='User' style='width:100%;'>";
     html+= "<p>"+data[row].message+"</p>";
     html+= "<span class='time-right'>"+ convertTime(data[row].timestamp) +"</span></div>";
  }
    body.innerHTML = html;
}

function fillLeaderboard(xhttp, type){
  var data = JSON.parse(xhttp.responseText);
  //console.log(data);
  var table = document.getElementById(type);
  var e = table.getElementsByTagName("tbody")[0];
  if(e)table.removeChild(e);
  var n = assignmentList[assignid].number_of_questions;
  //console.log(n);

  //add body
  var body = document.createElement("tbody");
  var html = "";

  var pos =-1;
  var x = null;
  
  if(type == "leaderboard"){
  for(row in data) {
    if(x!=data[row].total_score){
      pos++;
      x = data[row].total_score;
    }

    html+="<tr>";
    html+="<td>"+pos+" </td> ";
    html+="<td>"+data[row].firstname+" "+data[row].lastname+"</td>";

    for(var i=0;i<n;i++){
      html+="<td>"+data[row][i].score+"</td>";
    }
    html+= "<td>"+data[row].total_score;+"</td>";
    html+="</tr>";
  }
  }
  else{
  var countTeamA = 0;
  var countTeamB = 0;
   for(row in data) {
     if(x!= data[row].total_score){
       x += data[row].total_score;
       //var n = str.charCodeAt(0);
       if(data[row].username.charCodeAt(0) < 77 || data[row].username.charCodeAt(0) < 109){
       countTeamA += data[row].total_score;
       }
       else{
       countTeamB += data[row].total_score;
       } 
     }
   }
   
   html+="<tr>";
   // html+="<td>"+pos+" </td> ";
    html+="<td>"+"Blue"+" "+"Team"+"</td>";

    html+= "<td>"+countTeamA;+"</td>";
    html+="</tr>";

     html+="<tr>";
   // html+="<td>"+"1"+" </td> ";
    html+="<td>"+"Red"+" "+"Team"+"</td>";

    html+= "<td>"+countTeamB;+"</td>";
    html+="</tr>";
  // console.log(x);
  }
   body.innerHTML = html;
  table.appendChild(body);
  // console.log(data);
  searchFunction();

}

function fillGroupLeaderboard(xhttp, type){
  var data = JSON.parse(xhttp.responseText);
  console.log(data);
  var table = document.getElementById(type);
  var e = table.getElementsByTagName("tbody")[0];
  if(e)table.removeChild(e);
  var n = assignmentList[assignid].number_of_questions;
  //console.log(n);

  //add body
  var body = document.createElement("tbody");
  var html = "";

  var pos =-1;
  var x = null;
  
  if(type == "leaderboard"){
  for(row in data) {
    if(x!=data[row].total_score){
      pos++;
      x = data[row].total_score;
    }

    html+="<tr>";
    html+="<td>"+pos+" </td> ";
    html+="<td>"+data[row].teamname+"</td>";

    for(var i=0;i<n;i++){
      html+="<td>"+data[row][i].score+"</td>";
    }
    html+= "<td>"+data[row].total_score;+"</td>";
    html+="</tr>";
  }
  }
  else{
  var countTeamA = 0;
  var countTeamB = 0;
   for(row in data) {
     if(x!= data[row].total_score){
       x += data[row].total_score;
       //var n = str.charCodeAt(0);
       if(data[row].username.charCodeAt(0) < 77 || data[row].username.charCodeAt(0) < 109){
       countTeamA += data[row].total_score;
       }
       else{
       countTeamB += data[row].total_score;
       } 
     }
   }
   
   html+="<tr>";
   // html+="<td>"+pos+" </td> ";
    html+="<td>"+"Blue"+" "+"Team"+"</td>";

    html+= "<td>"+countTeamA;+"</td>";
    html+="</tr>";

     html+="<tr>";
   // html+="<td>"+"1"+" </td> ";
    html+="<td>"+"Red"+" "+"Team"+"</td>";

    html+= "<td>"+countTeamB;+"</td>";
    html+="</tr>";
  // console.log(x);
  }
   body.innerHTML = html;
  table.appendChild(body);
  // console.log(data);
  searchFunction();

}

function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}

function searchFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue,j,found;
  input = document.getElementById("searchInput");
  var nameArr =  input.value.toUpperCase().split(":");
  table = document.getElementById("leaderboard");
  tr = table.getElementsByTagName("tr");
  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      found = 0;
      for(j=0;j<nameArr.length;++j){
        if(txtValue.toUpperCase().indexOf(nameArr[j]) > -1){
          tr[i].style.display = "";
          found = 1;
        }
      }
      if(found == 0){
        tr[i].style.display = "none";
      }
    }
  }
}

function convertTime(unixTimestamp) { 
            //var d = new Date();
            var weekday = new Array();
            weekday[0] = "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday"; 

            var month = new Array(12);
            month[0] = "January";
            month[1] = "February";
            month[2] = "March";
            month[3] = "April";
            month[4] = "May";
            month[5] = "June";
            month[6] = "July";
            month[7] = "August";
            month[8] = "September";
            month[9] = "October";
            month[10] = "November";
            month[11] = "December";
  
            // convert to milliseconds 
            // and then create a new Date object 
            dateObj = new Date(unixTimestamp * 1000); 

            //Get date from the timestamp
            date = dateObj.getUTCDate() + 1;

            //Get month from the timestamp
            month = month[dateObj.getUTCMonth()];

            //Get days from the timestamp
            days = weekday[dateObj.getUTCDay()];
  
            // Get hours from the timestamp 
            hours = dateObj.getUTCHours() + 2; 
  
            // Get minutes part from the timestamp 
            minutes = dateObj.getUTCMinutes(); 
  
            // Get seconds part from the timestamp 
            seconds = dateObj.getUTCSeconds(); 
  
            formattedTime = days + ', ' + date + ', ' + month + " " + 
                hours.toString().padStart(2, '0') + ':' + 
                minutes.toString().padStart(2, '0') + ':' + 
                seconds.toString().padStart(2, '0'); 
            
            return formattedTime; 
        } 

/*// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}*/


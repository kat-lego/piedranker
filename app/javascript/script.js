


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
  var nav = document.getElementById("mySidenav");

  for (var key in assignmentList) {
    if (assignmentList.hasOwnProperty(key)) {
      var a = document.createElement('a');
      a.id = key;
      a.setAttribute('href',"#");
      a.innerHTML = assignmentList[key].name;
      nav.appendChild(a);
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
  var html = "<tr> <th>Rank</th> <th>name</th>";
  // console.log(n);
  for(var i =0;i<n;i++){
    html+=" <th>Question"+i+"</th> ";
  }
  html+="<th>Total Points</th> </tr>";
  head.innerHTML = html;
  newt.appendChild(head);
  console.log(html);

}

function loadLeaderboardData(id) {
  
  var assign = assignmentList[assignid];
  prepareTable();
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      fillLeaderboard();
    }
  };

  var request = "getleaderboarddata.php?assignid="+id+"&default="+assign.default_score+"&ordering="+assign.ordering+"$numberofquestions="+assign.number_of_questions;
  xhttp.open("GET", request , true);
  xhttp.send();
 
}

function fillLeaderboard(){
  alert("fillLeaderboard");
}



function searchFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("leaderboard");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}

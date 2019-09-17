


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
        loadLeaderboardData(this.id);
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
  var html = "<tr> <th>Rank</th> <th>Name</th>";
  // console.log(n);
  for(var i =0;i<n;i++){
    html+=" <th> <a href = '../php/stats.php?assignid="+assignid+"&courseid="+courseid+"&question_num="+i+"'>Question"+i+"</a></th> ";
  }
  html+="<th>Total Points</th> </tr>";
  head.innerHTML = html;
  newt.appendChild(head);
}

function loadLeaderboardData(id) {

  var assign = assignmentList[assignid];
  
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      fillLeaderboard(this);
    }
  };

  var request = "../php/getleaderboarddata.php?assignid="+id+"&default="+assign.default_score+"&ordering="+assign.ordering+"&numberofquestions="+assign.number_of_questions;
  // console.log(request);
  xhttp.open("GET", request , true);
  xhttp.send();

}

function fillLeaderboard(xhttp){
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
    
    for(var i=0;i<n;i++){
      html+="<td>"+data[row][i].score+"</td>";
    }
    html+= "<td>"+data[row].total_score;+"</td>"
    html+="</tr>";
  }
  body.innerHTML = html;
  table.appendChild(body);
  // console.log(data);
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


<?PHP
error_reporting(0);

session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}

$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];

if (isset($_POST['logoff'])){
	session_destroy();
	setcookie("remember", "", time()-3600);
	header("location:../incnet/login.php");	
}

include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}
mysql_select_db("incnet");
mysql_set_charset("utf8");

$permit_query = mysql_query("SELECT * FROM incnet.corepermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}

$teacher_query = mysql_query("SELECT student_id FROM incnet.coreusers WHERE user_id='$user_id'");
while($teacher_row = mysql_fetch_array($teacher_query)){
	$student_id = $teacher_row['student_id'];
}

if (!(in_array("701", $allowed_pages))){
	header("location:index.php");
	die();
}

$array = array();

$friday = date("Y-m-d", strtotime ("next friday"));
$saturday = date("Y-m-d", strtotime("next saturday"));
$sunday = date("Y-m-d", strtotime ("next sunday"));

$sql = "SELECT coreusers.name, coreusers.user_id, coreusers.lastname, coreusers.class, coreusers.dormroom, coreusers.student_id, etut_defaultseats.room, etut_defaultseats.seat, weekenddepartures.dep_bus_id, weekenddepartures.arr_bus_id, weekenddepartures.leave_id, weekenddepartures.leave_group, weekenddepartures.dep_date, weekenddepartures.arr_date FROM coreusers, etut_defaultseats, weekenddepartures WHERE coreusers.user_id=etut_defaultseats.user_id AND coreusers.user_id=weekenddepartures.user_id AND (coreusers.class='Prep' OR coreusers.class='9' OR coreusers.class='10' OR coreusers.class='11IB' OR coreusers.class='11MEB' OR coreusers.class='12IB' OR coreusers.class='12MEB') AND type LIKE 'student' UNION SELECT coreusers.name, coreusers.user_id, coreusers.lastname, coreusers.class, coreusers.dormroom, coreusers.student_id, etut_defaultseats.room, etut_defaultseats.seat, '', '', '', '', '', '' FROM coreusers, etut_defaultseats WHERE coreusers.user_id=etut_defaultseats.user_id AND (coreusers.class='Prep' OR coreusers.class='9' OR coreusers.class='10' OR coreusers.class='11IB' OR coreusers.class='11MEB' OR coreusers.class='12IB' OR coreusers.class='12MEB') AND type LIKE 'student' AND coreusers.student_id NOT IN (SELECT coreusers.student_id FROM coreusers, weekenddepartures WHERE coreusers.user_id = weekenddepartures.user_id) ORDER BY lastname ASC";

$result = mysql_query($sql);

if(!$result)
{
  die("mysql failed:" . mysql_error());
}
//echo "before while !!";

$knownUserIds = array();

while($row = mysql_fetch_array($result))
{
	$fri_dorm = "Present";
  $sat_dorm = "Present";
  $sat_etut = "Present";
  $array["weekend"] = "";
  $array["dep_day"] = "";
  $array["dep_bus"] = "";
  $array["arr_day"] = "";
  $array["arr_bus"] = "";
        
  //echo "in while !!";
  $array["name"] = $row["name"] . " " . $row["lastname"];
  
  //echo $row["name"];
  $array["class"] = $row["class"];
  $array["dorm"] = $row["dormroom"];
  $array["id"] = $row["student_id"];
  $array["etut"] = $row["room"] . " " . $row["seat"];
  $leave_group = $row["leave_group"];
  $leave_id = $row["leave_id"];
  if($leave_group == 1)
  {
    ////dep date i bo? tan?mla
    switch($leave_id)
    {
      case 1: $array["weekend"] = "Gebze Center Friday"; break;
      case 2: $array["weekend"] = "Gebze Center Saturday"; break;
      case 3: $array["weekend"] = "Gebze Center Sunday"; break;
      case 4: $array["weekend"] = "Kadıköy";
      				$array["dep_day"] = $row["dep_date"];
							$array["dep_bus"] = $row["dep_bus"];
							$array["arr_day"] = $row["arr_date"];
							$array["arr_bus"] = $row["arr_bus"];
							break;
    } 
  }
  if(($leave_group==2)||($leave_id==4))
  {
    $array["dep_day"] = $row["dep_date"];
    $array["arr_day"] = $row["arr_date"];
    
	//Ideally these wold look up from the DB, wontfix.
	
	switch($row[8])
    {
      case 1: $array["arr_bus"] = "Taxi/Cab"; break;
      case 2: $array["arr_bus"] = "Kadıköy"; break;
      case 3: $array["arr_bus"] = "Family"; break;
      case 4: $array["arr_bus"] = "Gebze-Terminal"; break;
      case 5: $array["arr_bus"] = "Gebze Station"; break;
      case 6: $array["arr_bus"] = "Gebze-Eskihisar"; break;
      case 7: $array["arr_bus"] = "Kocaeli"; break;
      case 8: $array["arr_bus"] = "Kartal-Underground"; break;
      case 9: $array["arr_bus"] = "Friend"; break;
      case 10: $array["arr_bus"] = "Dershane"; break;
    }
    switch($row[7])
    {
      case 1: $array["dep_bus"] = "Taxi/Cab"; break;
      case 2: $array["dep_bus"] = "Kadıköy"; break;
      case 3: $array["dep_bus"] = "Family"; break;
      case 4: $array["dep_bus"] = "Gebze-Terminal"; break;
      case 5: $array["dep_bus"] = "Gebze Station"; break;
      case 6: $array["dep_bus"] = "Gebze-Eskihisar"; break;
      case 7: $array["dep_bus"] = "Kocaeli"; break;
      case 8: $array["dep_bus"] = "Kartal-Underground"; break;
      case 9: $array["dep_bus"] = "Friend"; break;
      case 10: $array["dep_bus"] = "Dershane"; break;
    }
    
    if($leave_group==2)
    {
		  $array["weekend"] = "Home";
		  
		  if(date("l", strtotime($row["dep_date"]))=="Friday")
		  {
		    if($row["arr_date"]!=$row["dep_date"]){
		      $fri_dorm = "Absent";
		      $sat_etut = "Absent"; 
		    }  
		    if(date("l", strtotime($row["arr_date"]))!="Saturday")
		    {
		      $fri_dorm = "Absent";
		      $sat_etut = "Absent";
		      $sat_dorm = "Absent";
		    }
		  }
    }
    if ((date("l", strtotime($row["dep_date"]))=="Saturday")&&($row["arr_date"]!=$row["dep_date"]))
    {
      $sat_etut = "Absent";
      $sat_dorm = "Absent";   
    }         
  }
  
  $sql2 = "SELECT departure_time, return_time, event_date FROM checkinevents WHERE checkinjoins.user_id ='" . $row["user_id"] . "' AND checkinjoins.event_id = checkinevents.event_id AND checkinevents.event_date > " . $friday . " AND checkinevents.event_date < " . $sunday;
  $result2 = mysql_query($sql2);

  while($row2 = mysql_fetch_array($result2, MYSQL_BOTH))
  {
      if(($row2["event_date"] == $friday)&&($row2["return_time"]>"22:00"))
      {
          $fri_dorm = "Will arive after 22.00";
      }
      if($row2["event_date"]== date("Y-m-d" ,strtotime("next saturday"))){
          if(($row2["departure_time"]<"11:00")&&($row2["return_time"]>"13:00"))
          {
              $sat_etut = "Absent";
          }
          if(($row2["departure_time"]<"22:00")&&($row2["return_time"]>"22:00"))
          {
              $sat_dorm = "Will arrive after 22.00";
          }
      }
  }
 /* $eleven_nonib = array("207", "209", "211", "214", "215", "221", "224", "225", "232", "233", "246", "247", "239");
  if( ($array["class"] == "12") || (in_array($array["id"], $eleven_nonib)) )
  {
  	$sat_etut = "0";
  }*/
  
  $array["fri_dorm"] = $fri_dorm;
  $array["sat_dorm"] = $sat_dorm;
  $array["sat_etut"] = $sat_etut;
	
	if(array_search($array['id'], $knownUserIds) == -1){
		$json[] = array($array);
		$knownUserIds[] = $array['id'];
	}
	else $json[$array['id']][] = $array;
  unset($array);
}
//$json = json_encode($json); //Again, sorry for doing this. Code too dirty to clean up...
//echo "HERE!!!!!".count($array);

?>
<!DOCTYPE html>
<HTML>
<head>
	<title>Inçnet | Weekend Departures</title>
	<link rel="shortcut icon" href="favicon.ico" >
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<style>
		td
		{
			border: 1px solid black;
			border-collapse: collapse;
			padding: 3px;
			text-align: left;
		}
		tr
		{
			border-collapse: collapse;
		}
		table
		{
			border-collapse: collapse;   
		}
    .print_img
    {
      max-height: 110px;
      float:right;
    }
    .print
    {
      float: right;
      position: relative;
    }
    .main
    {
    	font-weight: bold;
    	font-size: 2em;
    	width: 100%;
    	text-align: center;
    }
    #print
    {
    	float: right;
    	padding: 5px;
    	font-size: 1.2em;
    	position: relative;
    	top: -50px;
    }
    #sortAndSelect
    {
    	text-align: left;
    }
	</style>
</head>
<body ng-app="myApp" ng-controller='tableCont as people'>
	<table style='border: 0px solid black;'>
		<tr style="border:0px solid purple;">
			<td colspan='11' style="border:0px solid purple; text-align: center;">
				<span class='main'>TEV İnanç Türkeş Özel Lisesi</span>
				<br>
				<div id="sortAndSelect">
					<input type='text' name='filter' placeholder='Search' ng-model='people.searchKey'>
					<br>
					<select name='sort' ng-model='people.sortKey'>
						<option value='name'>Name</option>
						<option value='dorm'>Dormroom</option>
						<option value='class'>Class</option>
						<option value='etut'>Etut</option>
						<option value='weekend'>Departure Type</option>
						<option value='dep_day'>Departure Date</option>
						<option value='dep_bus'>Departure Bus</option>
						<option value='arr_day'>Arrival Date</option>
						<option value='arr_bus'>Arrival Bus</option>
						<option value='fri_dorm'>Friday Dorm</option>
						<option value='sat_dorm'>Saturday Dorm</option>
						<option value='sat_etut'>Saturday Etut</option>
					</select>
					<br>
					<input type='text' name='filter2' placeholder='Search' ng-model='people.searchKey2'>
					<br>
					<select name='sort' ng-model='people.sortKey2'>
						<option value='name'>Name</option>
						<option value='dorm'>Dormroom</option>
						<option value='class'>Class</option>
						<option value='etut'>Etut</option>
						<option value='weekend'>Departure Type</option>
						<option value='dep_day'>Departure Date</option>
						<option value='dep_bus'>Departure Bus</option>
						<option value='arr_day'>Arrival Date</option>
						<option value='arr_bus'>Arrival Bus</option>
						<option value='fri_dorm'>Friday Dorm</option>
						<option value='sat_dorm'>Saturday Dorm</option>
						<option value='sat_etut'>Saturday Etut</option>
					</select>
				</div>
				<button id='print' onclick='printWindow()'>Print</button>
			</td>
			<td colspan='2' style="border:0px solid purple;">
			   <img src="../img/incnetWhite.png" class="print_img">		
			</td>
		</tr>
		<tr style='height:20px'>
		<td><b>No</b></td>
		<td><b>Name</b></td>
		<td><b>Dormroom</b></td>
		<td><b>Class</b></td>
		<td><b>Etut</b></td>
		<td><b>Friday</b></td>
		<td><b>Saturday</b></td>
		<td><b>Sunday</b></td>
		<td><b>Departure Type</b></td>
		<td><b>Departure Date</b></td>
		<td><b>Departure Bus</b></td>
		<td><b>Arrival Date</b></td>
		<td><b>Arrival Bus</b></td>
		<td><b>Fri. Dorm</b></td>
		<td><b>Sat. Dorm</b></td>
		<td><b>Sat. Etut</b></td>
		</tr>
<?php
//$json is used here but is not actually json-encoded. Sorry, code too dirty to clean up. I would appreciate help though :) (Just don't break anything please...)
if(false) highlight_string("<?php\n\$data =\n" . var_export($json, true) . ";\n?>"); //Can't comment out due to the closephp tag (is that what it's called?) in there
foreach($json as $studentArr){
	$student = $studentArr[0];
	foreach($studentArr as $ranOutOfNames){
		if($ranOutOfNames['dep_day'] == $ranOutOfNames['arr_day'] && $ranOutOfNames['weekend'] != "Home"){
			switch(strtolower(substr($ranOutOfNames['weekend'], 12))){
				case "friday":
					$fridayLeave = $ranOutOfNames['weekend'];
					break;
				case "sunday":
					$sundayLeave = $ranOutOfNames['weekend'];
					break;
				case "saturday":
					$saturdayLeave = $ranOutOfNames['weekend'];
					break;
			}
			//echo substr($ranOutOfNames['weekend'], 12);
			var_dump($fridayLeave);
		}
	}
	echo "			<tr>
				<td>$student[id]</td>
				<td>$student[name]</td>
				<td>$student[dorm]</td>
				<td>$student[class]</td>
				<td>$student[etut]</td>
				<td>$fridayLeave</td>
				<td>$saturdayLeave</td>
				<td>$sundayLeave</td>
				<td>$student[weekend]</td>
				<td>$student[dep_day]</td>
				<td>$student[dep_bus]</td>
				<td>$student[arr_day]</td>
				<td>$student[arr_bus]</td>
				<td>$student[fri_dorm]</td>
				<td>$student[sat_dorm]</td>
				<td>$student[sat_etut]</td>
			</tr>";
			unset($fridayLeave, $saturdayLeave, $sundayLeave);
} ?>
	</table>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
	<script>/*
		app = angular.module("myApp", [])
						.controller("tableCont", controller)
						.filter("searchOne", searchOne);
		function controller()
		{
			this.list = <?=$json?>;
			this.sortKey = "name";
			this.searchKey = "";
		}
		
		function searchOne()
		{
			//console.log("filter");
			return function(array, searchKey, sortKey)
			{
				//console.log("func");
				//console.log("search:"+searchKey);
				newArray = new Array();
				array.forEach(function(val, ind, arr)
				{
					//console.log("index:"+ind);
					console.log("sort:"+sortKey);
					console.log(val);
					searchVal = val[sortKey].toString().toLowerCase();
					//console.log("val:"+searchVal.indexOf());
					if(searchVal.indexOf(searchKey.toLowerCase())>-1)
					{
						//console.log("found");
						newArray.push(val);
					}
				});
				return newArray.sort(function(a,b)
				{
					str1 = a[sortKey].toString();
					str2 = a[sortKey].toString();
					return str1.localeCompare(str2);
				});
			}
		}
		*/
		function printWindow()
		{
			document.getElementById("sortAndSelect").style.display = "none";
			window.print();
			document.getElementById("sortAndSelect").style.display = "block";
		}
	</script>
</body>
</HTML>
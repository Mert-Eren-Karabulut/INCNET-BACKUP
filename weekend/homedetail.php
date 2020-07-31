<?PHP


/*
require_once '../mobile_detect/Mobile_Detect.php';
$detect = new Mobile_Detect;
if ( $detect->isMobile() ) {
  echo	"<meta http-equiv='refresh' content='0; url=../incnetv2/mobile/weekend.php'>"; 
}
*/
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

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}

$teacher_query = mysql_query("SELECT student_id FROM incnet.coreUsers WHERE user_id='$user_id'");
while($teacher_row = mysql_fetch_array($teacher_query)){
	$student_id = $teacher_row['student_id'];
}

//current date
$dnoweek = date(w);
if ($dnoweek==0) {$dnoweek=7;}
$pdnfmon = 8-$dnoweek;
$pdnff = 5-$dnoweek;
$pdnfsat = 6-$dnoweek;
$pdnfsun = 7-$dnoweek;
$monday = date('d-m-F-Y', strtotime("+" . $pdnfmon . " days"));
$monday = explode("-", $monday);
$friday = date('d-m-F-Y', strtotime("+" . $pdnff . " days"));
$friday = explode("-", $friday);
$saturday = date('d-m-F-Y', strtotime("+" . $pdnfsat . " days"));
$saturday = explode("-", $saturday);
$sunday = date('d-m-F-Y', strtotime("+" . $pdnfsun . " days"));
$sunday = explode("-", $sunday);
$mondayoty = $monday[3] . "-" . $monday[1] . "-" . $monday[0];
$fridayoty = $friday[3] . "-" . $friday[1] . "-" . $friday[0];
$saturdayoty = $saturday[3] . "-" . $saturday[1] . "-" . $saturday[0];
$sundayoty = $sunday[3] . "-" . $sunday[1] . "-" . $sunday[0];
?>
<!DOCTYPE html>
<HTML>
<head>
<link rel="shortcut icon" href="favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
</head>
<body>
<script>
function editDropDep() {
	depdate = document.getElementById("depdate");
	depbus = document.getElementById("depbus");
	fridayOty = "<?php echo $fridayoty;?>";
	saturdayOty = "<?php echo $saturdayoty;?>";
	sundayOty = "<?php echo $sundayoty;?>";
	if (typeof oldDropDep === 'undefined'){
		oldDropDep = depbus.innerHTML;
	}
	if (depdate.value == saturdayOty){
		depbus.options.length = 0;
		depbus.options[depbus.options.length] = new Option("Taxi/Cab", "1");
		depbus.options[depbus.options.length] = new Option("Family", "3");
		depbus.options[depbus.options.length] = new Option("Friend", "9");
		depbus.options[depbus.options.length] = new Option("Dershane", "10");
		document.getElementById("output").value = "asdfgh";
	} else if (depdate.value == sundayOty){
		depbus.options.length = 0;
		depbus.options[depbus.options.length] = new Option("Taxi/Cab", "1");
		depbus.options[depbus.options.length] = new Option("Kadıköy", "2");
		depbus.options[depbus.options.length] = new Option("Family", "3");
		depbus.options[depbus.options.length] = new Option("Friend", "9");
		depbus.options[depbus.options.length] = new Option("Dershane", "10");
		document.getElementById("output").value = "asd";
	} else if (depdate.value == fridayOty){
		depbus.options.length = 0;
		depbus.innerHTML = oldDropDep;
	}
}

function editDropArr() {
	arrdate = document.getElementById("arrdate");
	arrbus = document.getElementById("arrbus");
	fridayOty = "<?php echo $fridayoty;?>";
	saturdayOty = "<?php echo $saturdayoty;?>";
	sundayOty = "<?php echo $sundayoty;?>";
	if (typeof oldDropArr === 'undefined'){
		oldDropArr = arrbus.innerHTML;
	}
	if ((arrdate.value == fridayOty)||(arrdate.value == saturdayOty)){
		arrbus.options.length = 0;
		arrbus.options[arrbus.options.length] = new Option("Taxi/Cab", "1");
		arrbus.options[arrbus.options.length] = new Option("Family", "3");
		arrbus.options[arrbus.options.length] = new Option("Friend", "9");
		arrbus.options[arrbus.options.length] = new Option("Dershane", "10");
	} else if (arrdate.value == sundayOty){
		arrbus.options.length = 0;
		arrbus.innerHTML = oldDropArr;
	}
}
</script>
	<div class="top_menubar">
	<?PHP echo $fullname; ?>
	</div>
<br><br>
<div class="page_logo_container">
<table><tr>
<td><a href="index.php"><img src="weekend.png" id="a" width="120px" border=0 /></a><br>
</td>
<td width="5px"></td>
<td bgcolor="black" width=0.1px>
<td width="3px"></td>
<td valign="middle">
<h3>Weekend Departures Page</h3>

<form method='POST'><table><tr>
<td width='150px'>Departure Time:</td><td>
<select name='selectdepdate' id="depdate" onChange='editDropDep()' style='width:175px;'>
<?

//date dropdowns
echo "
<!--<option value='2015-04-30'>30 April 2015</option>-->
<option value=" . $fridayoty . ">" . $friday[0] . " " . $friday[2] . " " . $friday[3] . " </option>
<option value=" . $saturdayoty . ">" . $saturday[0] . " " . $saturday[2] . " " . $saturday[3] . " </option>
<option value=" . $sundayoty . ">" . $sunday[0] . " " . $sunday[2] . " " . $sunday[3] . " </option></select></td></tr>
<tr><td>Arrival Time:</td><td>
<select name='selectarrdate' id='arrdate' onChange='editDropArr()' style='width:175px;'>
<option value=" . $fridayoty . ">" . $friday[0] . " " . $friday[2] . " " . $friday[3] . " </option>
<option value=" . $saturdayoty . ">" . $saturday[0] . " " . $saturday[2] . " " . $saturday[3] . " </option>
<option selected='yes' value=" . $sundayoty . ">" . $sunday[0] . " " . $sunday[2] . " " . $sunday[3] . " </option>
<option value=" . $mondayoty . ">" . $monday[0] . " " . $monday[2] . " " . $monday[3] . "</option>
</select></td></tr>"; ?>
<tr><td>Departure Bus:</td><td>
<select name='selectbusf' id='depbus' style='width:175px;'>
<?PHP

//bus dropdown from database
$sql1 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE direction=0 OR direction=2");
 while($row1 = mysql_fetch_array($sql1)){
 	$bus_idf = $row1['bus_id'];
 	$bus_namef = $row1['bus_name'];
 	echo "<option value='" . $bus_idf . "'>" . $bus_namef . "</option>
 	";
 }
?>

</select><br></td></tr><tr><td>
Arrival Bus:</td><td>
<select name='selectbust' id='arrbus' style='width:175px;'>
<?PHP

//bus dropdown from database
$sql3 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE direction=1 OR direction=2");
 while($row3 = mysql_fetch_array($sql3)){
 	$bus_idt= $row3['bus_id'];
 	$bus_namet = $row3['bus_name'];
 	echo "<option value='" . $bus_idt . "'>" . $bus_namet . "</option>
 	";
 }
?>
</select><br></td></tr></table>
<input type='submit' value='Submit' name='submit_departure'></form>
<?

//new departure variables
$new_dep_date = $_POST['selectdepdate'];
$new_arr_date = $_POST['selectarrdate'];
$new_bus_idf = $_POST['selectbusf'];
$new_bus_idt = $_POST['selectbust'];
$sql2 = mysql_query("SELECT * FROM incnet.weekendLeaves WHERE leave_id='5'");
while($row2 = mysql_fetch_array($sql2)){
	$new_leave_group = $row2['leave_group'];
}

if (isset($_POST['submit_departure'])){

	//old departure query
	$sql8 = mysql_query("SELECT * FROM incnet.weekendDepartures WHERE user_id ='$user_id'") or die (mysql_error());
	while($row8 = mysql_fetch_array($sql8)){
		$old_dep_date = $row8['dep_date'];
		$old_arr_date = $row8['arr_date'];
		$old_leave_group = $row8['leave_group'];
		
		//check time and group
		if ($new_leave_group != $old_leave_group){
			if (($old_dep_date > $new_arr_date)||($old_arr_date < $new_dep_date)){
				$time_error = 0;}
			else {
				$time_error = 1;}
		}
		else {
			$insame_group = 1;
		}
	}
	
	//block coming before going 
	if ($new_arr_date < $new_dep_date){
		echo "<hr>How can you arrive before you leave?";
	}
	else {
	
		//stop or insert
		if ($time_error==1){
				echo "
				<hr>You can't save your departure because your other departure overlaps with this one.<br>";
		}
		else if ($insame_group == 1){
			echo "
			<hr>I'm sorry Dave. I'm afraid I can't let you do that.<br>";
		}
		else {
			mysql_query("INSERT INTO incnet.weekendDepartures VALUES ('NULL', $user_id, $new_bus_idf, $new_bus_idt, '5', '$new_dep_date', '$new_arr_date', $new_leave_group, '1')");
			//header("location:index.php");
			echo "<script>window.location = 'index.php';</script>";
		} 
	}
}
?>
<br>
</td>
</tr></table>
</div>
<br><br><br>
<div class="logoff_button">
<form name="logoff" method="POST">
<input type ="submit" name="logoff" value="Log Off">
</form></div>
<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2012 INCNET</a>
</div>
</body>
</HTML>

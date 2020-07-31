<?PHP

require_once '../mobile_detect/Mobile_Detect.php';
$detect = new Mobile_Detect;
if (!($detect->isMobile())){
	header("location:../../weekend");
} 
session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:login.php");
}

$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];

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

<!doctype html>
<html>
<head>
				<title>Inçnet</title>
		<link rel='shortcut icon' href='favicon.ico' >
		<meta charset='UTF-8'>
		<link rel='stylesheet' href='style.css' type='text/css' media='screen'  title='no title' charset='utf-8'>
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
s
<style>
body {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	font-size: 14px;
}


form { margin: 0; }  



.default_font{
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	font-size: 12pt;
}

a {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	color: white;
}


.mobilebutton {
	color:white;
	background:#c1272d ;
	width:100%;
	left:0%;
	height:100px; 
	font-size: 35pt;
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	text-shadow:5px 5px 7px black;
	box-shadow:6px 6px 5px black;
	border:1;
	position:relative;
	-webkit-appearance: none;
}
.mobileimage{
	position:relative;
	display:block;
	margin-left: auto;
	margin-right: auto;
	margin-top:130px;
	height:500px;
}

.header {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	z-index:1;
	font-size:38pt;
	position: fixed;
	width: 100%;
	padding-bottom:14px;
	padding-top:14px;
	color: white;
	left: 0px;
	background-color: #c1272d;
	top: 0px;
	text-align:right;
}



.mobilepart{
	width:100%;height:90%
}

#bottomButton{
	top:220px;
	margin-bottom:100px;
	color:white;
}
.Weekend{
	font-size:35pt;
	width:90%;
	display:block;
	margin-left:auto;
	margin-right:auto;
	color:#c1272d;
	font-weight:bold;
}
.etutButton{

	color:white;
	background:#c1272d ;
	width:30%;
	float:right;
	height:100px; 
	font-size: 35pt;
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	text-shadow:5px 5px 7px black;
	box-shadow:6px 6px 5px black;
	border:1;
	position:relative;
	margin-top:20px;
	margin-bottom:70px;
}
.WeekendSelect{
	color:#c1272d;
	background:white;
	font-weight:bold;
	width:50%;
	float:right;
	height:80px;
	font-size:30pt;
	box-shadow:6px 6px 5px black;
	border:1;
	margin-top:-10px;
	margin-bottom:0px;
	-webkit-appearance: none;
}

.taplogoff{
	color:white;
	opacity:0.5;
	text-align:left;
	position:absolute;
}
</style>	
</head>
<body>
		<a href='logoff.php'>
			<div class="header"><div class='taplogoff'>&nbsp; Tap to log off</div>
				<? echo $fullname; ?> 	&nbsp;	
			</div>	
		</a>	
	<a href="index.php"> <img src="../../incnet/incnet.png" class="mobileimage"> </a><br><br>
	<div class="Weekend"><br>
	<?

//date dropdowns
echo "
Departure Time:
<select name='selectdepdate' id='depdate' onChange='editDropDep()' class='WeekendSelect'>
<option value=" . $fridayoty . ">" . $friday[0] . " " . $friday[2] . " " . $friday[3] . " </option>
<option value=" . $saturdayoty . ">" . $saturday[0] . " " . $saturday[2] . " " . $saturday[3] . " </option>
<option value=" . $sundayoty . ">" . $sunday[0] . " " . $sunday[2] . " " . $sunday[3] . " </option></select><br><br><br>
Arrival Time:
<select name='selectarrdate' id='arrdate' onChange='editDropArr()'  class='WeekendSelect'>
<option value=" . $fridayoty . ">" . $friday[0] . " " . $friday[2] . " " . $friday[3] . " </option>
<option value=" . $saturdayoty . ">" . $saturday[0] . " " . $saturday[2] . " " . $saturday[3] . " </option>
<option selected='yes' value=" . $sundayoty . ">" . $sunday[0] . " " . $sunday[2] . " " . $sunday[3] . " </option>
<option value=" . $mondayoty . ">" . $monday[0] . " " . $monday[2] . " " . $monday[3] . "</option>
</select><br><br><br>"; ?>
Departure Bus:
<select name='selectbusf' id='depbus'  class='WeekendSelect'>
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

</select><br><br><br>
Arrival Bus:
<select name='selectbust' id='arrbus'  class='WeekendSelect'>
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
</select><br><br><br>
<input type='submit' value='Submit' name='submit_departure' class='mobilebutton'></form>
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
			echo "<script>window.location = 'weekend.php';</script>";
		} 
	}
}
?>
</div>

</body>
</html>

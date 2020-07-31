<?PHP

require_once '../mobile_detect/Mobile_Detect.php';
$detect = new Mobile_Detect;
if (!($detect->isMobile())){
	header("location:../../weekend");
} 
session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}

$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];

include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}

$teacher_query = mysql_query("SELECT student_id FROM incnet.coreUsers WHERE user_id='$user_id'");
while($teacher_row = mysql_fetch_array($teacher_query)){
	$student_id = $teacher_row['student_id'];
}
//remove departure from database
if(isset($_POST['remove_permit'])){
	$remove_leave_id = $_POST['departure_to_remove'];
	mysql_query("DELETE FROM incnet.weekendDepartures WHERE leave_id=$remove_leave_id AND user_id=$user_id");
}


//current date
$week_name = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
$dnwh = date('H-i');
$dnoweek = date(w);
if ($dnoweek==0) {$dnoweek=7;}
$dnwh = array($dnoweek, $dnwh);
$dnwh = implode("-", $dnwh);
$pdnfmon = 1-$dnoweek;
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
$dep_arr_days = array($fridayoty, $saturdayoty, $sundayoty);
?>
<!doctype html>
<html>
<head>
				<title>Inçnet</title>
		<link rel='shortcut icon' href='favicon.ico' >
		<meta charset='UTF-8'>
		<link rel='stylesheet' href='style.css' type='text/css' media='screen'  title='no title' charset='utf-8'>
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



.mobilebutton {
	color:white;
	background:#c1272d ;
	width:94%;
	left:3%;
	height:100px; 
	font-size: 35pt;
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	text-shadow:5px 5px 7px black;
	box-shadow:6px 6px 5px black;
	border:1;
	position:relative; 
    	 -webkit-appearance: none;
}

.mobilepart{
	width:100%;height:90%
}

#bottomButton{
	top:220px;
	margin-bottom:100px;
	color:white;
}
.etut{
	font-size:35pt;
	width:90%;
	display:block;
	margin-left:auto;
	margin-right:auto;
	color:#c1272d;
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
	border-radius:7px;
	box-shadow:6px 6px 5px black;
	border:1;
	position:relative;
	margin-top:20px;
	margin-bottom:70px;
}
.etutSelect{
	color:#c1272d;
	background:white;
	font-weight:bold;
	width:65%;
	float:left;
	height:100px;
	font-size:35pt;
	border-radius:7px;
	box-shadow:6px 6px 5px black;
	border:1;
	margin-top:20px;
	margin-bottom:70px;

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
	<a href='index.php'><img src='../../incnet/incnet.png' class='mobileimage'></a>
	<div class='etut'>
<?PHP

//vars from db

$sql8 = mysql_query("SELECT * FROM incnet.weekendVars");
while ($row8 = mysql_fetch_array($sql8)){
	$var_id[] = $row8['var_id'];
	$var_value[] = $row8['value'];
}

$state = $var_value[0];
$deadline = $var_value[1];


if($state == '1'){
	if ($dnwh < $deadline){
	
		//leave dropdown from database
		echo "
		<br>
		<b>Please select where you would like to go:</b><br><br>
		<form method='POST'>
		<select name='selectleave' class='etutSelect'>";
		$sql1 = mysql_query("SELECT * FROM incnet.weekendLeaves");
		while($row1 = mysql_fetch_array($sql1)){
		$selected_value = $_POST['selectleave'];
			if ($row1['leave_id'] != 5){
				$leave_id = $row1['leave_id'];
				$leave_day_number = $row1['leave_day_number'] - 1;
				$leave_day = $week_name[$leave_day_number];
				$leave_displayname = $row1['leave_name'] . " - " . $leave_day;
				$sql5 = mysql_query("SELECT * FROM incnet.weekendstudentperms WHERE student_id='$user_id' AND leave_id='$leave_id'");
				while ($row5 = mysql_fetch_array($sql5)){
					if ($selected_value==$leave_id){
						echo "
						<option selected='" . "yes" . "' value='" . $leave_id . "'>" . $leave_displayname . "</option>";
					} else {
						echo "
						<option value='" . $leave_id . "'>" . $leave_displayname . "</option>";	
					}
				}
			}
		}
		echo "
		<option value='5'>Home</option>
		</select>
		<input type='submit' value='Submit' class='etutButton'>
		</form><br>";		
		
//////////////////////////////////////////////////////////////		//directing homedetail
		if ($selected_value == '5'){
		echo "<meta http-equiv='refresh' content='0; url=homedetail.php'>";
		//header("location:homedetail.php");
		}
		//new departure query
		$sql2 = mysql_query("SELECT * FROM incnet.weekendLeaves WHERE leave_id=$selected_value");
		while ($row2 = mysql_fetch_array($sql2)){
			$new_dep_day = $row2['leave_day_number'] - 5;
			$new_dep_date = $dep_arr_days[$new_dep_day];
			$new_leave_group = $row2['leave_group'];
			$new_bus_id = $row2['bus_id'];
		}
	
		//old departure query
		$sql3 = mysql_query("SELECT * FROM incnet.weekendDepartures WHERE situation=1 AND user_id=$user_id");
		while ($row3 = mysql_fetch_array($sql3)){
			$old_leave_id = $row3['leave_id'];
			$old_dep_date = $row3['dep_date'];
			$old_arr_date = $row3['arr_date'];
			$old_leave_group = $row3['leave_group'];
												
			//check time and group
			if ($new_leave_group != $old_leave_group){
				if (($old_dep_date > $new_dep_date)||($old_arr_date < $new_dep_date)){
					$time_error = 0;}
				else {
					$time_error = 1;}
			}
			else {
				$insame_group = 1;
			}
		}
	
		//stop or insert
		if ((isset($selected_value))&&($selected_value != '5')){
			if ($time_error==1){
				echo "
				You can't save your departure because your other departure overlaps with this one.<br><br>";
			}
			else if ($insame_group == 1){
				echo "
				I'm sorry Dave. I'm afraid I can't let you do that.<br><br>";
			}
			else {
			//In the query below, the arrival date is the same with the departure because the departures that can be saved in index.php are one-day departures. Therefore, $new_dep_date is used twice.
			mysql_query("INSERT INTO incnet.weekendDepartures VALUES ('NULL', '$user_id', '$new_bus_id', '$new_bus_id', $selected_value, '$new_dep_date', '$new_dep_date', $new_leave_group, '1')") or die(mysql_error());
			header("location:weekend.php");
			} 
		}
	}
	else {
		$disabled = "disabled";
		echo "
		<br>
		Sorry, You can't fill the form.<br><br>";
	}

	//variables and array of display
	$sql6 = mysql_query("SELECT * FROM incnet.weekendDepartures WHERE user_id=$user_id");
	while ($row6 = mysql_fetch_array($sql6)){
		$disp_bus_id = $row6['dep_bus_id'];
		$disp_arr_bus_id = $row6['arr_bus_id'];
		$sql0 = mysql_query("SELECT * FROM incnet.weekendBuses");
		while ($row0 = mysql_fetch_array($sql0)){
			if ($disp_bus_id == $row0['bus_id']){
				if ($disp_bus_id == 1){
					$disp_bus_name = " by <b>" . $row0['bus_name'];
				} else if ($disp_bus_id == 3){
					$disp_bus_name = " with <b>" . $row0['bus_name'];
				} else {
					$disp_bus_name = " by <b>" . $row0['bus_name'] . " Bus";
				}
			}
			if ($disp_arr_bus_id == $row0['bus_id']){	
				if ($disp_arr_bus_id == 1){
					$disp_arr_bus_name = " by <b>" . $row0['bus_name'];
				} else if ($disp_arr_bus_id == 3){
					$disp_arr_bus_name = " with <b>" . $row0['bus_name'];
				} else {
					$disp_arr_bus_name = " by <b>" . $row0['bus_name'] . " Bus";
				}
			}
		}
		$disp_leave_id = $row6['leave_id'];
		$disp_dep_date = $row6['dep_date'];
		$disp_arr_date = $row6['arr_date'];
		$disp_sit = $row6['situation'];
		$sql4 = mysql_query("SELECT * FROM incnet.weekendLeaves WHERE leave_id=$disp_leave_id");
		while ($row4 = mysql_fetch_array($sql4)){
			//determining the name of the arrival date
			$disp_arr_date_day_name = date(l, strtotime($disp_arr_date));
			if ($disp_leave_id != '5'){
				$disp_leave_day = $row4['leave_day_number'] - 1;
				$disp_leave_name = $row4['leave_name'] . "</b> on <b>" . $week_name[$disp_leave_day];
			}
			else if ($disp_dep_date == $fridayoty){
				$disp_leave_name = "Home</b> on <b>Friday</b> $disp_bus_name</b>, returning on <b>$disp_arr_date_day_name</b> $disp_arr_bus_name";
			}
			else if ($disp_dep_date == $saturdayoty){
				$disp_leave_name = "Home</b> on <b>Saturday</b> $disp_bus_name</b>, returning on <b>$disp_arr_date_day_name</b> $disp_arr_bus_name";
			}
			else if ($disp_dep_date == $sundayoty){
				$disp_leave_name = "Home</b> on <b>Sunday</b> $disp_bus_name</b>, returning on <b>$disp_arr_date_day_name</b> $disp_arr_bus_name";
			}
			if ($disp_sit == 1){
				$disp_leaves[] = "
				<form method='POST'>
				<input type='hidden' name='departure_to_remove' value='$disp_leave_id'><b>
				$disp_leave_name</b>
				<input type='submit' style='font-size:35pt;background:none; cursor: hand; border:0; color:#c1272d; font-weight:bold' name='remove_permit' value='[remove]' $disabled>
				</form>";
			} else {
				$disp_leaves[] = "
				<br><b>$disp_leave_name</b>
				<b style='color:#c1272d; text-decoration:line-through; background:none; cursor: hand; border:0; font-weight:bold' name='removed'>
				[removed by administrator]</b>";
			}
		}
	}

	//displays where you are going
	if (isset($disp_leaves[0])){
		echo "
		This week, You are going to:" . $disp_leaves[0] . $disp_leaves[1];
	}
	else {
		echo "
		This week, You are not going anywhere.";
	}
} else {
	echo "<p style='font-size:20px;color:#c1272d;'>The system is closed. Please consult the Administration.</p>";
}
?>
</div>
</body>
</html>



















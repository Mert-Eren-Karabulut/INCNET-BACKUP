<?PHP
/*
Bu  sayfada student permission lar etkili değildir. Bu sayfa tam yetkilidir.
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

if (!(in_array("701", $allowed_pages))){
	header("location:index.php");
}

if (isset($_POST['export'])){
	$_POST['list'] = "List";
	$_POST['selectlist'] = $_SESSION['selectlist'];
	$_SESSION['selectlist'] = "";
	include("csvexport.php");
}

//unban query
if (isset($_POST['un-ban'])){
	$unban_user_id = $_POST['unban_user_id'];
	$unban_dep_date = $_POST['unban_dep_date'];
	mysql_query("UPDATE incnet.weekendDepartures SET situation='1' WHERE user_id='$unban_user_id' AND dep_date='$unban_dep_date'");	
}

//ban query
if (isset($_POST['ban'])){
	$ban_user_id = $_POST['ban_user_id'];
	$ban_dep_id = $_POST['ban_dep_id'];
	mysql_query("UPDATE incnet.weekendDepartures SET situation='0' WHERE user_id='$ban_user_id' AND departure_id='$ban_dep_id'");
}

//edit query and redirection
if (isset($_POST['edit'])){
	$_SESSION['edit_user_id'] = $_POST['edit_user_id'];
	$_SESSION['edit_dep_id'] = $_POST['edit_dep_id'];
	$_SESSION['edit_depbus_id'] = $_POST['edit_depbus_id'];
	$_SESSION['edit_arrbus_id'] = $_POST['edit_arrbus_id'];
	$_SESSION['edit_leave_value'] = $_POST['edit_leave_value'];
	$_SESSION['edit_dep_date'] = $_POST['edit_dep_date'];
	$_SESSION['edit_arr_date'] = $_POST['edit_arr_date'];
	header("location:editdeparture.php");
}

//current time
$week_name = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
$dnoweek = date(w);
if ($dnoweek==0) {$dnoweek=7;}
$pdnff = 5-$dnoweek;
$pdnfsat = 6-$dnoweek;
$pdnfsun = 7-$dnoweek;
$friday = date('d-m-F-Y', strtotime("+" . $pdnff . " days"));
$friday = explode("-", $friday);
$saturday = date('d-m-F-Y', strtotime("+" . $pdnfsat . " days"));
$saturday = explode("-", $saturday);
$sunday = date('d-m-F-Y', strtotime("+" . $pdnfsun . " days"));
$sunday = explode("-", $sunday);
$fridayoty = $friday[3] . "-" . $friday[1] . "-" . $friday[0];
$saturdayoty = $saturday[3] . "-" . $saturday[1] . "-" . $saturday[0];
$sundayoty = $sunday[3] . "-" . $sunday[1] . "-" . $sunday[0];
$infofri = $friday[0] . " " . $friday[2] . " " . $friday[3] . " Friday";
$infosat = $saturday[0] . " " . $saturday[2] . " " . $saturday[3] . " Saturday";
$infosun = $sunday[0] . " " . $sunday[2] . " " . $sunday[3] . " Sunday"; 
$dep_arr_days = array($fridayoty, $saturdayoty, $sundayoty, "", $infofri, $infosat, $infosun);
?>
<!DOCTYPE html>
<HTML>
<head>
<title>Inçnet | Weekend Departures</title>
<link rel="shortcut icon" href="favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
</head>
<body>
	<div class="top_menubar">
	<?PHP echo $fullname; ?>
	</div>
<br><br>
<div class="page_logo_container">
<table><tr>
<td width="120px"><a href="index.php" style='position:fixed; top: 80px;'><img src="weekend.png" width="120px" border=0 /></a><br>
</td>
<td width="5px"></td>
<td bgcolor="black" width=0.1px>
<td width="3px"></td>
<td valign="middle">
<h3>Edit Departure Lists Page</h3>
Student Permissions doesn't affect in this page.<br><br>
<a href='editlists.php' style='background:none; text-decoration:none; border:0; color:red; font-weight:bold' type='submit' name='back'>[Back]</a>
<br><br><!--
<hr><br><form name='print' action='printable.php' method='GET'>
<input type='hidden' name='query' value='$sql_changed'>
<input type='hidden' name='headerinfo_name' value='$info_leave_name'>
<input type='hidden' name='headerinfo_date' value='$info_leave_date'>
<input type='hidden' name='headerinfo_bus' value='$info_bus_name'>
<input style='background:none; cursor: hand; border:0; color:blue; font-weight:bold' type='submit' name='print' value='[print]'></form>-->
<!--  CSV Export Disabled
<form name='export' method='POST'>
<input style='background:none; cursor: hand; border:0; color:blue; font-weight:bold' type='submit' name='export' value='[export]'></form>
-->
<b>All Departures</b><br>	
<table style= 'border: 1px solid black;'><tr style= 'height: 20px'><td></td>
<td><b>Student ID</b></td>
<td><b>Student Name</b></td>
<td><b>Departure Bus</b></td>
<td><b>Departure Date</b></td>
<td><b>Arrival Bus</b></td>
<td><b>Arrival Date</b></td>
<td><b>Leave Name</b></td>
<td></td><td></td></tr>
<?
$order = 1;
$sql = mysql_query("SELECT * FROM incnet.coreUsers WHERE student_id > 0");
while ($row = mysql_fetch_array($sql)){
	$list_userID = $row['user_id'];
	$list_student_id = $row['student_id'];
	$list_student_name = $row['name']. " " . $row['lastname'];
	unset($list_depbus_name, $list_arrbus_name, $list_dep_date, $list_arr_date, $list_leave_name, $list_leave_day);
	//Query from Weekend-Departures
	$counter = 0;
	$sql0 = mysql_query("SELECT * FROM incnet.weekendDepartures WHERE user_id='$list_userID' AND situation=1");
	while ($row0 = mysql_fetch_array($sql0)){
		$list_depbus_id[] = $row0['dep_bus_id'];
		$sql1 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE bus_id=$list_depbus_id[$counter]");
		while ($row1 = mysql_fetch_array($sql1)){
			$list_depbus_name[] = $row1['bus_name'];}
		$list_arrbus_id[] = $row0['arr_bus_id'];
		$sql2 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE bus_id=$list_arrbus_id[$counter]");
		while ($row2 = mysql_fetch_array($sql2)){
			$list_arrbus_name[] = $row2['bus_name'];}
		$list_dep_date[] = $row0['dep_date'];
		$list_arr_date[] = $row0['arr_date'];
		$list_dep_id[] = $row0['departure_id'];
		$list_leave_group[] = $row0['leave_group'];
		$list_leave_id[] = $row0['leave_id'];
		$sql3 = mysql_query("SELECT * FROM incnet.weekendLeaves WHERE leave_id='$list_leave_id[$counter]'");
		while ($row3 = mysql_fetch_array($sql3)){
			if (isset($row3['leave_day_number'])){
				$list_leave_name[] = $row3['leave_name'] . " - " . $week_name[$row3['leave_day_number']];
			} else {
				$list_leave_name[] = $row3['leave_name'];
			}
		}
		$counter++;
	}
	
	//Query from Checkin
	$sql4 = mysql_query("SELECT * FROM incnet.checkinJoins, incnet.checkinEvents WHERE incnet.checkinJoins.user_id=$list_userID AND incnet.checkinJoins.event_id = incnet.checkinEvents.event_id AND (incnet.checkinEvents.event_date='$fridayoty' OR incnet.checkinEvents.event_date='$saturdayoty' OR incnet.checkinEvents.event_date='$sundayoty')") or die ("die ladı işte");
//echo $sql4;
echo $list_depbus_name[0];
	while ($row4 = mysql_fetch_array($sql4)){
		$list_leave_name[] = $row4['event_title']; 
		$list_dep_date[] = $row4['event_date'];
		$list_arr_date[] = $row4['event_date'];
	}
	echo "
		<tr><td><b>$order.</b></td><td>$list_student_id</td>
		<td>$list_student_name</td><td>"; 
	$dep_bus_count = count($list_depbus_name);
	for ($dep_bus_now = 0; $dep_bus_now < $dep_bus_count; $dep_bus_now++){
		echo $list_depbus_name[$dep_bus_now] . "<br>";
	}	
	$dep_date_count = count($list_dep_date);
	for (;$dep_bus_now < $dep_date_count; $dep_bus_now++){
		echo "<br>";
	}
	echo "</td><td>"; 
	for ($dep_date_now = 0; $dep_date_now < $dep_date_count; $dep_date_now++){
		echo $list_dep_date[$dep_date_now] . "<br>";
	}
	echo "
		</td><td>"; 
	for ($dep_bus_now = 0; $dep_bus_now < $dep_bus_count; $dep_bus_now++){
		echo $list_arrbus_name[$dep_bus_now] . "<br>";
	}
	for (;$dep_bus_now < $dep_date_count; $dep_bus_now++){
		echo "<br>";
	}
	echo "</td><td>"; 
	for ($dep_date_now = 0; $dep_date_now < $dep_date_count; $dep_date_now++){
		echo $list_arr_date[$dep_date_now] . "<br>";
	}
	echo "
	</td><td>"; 
	for ($dep_date_now = 0; $dep_date_now < $dep_date_count; $dep_date_now++){
		echo $list_leave_name[$dep_date_now] . "<br>";
	}
	echo "</td><td>";
	//echo "HERE!!!" . $dep_bus_count;
	for ($dep_id_now = 0; $dep_id_now < $dep_bus_count; $dep_id_now++){
		echo "<b><form name='ban' method='POST'>
		<input type='hidden' name='ban_user_id' value='" . $list_userID . "'>
		<input type='hidden' name='ban_dep_id' value='" . $list_dep_id[$dep_id_now] . "'>
		<input style='background:none; cursor: hand; border:0; color:red; font-weight:bold' type='submit' name='ban' value='[remove]'>
		</form></b>";
	}
	for (;$dep_id_now < $dep_date_count; $dep_id_now++){
		echo "<br>";
	}
	echo "</td><td>";
	for ($dep_edit_now = 0; $dep_edit_now < $dep_bus_count; $dep_edit_now++){
		echo "
		<b><form name='edit' method='POST'>
		<input type='hidden' name='edit_user_id' value='" . $list_userID . "'>
		<input type='hidden' name='edit_dep_id' value='" . $list_dep_id[$dep_edit_now] . "'>
		<input type='hidden' name='edit_depbus_id' value='" . $list_depbus_id[$dep_edit_now] . "'>
		<input type='hidden' name='edit_arrbus_id' value='" . $list_arrbus_id[$dep_edit_now] . "'>
		<input type='hidden' name='edit_leave_value' value='" . $list_leave_id[$dep_edit_now] . "." . $list_leave_group[$dep_edit_now] . "'>		
		<input type='hidden' name='edit_dep_date' value='" . $list_dep_date[$dep_edit_now] . "'>
		<input type='hidden' name='edit_arr_date' value='" . $list_arr_date[$dep_edit_now] . "'>
		<input style='background:none; cursor: hand; border:0; color:#FFCF00; font-weight:bold' type='submit' name='edit' value='[edit]'>
		</form></b>";
	}
	for (;$dep_edit_now < $dep_date_count; $dep_edit_now++){
		echo "<br>";
	}
	echo "</td></tr>";
	$order++;
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
</form>
</div>
<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2012 INCNET</a>
</div>
</body>
</HTML>

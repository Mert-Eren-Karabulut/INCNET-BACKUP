<?PHP
error_reporting(0);
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
	$ban_dep_date = $_POST['ban_dep_date'];
	mysql_query("UPDATE incnet.weekendDepartures SET situation='0' WHERE user_id='$ban_user_id' AND dep_date='$ban_dep_date'");
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
$dep_arr_days = array($fridayoty, $saturdayoty, $sundayoty, "", "", $infofri, $infosat, $infosun);
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
<h3>Edit Arrival Lists Page</h3>
Student Permissions doesn't affect in this page.<br><br>
<form method='POST'><select name='selectlist'>
<?
$selected_list = $_POST['selectlist'];
$sql = mysql_query("SELECT * FROM incnet.weekendBuses WHERE direction=1 OR direction=2");
while ($row = mysql_fetch_array($sql)){
	$select_bus_id = $row['bus_id'];
	$select_bus_name = $row['bus_name'];
	$select_bus_display = "Home - Sunday-" . $select_bus_name;
	if ($selected_list == $select_bus_id){
		echo "
		<option selected='yes' value='$select_bus_id'>$select_bus_display</option>";
	} else {
		echo "
		<option value='$select_bus_id'>$select_bus_display</option>";
	}
}

if ($selected_list == '105'){
	echo "
	<option selected='yes' value='105'>Home - Friday</option>";
} else {
	echo "
	<option value='105'>Home - Friday</option>";
}

if ($selected_list == '106'){
	echo "
	<option selected='yes' value='106'>Home - Saturday</option>";
} else {
	echo "
	<option value='106'>Home - Saturday</option>";
}
?>
</select><input type='submit' name='listselect' value='List'></form>
<?
if (isset($_POST['listselect'])){
	$selected_extra_id = $selected_list%100;
	
	//header info query and variables
	if ($selected_list > '100'){
		$info_leave_date = $dep_arr_days[$selected_extra_id];
	} else {
		$info_leave_date = $infosun;
		$info_bus_id = $selected_extra_id;
	}
	$sql4 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE bus_id=$info_bus_id");
	while ($row4 = mysql_fetch_array($sql4)){
		if ($info_bus_id == 1){
			$info_bus_name = "</b> by <b>" . $row4['bus_name'];
		} else if ($info_bus_id == 3){
			$info_bus_name = "</b> with <b>" . $row4['bus_name'];
		} else {
			$info_bus_name = "</b> by <b>" . $row4['bus_name'] . " Bus";
		}
	}
	
	//Select Query
	if ($selected_list < '100'){
		$sql0 = "SELECT * FROM incnet.weekendDepartures WHERE leave_id=5 AND arr_date='$sundayoty' AND situation=1 AND arr_bus_id=$selected_extra_id";
		$query = '1';
	} else {
		$selected_leave_dateoty = $dep_arr_days[$selected_extra_id-5];
		$sql0 = "SELECT * FROM incnet.weekendDepartures WHERE leave_id=5 AND arr_date='$selected_leave_dateoty' AND situation=1 ORDER BY arr_bus_id ASC";
		$query = '2';
	} 
	
	$to_be_changed = "'";
	$to_change = "#";
	$sql_changed = str_replace($to_be_changed, $to_change, $sql0);
	
	echo "
	<hr><br><form name='print' action='printable.php' method='GET'>
	<input type='hidden' name='query' value='$sql_changed'>
	<input type='hidden' name='headerinfo_name' value='Home'>
	<input type='hidden' name='headerinfo_date' value='$info_leave_date'>
	<input type='hidden' name='headerinfo_bus' value='$info_bus_name'>
	<input type='hidden' name='headerinfo_type' value='Arrivals from '>
	<input style='background:none; cursor: hand; border:0; color:blue; font-weight:bold' type='submit' name='print' value='[print]'></form>
	<!--  CSV Export Disabled
	<form name='export' method='POST'>
	<input style='background:none; cursor: hand; border:0; color:blue; font-weight:bold' type='submit' name='export' value='[export]'></form>
	-->
	Arrivals from <b>Home</b> on <b>" . $info_leave_date . $info_bus_name . "</b><br>	
	<table style= 'border: 1px solid black;'><tr style= 'height: 20px'><td></td>
		<td><b>Student ID</b></td>
		<td><b>Student Name</b></td>
		<td><b>Departure Bus</b></td>
		<td><b>Departure Date</b></td>
		<td><b>Arrival Bus</b></td>
		<td><b>Arrival Date</b></td>
		<td></td><td></td></tr>";

	//DB Query to fill the table
	$sql0 = mysql_query($sql0);
	while ($row0 = mysql_fetch_array($sql0)){
		$list_user_id = $row0['user_id'];
		$sql1 = mysql_query("SELECT * FROM incnet.coreUsers WHERE user_id=$list_user_id");
		while ($row1 = mysql_fetch_array($sql1)){
			$list_student_name = $row1['name'] . " " . $row1['lastname'];
			$list_student_id = $row1['student_id'];}
		$list_depbus_id = $row0['dep_bus_id'];
		$sql2 = mysql_query("SELECT bus_name FROM incnet.weekendBuses WHERE bus_id=$list_depbus_id");
		while ($row2 = mysql_fetch_array($sql2)){
			$list_depbus_name = $row2['bus_name'];}
		$list_arrbus_id = $row0['arr_bus_id'];
		$sql3 = mysql_query("SELECT bus_name FROM incnet.weekendBuses WHERE bus_id=$list_arrbus_id");
		while ($row3 = mysql_fetch_array($sql3)){
			$list_arrbus_name = $row3['bus_name'];}
		$list_dep_date = $row0['dep_date'];
		$list_arr_date = $row0['arr_date'];
		$list_leave_group = $row0['leave_group'];
		$list_dep_id = $row0['departure_id'];
		
		//html code of rows of list
		echo "
		<tr><td>$list_student_id</td>
		<td>$list_student_name</td><td>$list_depbus_name</td>
		<td>$list_dep_date</td><td>$list_arrbus_name</td>
		<td>$list_arr_date</td>
		<td><b><form name='ban' method='POST'>
		<input type='hidden' name='ban_user_id' value='" . $list_user_id . "'>
		<input type='hidden' name='ban_dep_date' value='" . $list_dep_date . "'>
		<input style='background:none; cursor: hand; border:0; color:red; font-weight:bold' type='submit' name='ban' value='[remove]'>
		</form></b></td>
		<td><b><form name='edit' method='POST'>
		<input type='hidden' name='edit_user_id' value='" . $list_user_id . "'>
		<input type='hidden' name='edit_dep_id' value='" . $list_dep_id . "'>
		<input type='hidden' name='edit_depbus_id' value='" . $list_depbus_id . "'>
		<input type='hidden' name='edit_arrbus_id' value='" . $list_arrbus_id . "'>
		<input type='hidden' name='edit_leave_value' value='5." . $list_leave_group . "'>		
		<input type='hidden' name='edit_dep_date' value='" . $list_dep_date . "'>
		<input type='hidden' name='edit_arr_date' value='" . $list_arr_date . "'>
		<input style='background:none; cursor: hand; border:0; color:#FFCF00; font-weight:bold' type='submit' name='edit' value='[edit]'>
		</form></b></td></tr>";
	}
		echo "
	</table>";
	
	//banned query
	if ($query == '1'){ 
		$sql5 = mysql_query("SELECT * FROM incnet.weekendDepartures WHERE leave_id=5 AND arr_date='$sundayoty' AND situation=0 AND arr_bus_id=$selected_extra_id");
	} else if ($query == '2'){
		$sql5 = mysql_query("SELECT * FROM incnet.weekendDepartures WHERE leave_id=5 AND arr_date=$selected_leave_dateoty AND situation=0 ORDER BY arr_bus_id ASC");
	} 
	
	//unban table
	echo "
	<hr><br><b>Un-Ban</b><br>
	<table style= 'border: 1px solid black; font-size:14px;'><tr><td></td>
	<td><b>Student ID</b></td>
	<td><b>Student Name</b></td>
	<td><b>Departure Bus</b></td>
	<td><b>Departure Date</b></td>
	<td><b>Arrival Bus</b></td>
	<td><b>Arrival Date</b></td>
	<td></td></tr>";
	
	//unban variables
	$ban_order = '1';
	while ($row5 = mysql_fetch_array($sql5)){
		$ban_user_id = $row5['user_id'];
		$sql6 = mysql_query("SELECT * FROM incnet.coreUsers WHERE user_id=$ban_user_id");
		while ($row6 = mysql_fetch_array($sql6)){
			$ban_student_name = $row6['name'] . " " . $row6['lastname'];
			$ban_student_id = $row6['student_id'];}
		$ban_depbus_id = $row5['dep_bus_id'];
		$sql7 = mysql_query("SELECT bus_name FROM incnet.weekendBuses WHERE bus_id=$ban_depbus_id");
		while ($row7 = mysql_fetch_array($sql7)){
			$ban_depbus_name = $row7['bus_name'];}
		$ban_arrbus_id = $row5['arr_bus_id'];
		$sql8 = mysql_query("SELECT bus_name FROM incnet.weekendBuses WHERE bus_id=$ban_arrbus_id");
		while ($row8 = mysql_fetch_array($sql8)){
			$ban_arrbus_name = $row8['bus_name'];}
		$ban_dep_date = $row5['dep_date'];
		$ban_arr_date = $row5['arr_date'];
		
		//html code of rows in unban list 
		echo "
		<tr><td><b>$ban_order</b></td><td>$ban_student_id</td>
		<td>$ban_student_name</td><td>$ban_depbus_name</td>
		<td>$ban_dep_date</td><td>$ban_arrbus_name</td>
		<td>$ban_arr_date</td>
		<td><b><form name='un-ban' method='POST'>
		<input type='hidden' name='unban_user_id' value='" . $ban_user_id . "'>
		<input type='hidden' name='unban_dep_date' value='" . $ban_dep_date . "'>
		<input style='background:none; cursor: hand; border:0; color:green; font-weight:bold' type='submit' name='un-ban' value='[allow]'>
		</form></td>";	
		$ban_order++;
	}
}
?>
</table><br>
</td></tr></table>
</div><br><br><br>
<div class="logoff_button">
<form name="logoff" method="POST">
<input type ="submit" name="logoff" value="Log Off">
</form></div>
<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2012 INCNET</a>
</div>
</body>
</HTML>

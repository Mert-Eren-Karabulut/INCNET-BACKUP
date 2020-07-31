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
<form method='POST'><select name='selectlist'>
<option value='0'>All</option>
<?PHP

//dropdown for lists
$sql1 = mysql_query("SELECT * FROM incnet.weekendLeaves");
while ($row1 = mysql_fetch_array($sql1)){
	$selected_list = $_POST['selectlist'];
	$select_leave_id = $row1['leave_id'];
	
	//for home with transportations on friday
	if ($select_leave_id == 5){
		$sql2 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE direction=0 OR direction=2");
		while ($row2 = mysql_fetch_array($sql2)){
			$select_bus_id = $row2['bus_id'];
			$select_bus_value = '5.' . $select_bus_id;
			$select_bus_name = "Home - Friday-" . $row2['bus_name'];
			if ($selected_list == $select_bus_value){
				echo "
				<option selected='yes' value=" . $select_bus_value . ">" . $select_bus_name . "</option>";
			} else {
				echo "
				<option value=" . $select_bus_value . ">" . $select_bus_name . "</option>";
			}
		}
	} else {
	
		//for other leaves
		$select_leave_day = $row1['leave_day_number'] - 1;
		$select_leave_day = $week_name[$select_leave_day];
		$select_leave_name = $row1['leave_name'] . " - " . $select_leave_day;
		if ($selected_list == $select_leave_id){
			echo "
			<option selected='yes' value=" . $select_leave_id . ">" . $select_leave_name . "</option>";
		} else {
			echo "
			<option value=" . $select_leave_id . ">" . $select_leave_name . "</option>";
		}
		$select_leave_id++;
	}
}

//for home on saturday and sunday
$list_depbyday_value = 5.106;
$list_depbyday_nameday = 5;
while ($list_depbyday_value < 5.108){
	if ($selected_list == $list_depbyday_value){
		echo "
		<option selected='yes' value=$list_depbyday_value>Home - $week_name[$list_depbyday_nameday]</option>";
	} else {
		echo "
		<option value=$list_depbyday_value>Home - $week_name[$list_depbyday_nameday]</option>";
	}
	$list_depbyday_value = $list_depbyday_value + 0.001;
	$list_depbyday_nameday++;
}

echo "
</select><input type='submit' name='list' value='List'></form>";

//show list database query
if (isset($_POST['list'])){
	$_SESSION['selectlist'] = $_POST['selectlist'];
	//header info query and variables
	$list = explode(".", $_POST['selectlist']);
	$selected_leave_id = $list[0];
	$selected_extra_id = $list[1];
	if ($selected_leave_id == 0){
		$info_leave_name = "All departures";
		$info_leave_date = "this weekend";
	} else if ($selected_leave_id == '-1'){
		$info_leave_name = "Remaining in the school";
		$info_leave_date = "this weekend";	
	} else if ($selected_leave_id != 5){
		$sql9 = mysql_query("SELECT * FROM incnet.weekendLeaves WHERE leave_id=$selected_leave_id");
		while ($row9 = mysql_fetch_array($sql9)){
			$info_leave_name = $row9['leave_name'];
			$info_leave_day = $row9['leave_day_number'] - 1;
			$info_leave_date = $dep_arr_days[$info_leave_day];
			$info_bus_id = $row9['bus_id'];
		}
	}else if ($selected_extra_id > 100){
		$info_leave_name = "Home";
		$info_leave_day = $selected_extra_id - 101;
		$info_leave_date = $dep_arr_days[$info_leave_day]; 
	} else {
		$info_leave_name = "Home";
		$info_leave_date = $infofri;
		$info_bus_id = $selected_extra_id;	
	}
	$sql = mysql_query("SELECT * FROM incnet.weekendBuses WHERE bus_id=$info_bus_id");
	while ($row = mysql_fetch_array($sql)){
		if ($info_bus_id == 1){
			$info_bus_name = "</b> by <b>" . $row['bus_name'];
		} else if ($info_bus_id == 3){
			$info_bus_name = "</b> with <b>" . $row['bus_name'];
		} else {
			$info_bus_name = "</b> by <b>" . $row['bus_name'] . " Bus";
		}
	}
		
	//queries for lists
	if ($selected_leave_id == 5){
		if ($selected_extra_id < 100){
			$selected_bus_id = $selected_extra_id;
			$sql3 = "SELECT incnet.weekendDepartures.*, incnet.weekendLeaves.leave_id, incnet.weekendLeaves.leave_name, incnet.weekendLeaves.leave_day_number, incnet.coreUsers.name, incnet.coreUsers.lastname, incnet.coreUsers.student_id FROM incnet.weekendDepartures, incnet.coreUsers, incnet.weekendLeaves WHERE incnet.weekendDepartures.leave_id=5 AND incnet.weekendDepartures.dep_bus_id=$selected_bus_id AND incnet.weekendDepartures.dep_date='$fridayoty' AND incnet.weekendDepartures.situation=1 AND incnet.weekendDepartures.user_id = incnet.coreUsers.user_id AND incnet.weekendLeaves.leave_id = incnet.weekendDepartures.leave_id ORDER BY incnet.coreUsers.lastname, incnet.coreUsers.name";
			$query = '1';
		} else {
			$selected_day_id = $selected_extra_id - 105;
			$selected_day_date = $dep_arr_days[$selected_day_id];
			$sql3 = "SELECT incnet.weekendDepartures.*, incnet.weekendLeaves.leave_id, incnet.weekendLeaves.leave_name, incnet.weekendLeaves.leave_day_number, incnet.coreUsers.name, incnet.coreUsers.lastname, incnet.coreUsers.student_id FROM incnet.weekendDepartures, incnet.coreUsers, incnet.weekendLeaves WHERE incnet.weekendDepartures.leave_id=5 AND incnet.weekendDepartures.dep_date='$selected_day_date' AND incnet.weekendDepartures.situation=1 AND incnet.weekendDepartures.user_id = incnet.coreUsers.user_id AND incnet.weekendLeaves.leave_id = incnet.weekendDepartures.leave_id ORDER BY incnet.coreUsers.lastname, incnet.coreUsers.name";
			$query = '2';
		}
	} else if ($selected_leave_id > 0){
		$sql3 = "SELECT incnet.weekendDepartures.*, incnet.weekendLeaves.leave_id, incnet.weekendLeaves.leave_name, incnet.weekendLeaves.leave_day_number, incnet.coreUsers.name, incnet.coreUsers.lastname, incnet.coreUsers.student_id FROM incnet.weekendDepartures, incnet.coreUsers, incnet.weekendLeaves WHERE incnet.weekendDepartures.leave_id=$selected_leave_id AND incnet.weekendDepartures.situation=1 AND incnet.weekendDepartures.user_id = incnet.coreUsers.user_id AND incnet.weekendLeaves.leave_id = incnet.weekendDepartures.leave_id ORDER BY incnet.coreUsers.lastname, incnet.coreUsers.name";
		$query = '3';
	} else if ($selected_leave_id == 0){
		echo "<script>window.location = 'listall.php'</script>";
		//$sql3 = "SELECT * FROM incnet.coreUsers, incnet.weekendDepartures WHERE (incnet.coreUsers.user_id = incnet.weekendDepartures.user_id OR incnet.coreUsers.user_id != incnet.weekendDepartures.user_id) AND incnet.coreUsers.student_id > 0";
		//$sql3 = "SELECT incnet.weekendDepartures.*, incnet.weekendLeaves.leave_id, incnet.weekendLeaves.leave_name, incnet.weekendLeaves.leave_day_number, incnet.coreUsers.name, incnet.coreUsers.lastname, incnet.coreUsers.student_id FROM incnet.weekendDepartures, incnet.coreUsers, incnet.weekendLeaves WHERE incnet.weekendDepartures.user_id = incnet.coreUsers.user_id AND incnet.weekendLeaves.leave_id = incnet.weekendDepartures.leave_id ORDER BY incnet.coreUsers.lastname, incnet.coreUsers.name";
		$query = '4';
	} else {
		//echo "@school";
	}
//	echo $query;
	$to_be_changed = "'";
	$to_change = "#";
	$sql_changed = str_replace($to_be_changed, $to_change, $sql3);
	 
	echo "
	<hr><br><form name='print' action='printable.php' method='GET'>
	<input type='hidden' name='query' value='$sql_changed'>
	<input type='hidden' name='headerinfo_name' value='$info_leave_name'>
	<input type='hidden' name='headerinfo_date' value='$info_leave_date'>
	<input type='hidden' name='headerinfo_bus' value='$info_bus_name'>
	<input style='background:none; cursor: hand; border:0; color:blue; font-weight:bold' type='submit' name='print' value='[print]'></form>
	<!--  CSV Export Disabled
	<form name='export' method='POST'>
	<input style='background:none; cursor: hand; border:0; color:blue; font-weight:bold' type='submit' name='export' value='[export]'></form>
	-->
	<b>" . $info_leave_name . "</b> on <b>" . $info_leave_date . $info_bus_name . "</b><br>	
	<table style= 'border: 1px solid black;'><tr style= 'height: 20px'>
	<td><b>Student ID</b></td>
	<td><b>Student Name</b></td>
	<td><b>Departure Bus</b></td>
	<td><b>Departure Date</b></td>
	<td><b>Arrival Bus</b></td>
	<td><b>Arrival Date</b></td>
	<td><b>Leave Name</b></td>
	<td></td><td></td></tr>";
	
	//variables for list
	$sql3 = mysql_query($sql3);
	while ($row3 = mysql_fetch_array($sql3)){
		$list_user_id = $row3['user_id'];
		$list_student_name = $row3['name'] . " " . $row3['lastname'];
		$list_student_id = $row3['student_id'];
		$list_depbus_id = $row3['dep_bus_id'];
		$list_leave_name = $row3['leave_name'];
		if (isset($row3['leave_day_number'])){
			$list_leave_day = " - " . $week_name[$row3['leave_day_number']-1];}
		$sql5 = mysql_query("SELECT bus_name FROM incnet.weekendBuses WHERE bus_id=$list_depbus_id");
		while ($row5 = mysql_fetch_array($sql5)){
			$list_depbus_name = $row5['bus_name'];}
		$list_arrbus_id = $row3['arr_bus_id'];
		$sql0 = mysql_query("SELECT bus_name FROM incnet.weekendBuses WHERE bus_id=$list_arrbus_id");
		while ($row0 = mysql_fetch_array($sql0)){
			$list_arrbus_name = $row0['bus_name'];}
		$list_dep_date = $row3['dep_date'];
		$list_arr_date = $row3['arr_date'];
		$list_leave_group = $row3['leave_group'];
		$list_dep_id = $row3['departure_id'];
		
		//html code of rows of list
		echo "
		<tr><td>$list_student_id</td>
		<td>$list_student_name</td><td>$list_depbus_name</td>
		<td>$list_dep_date</td><td>$list_arrbus_name</td>
		<td>$list_arr_date</td><td>$list_leave_name$list_leave_day</td>
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
		<input type='hidden' name='edit_leave_value' value='" . $selected_leave_id . "." . $list_leave_group . "'>		
		<input type='hidden' name='edit_dep_date' value='" . $list_dep_date . "'>
		<input type='hidden' name='edit_arr_date' value='" . $list_arr_date . "'>
		<input style='background:none; cursor: hand; border:0; color:#FFCF00; font-weight:bold' type='submit' name='edit' value='[edit]'>
		</form></b></td></tr>";
	}
	echo "
	</table>";
	
	//banned query
	if ($query == 1){ 
		$sql6 = mysql_query("SELECT * FROM incnet.weekendDepartures WHERE leave_id=5 AND dep_bus_id=$selected_bus_id AND dep_date='$fridayoty' AND situation=0");
	} else if ($query == 2){
		$sql6 = mysql_query("SELECT * FROM incnet.weekendDepartures WHERE leave_id=5 AND dep_date='$selected_day_date' AND situation=0");
	} else if ($query == '3'){
		$sql6 = mysql_query("SELECT * FROM incnet.weekendDepartures WHERE leave_id=$selected_leave_id AND situation=0");
	}
	//echo $sql6 . "HEREé";
	//unban table
	echo "
	<hr><br><b>Un-Ban</b><br>
	<table style= 'border: 1px solid black; font-size:14;'><tr><td></td>
	<td><b>Student ID</b></td>
	<td><b>Student Name</b></td>
	<td><b>Departure Bus</b></td>
	<td><b>Departure Date</b></td>
	<td><b>Arrival Bus</b></td>
	<td><b>Arrival Date</b></td>
	<td></td></tr>";
	
	//unban variables
	$ban_order = '1';
	while ($row6 = mysql_fetch_array($sql6)){
		$ban_user_id = $row6['user_id'];
		$sql7 = mysql_query("SELECT * FROM incnet.coreUsers WHERE user_id=$ban_user_id");
		while ($row7 = mysql_fetch_array($sql7)){
			$ban_student_name = $row7['name'] . " " . $row7['lastname'];
			$ban_student_id = $row7['student_id'];}
		$ban_depbus_id = $row6['dep_bus_id'];
		$sql8 = mysql_query("SELECT bus_name FROM incnet.weekendBuses WHERE bus_id=$ban_depbus_id");
		while ($row8 = mysql_fetch_array($sql8)){
			$ban_depbus_name = $row8['bus_name'];}
		$ban_arrbus_id = $row6['arr_bus_id'];
		$sqlq = mysql_query("SELECT bus_name FROM incnet.weekendBuses WHERE bus_id=$ban_arrbus_id");
		while ($rowq = mysql_fetch_array($sqlq)){
			$ban_arrbus_name = $rowq['bus_name'];}
		$ban_dep_date = $row6['dep_date'];
		$ban_arr_date = $row6['arr_date'];
		
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
	echo "
	</table>";
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

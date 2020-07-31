<?PHP
/*
Bu  sayfada student permission lar etkili değildir. Bu sayfa tam yetkilidir.
*/

session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}

$edit_last_leave = $_POST['selectleave'];
$selected_leaves = explode(".", $edit_last_leave);
$selected_leave = $selected_leaves[0];
if ((isset($_POST['save']))||((isset($_POST['save_or_go']))&&($selected_leave != 5))){
	header("location:editlists.php");
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

//$_SESSION variables
$edit_last_leave = $_POST['selectleave'];
$selected_leaves = explode(".", $edit_last_leave);
$selected_leave = $selected_leaves[0];
if ((isset($_POST['save_or_go']))&&($selected_leave == 5)){
	$_SESSION['edit_user_id'] = $_POST['selectuser'];
	$_SESSION['edit_depbus_id'] = $_POST['selectdepbus'];
	$_SESSION['edit_leave_value'] = $_POST['selectleave'];
}
$edit_dep_id = $_SESSION['edit_dep_id'];
$edit_user_id = $_SESSION['edit_user_id'];
$edit_depbus_id = $_SESSION['edit_depbus_id'];
$edit_arrbus_id = $_SESSION['edit_arrbus_id'];
$edit_leave_value = $_SESSION['edit_leave_value'];
$edit_dep_date = $_SESSION['edit_dep_date'];
$edit_arr_date = $_SESSION['edit_arr_date'];

//current date
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
$fridaydisp = $friday[0] . " " . $friday[2] . " " . $friday[3];
$saturdaydisp = $saturday[0] . " " . $saturday[2] . " " . $saturday[3];
$sundaydisp = $sunday[0] . " " . $sunday[2] . " " . $sunday[3];
$dep_arr_days = array($fridayoty, $saturdayoty, $sundayoty, $fridaydisp, $saturdaydisp, $sundaydisp);
?>
<!DOCTYPE html>
<HTML>
<head>
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
<td><a href="editlists.php"><img src="weekend.png" width="120px" border=0 /></a><br>


</td>
<td width="5px"></td>
<td bgcolor="black" width=0.1px>
<td width="3px"></td>
<td valign="middle">
<h3>Edit Departure/Arrival Page</h3>
Student Permissions doesn't affect in this page.<br><br>
<form method='POST' name='editdeparture'>
User: <select name="selectuser">
<?PHP

//dropdown users query
$sql1 = mysql_query("SELECT * FROM incnet.coreUsers WHERE student_id != 0 ORDER by name ASC");
while($row1 = mysql_fetch_array($sql1)){
	$list_user_display = $row1['name'] . " " . $row1['lastname'];
	$list_user_id = $row1['user_id'];
	$list_user_class = $row1['class'];
	$selected_user = $edit_user_id;
	if ($selected_user==$list_user_id){
		echo "
		<option selected='" . "yes" . "' value='" . $list_user_id . "'>" . $list_user_display . " (class: " . $list_user_class . ")</option>";
	} else {
		echo "
		<option value='" . $list_user_id . "'>" . $list_user_display . " (class: " . $list_user_class . ")</option>";
	}
}
echo "
</select><br><table><tr><td>
Departure Bus:</td><td><select name='selectdepbus' style='width:205px;'>";

//dropdown buses query
$sql2 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE direction='0' OR direction ='2'");
while ($row2 = mysql_fetch_array($sql2)){
	$list_depbus_id = $row2['bus_id'];
	$list_depbus_name = $row2['bus_name'];
	$selected_depbus = $edit_depbus_id;
	if ($selected_depbus==$list_depbus_id){
		echo "
		<option selected='yes' value='" . $list_depbus_id . "'>" . $list_depbus_name . "</option>";
	} else {
		echo "
		<option value='" . $list_depbus_id . "'>" . $list_depbus_name . "</option>";
	}
}
echo "
</select></td></tr><tr><td>
Arrival Bus:</td><td><select name='selectarrbus' style='width:205px;'>";
$sql5 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE direction='1' OR direction ='2'");
while ($row5 = mysql_fetch_array($sql5)){
	$list_arrbus_id = $row5['bus_id'];
	$list_arrbus_name = $row5['bus_name'];
	$selected_arrbus = $edit_arrbus_id;
	if ($selected_arrbus==$list_arrbus_id){
		echo "
		<option selected='yes' value='" . $list_arrbus_id . "'>" . $list_arrbus_name . "</option>";
	} else {
		echo "
		<option value='" . $list_arrbus_id . "'>" . $list_arrbus_name . "</option>";
	}
}

echo"</select></td></tr><tr><td>
Leave:</td><td><select name='selectleave' style='width:205px;'>";

//dropdown leaves query
$sql3 = mysql_query("SELECT * FROM incnet.weekendLeaves");
while ($row3 = mysql_fetch_array($sql3)){
	$list_leave_value = $row3['leave_id'] . "." . $row3['leave_group'];
	$list_leave_day = $row3['leave_day_number'] - 1;
	$list_leave_name = $row3['leave_name'] . "-" . $week_name[$list_leave_day];
	$selected_leaves = $edit_leave_value;
	if ($selected_leaves==$list_leave_value){
		echo "
		<option selected='yes' value='" . $list_leave_value . "'>" . $list_leave_name . "</option>";
	} else {
		echo "
		<option value='" . $list_leave_value . "'>" . $list_leave_name . "</option>";
	}
}
echo "
</select></td><td>";

//function of buttons
$edit_leave_value = explode(".", $edit_leave_value);
$edit_leave_id = $edit_leave_value[0];
$edit_leave_group = $edit_leae_group[1];
$dep_arr_count = 0;
$edit_last_leave = $_POST['selectleave'];
$selected_leaves = explode(".", $edit_last_leave);
$selected_leave = $selected_leaves[0];
$leave_group = $selected_leaves[1];

if (($selected_leave == 5)||($edit_leave_id == 5)){
	
	//departure and arrival date dropdowns
	echo "
	</td></tr><tr><td>
	Departure Date:</td><td><select name='dep_date' style='width:205px;'>";
	while ($dep_arr_count < 3){
		$dep_arr_disp = $dep_arr_count + 3;
		if ($dep_arr_days[$dep_arr_count] == $edit_dep_date){
			echo "
			<option selected='yes' value=" . $dep_arr_days[$dep_arr_count] . ">" . $dep_arr_days[$dep_arr_disp] . "</option>";
		} else {
			echo "
			<option value=" . $dep_arr_days[$dep_arr_count] . ">" . $dep_arr_days[$dep_arr_disp] . "</option>";
		}		
		$dep_arr_count++;
	}
	echo "
	</select></td></tr><tr><td>
	Arrival Date:</td><td><select name='arr_date' style='width:205px;'>";
	$dep_arr_count = 0;
	while ($dep_arr_count < 3){
		$dep_arr_disp = $dep_arr_count + 3;
		if ($dep_arr_days[$dep_arr_count] == $edit_arr_date){
			echo "
			<option selected='yes' value=" . $dep_arr_days[$dep_arr_count] . ">" . $dep_arr_days[$dep_arr_disp] . "</option>";
		} else {
			echo "
			<option value=" . $dep_arr_days[$dep_arr_count] . ">" . $dep_arr_days[$dep_arr_disp] . "</option>";
		}		
		$dep_arr_count++;
	}
	echo "
	</select></td><td>
	<input type='submit' name='save' value='Save'></td></tr>
	</table></form><hr>";
}		
else{		
if (isset($_POST['save_or_go'])){
	if ($selected_leave != 5){
	
		//update database
		$edit_last_user = $_POST['selectuser'];
		$edit_last_depbus = $_POST['selectdepbus'];
		$edit_last_arrbus = $_POST['selectarrbus'];
		$sql4 = mysql_query("SELECT * FROM incnet.weekendLeaves WHERE leave_id='$selected_leave'");
		while ($row4 = mysql_fetch_array($sql4)){
			$dep_arr_day = $row4['leave_day_number'] - 5;
			$dep_arr_date = $dep_arr_days[$dep_arr_day];
		}
		mysql_query("UPDATE incnet.weekendDepartures SET user_id =" . $edit_last_user . ", dep_bus_id =" . $edit_last_depbus . ", arr_bus_id=$edit_last_arrbus, leave_id =" . $selected_leave . ", dep_date ='" . $dep_arr_date . "', arr_date ='" . $dep_arr_date . "', leave_group = " . $leave_group . " WHERE departure_id = " . $edit_dep_id) or die(mysql_error());
		$_SESSION['edit_user_id'] = "";
		$_SESSION['edit_depbus_id'] = "";
		$_SESSION['edit_arrbus_id'] = "";
		$_SESSION['edit_leave_value'] = "";
		$_SESSION['edit_dep_date'] = "";
		$_SESSION['edit_arr_date'] = "";
		$_SESSION['edit_dep_id'] = "";
	}
}
else {
	echo "
	<input type='submit' name='save_or_go' value='Save/Go'>
	</td></tr></table></form><hr>";
}}
if (isset($_POST['save'])){
			//update database
			$edit_last_user = $_POST['selectuser'];
			$edit_last_depbus = $_POST['selectdepbus'];
			$edit_last_arrbus = $_POST['selectarrbus'];
			$dep_date = $_POST['dep_date'];
			$arr_date = $_POST['arr_date'];
			mysql_query("UPDATE incnet.weekendDepartures SET user_id =" . $edit_last_user . ", dep_bus_id =" . $edit_last_depbus . ", arr_bus_id=$edit_last_arrbus, leave_id =" . $selected_leave . ", dep_date ='" . $dep_date . "', arr_date ='" . $arr_date . "', leave_group = " . $leave_group . " WHERE departure_id = " . $edit_dep_id) or die(mysql_error);
			$_SESSION['edit_user_id'] = "";
			$_SESSION['edit_depbus_id'] = "";
			$_SESSION['edit_arrbus_id'] = "";
			$_SESSION['edit_leave_value'] = "";
			$_SESSION['edit_dep_date'] = "";
			$_SESSION['edit_arr_date'] = "";			
			$_SESSION['edit_dep_id'] = "";	
}

?>
<br>
</td>
</tr></table>
<div>
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

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
$dep_arr_days = array($fridayoty, $saturdayoty, $sundayoty);

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
<td><a href="index.php"><img src="weekend.png" width="120px" border=0 /></a><br>


</td>
<td width="5px"></td>
<td bgcolor="black" width=0.1px>
<td width="3px"></td>
<td valign="middle">
<h3>Add Departure Page</h3>
Student Permissions doesn't affect in this page.<br><br>
<form method='POST' name='adddeparture'>
Select User:
<select name="selectuser">
<?PHP

//dropdown users query
$sql1 = mysql_query("SELECT * FROM incnet.coreUsers WHERE student_id != 0 ORDER by name ASC");
while($row1 = mysql_fetch_array($sql1)){
	$list_user_display = $row1['name'] . " " . $row1['lastname'];
	$list_user_id = $row1['user_id'];
	$list_user_class = $row1['class'];
	$selected_user = $_POST['selectuser'];
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
Select Departure Bus:<select name='selectbusd'>";

//dropdown buses query

$sql2 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE direction='0' OR direction='2'");
while ($row2 = mysql_fetch_array($sql2)){
	$list_bus_idd = $row2['bus_id'];
	$list_bus_named = $row2['bus_name'];
	$selected_busd = $_POST['selectbusd'];
	if ($selected_busd==$list_bus_idd){
		echo "
		<option selected='" . "yes" . "' value='" . $list_bus_idd . "'>" . $list_bus_named . "</option>";
	} else {
		echo "
		<option value='" . $list_bus_idd . "'>" . $list_bus_named . "</option>";
	}
}
echo "</select></td></tr><tr><td>Select Arrival Bus:<select name='selectbusa'>";
$sql5 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE direction='1' OR direction='2'");
while ($row5 = mysql_fetch_array($sql5)){
	$list_bus_ida = $row5['bus_id'];
	$list_bus_namea = $row5['bus_name'];
	$selected_busa = $_POST['selectbusa'];
	if ($selected_busa==$list_bus_ida){
		echo "
		<option selected='" . "yes" . "' value='" . $list_bus_ida . "'>" . $list_bus_namea . "</option>";
	} else {
		echo "
		<option value='" . $list_bus_ida . "'>" . $list_bus_namea . "</option>";
	}
}
echo "
</select></td></tr><tr><td>
Select Leave:
<select name='selectleave'>";

//dropdown leaves query
$sql3 = mysql_query("SELECT * FROM incnet.weekendLeaves");
while ($row3 = mysql_fetch_array($sql3)){
	$list_leave_value = $row3['leave_id'] . "-" . $row3['leave_group'];
	$list_leave_day = $row3['leave_day_number'] - 1;
	$list_leave_name = $row3['leave_name'] . "-" . $week_name[$list_leave_day];
	$selected_leaves = $_POST['selectleave'];
	if ($selected_leaves==$list_leave_value){
		echo "
		<option selected='" . "yes" . "' value='" . $list_leave_value . "'>" . $list_leave_name . "</option>";
	} else {
		echo "
		<option value='" . $list_leave_value . "'>" . $list_leave_name . "</option>";
	}
}
echo "
</select></td><td>";

//function of buttons
if (isset($_POST['add_or_go'])){
	if ($_POST['selectleave'] == 5){
		
		//departure and arrival dates
		echo "
		</td></tr><tr><td><select name='dep_date'>
		<option value=" . $fridayoty . ">" . $friday[0] . " " . $friday[2] . " " . $friday[3] . "</option>
		<option value=" . $saturdayoty . ">" . $saturday[0] . " " . $saturday[2] . " " . $saturday[3] . "</option>
		<option value=" . $sundayoty . ">" . $sunday[0] . " " . $sunday[2] . " " . $sunday[3] . "</option>
		</select></td><td>
		<select name='arr_date'>
		<option value=" . $fridayoty . ">" . $friday[0] . " " . $friday[2] . " " . $friday[3] . "</option>
		<option value=" . $saturdayoty . ">" . $saturday[0] . " " . $saturday[2] . " " . $saturday[3] . "</option>
		<option selected='yes' value=" . $sundayoty . ">" . $sunday[0] . " " . $sunday[2] . " " . $sunday[3] . "</option></select></td><td>
		<input type='submit' name='add' value='Add'></td></tr>
		</table></form><hr>";
	}
	else {
	
		//insert to database
		$selected_leaves = explode("-", $selected_leaves);
		$selected_leave = $selected_leaves[0];
		$leave_group = $selected_leaves[1];
		$sql4 = mysql_query("SELECT * FROM incnet.weekendLeaves WHERE leave_id='$selected_leave'");
		while ($row4 = mysql_fetch_array($sql4)){
			$dep_arr_day = $row4['leave_day_number'] - 5;
			$dep_arr_date = $dep_arr_days[$dep_arr_day];
		}
		mysql_query("INSERT INTO incnet.weekendDepartures VALUES ('NULL', '$selected_user', '$selected_busd', '$selected_busa', '$selected_leave', '$dep_arr_date', '$dep_arr_date', '$leave_group', '1')") or die(mysql_error());
			echo "</td></tr></table></form><hr>Departure saved!";
	}
}
else {
	echo "
	<input type='submit' name='add_or_go' value='Add/Go'>
	</td></tr></table></form>";
}
if (isset($_POST['add'])){
			//insert to database
			$selected_leaves = explode("-", $selected_leaves);
			$selected_leave = $selected_leaves[0];
			$leave_group = $selected_leaves[1];
			$dep_date = $_POST['dep_date'];
			$arr_date = $_POST['arr_date'];
			mysql_query("INSERT INTO incnet.weekendDepartures VALUES ('NULL', '$selected_user', '$selected_busd', '$selected_busa', '$selected_leave', '$dep_date', '$arr_date', '$leave_group', '1')") or die(mysql_error());
			echo "<hr>Departure saved!";			
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

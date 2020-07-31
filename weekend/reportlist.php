<?PHP
session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}

$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];

if (isset($_POST['logoff'])){
	session_destroy();
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

$situation = array("Banned", "Gone");

//current date
$week_name = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
$dnwh = date('w-H-i');
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
<script src="jquery.js"></script>
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
<script>
//js that disables the submit buttons when the text boxes are empty.
$(document).ready(function(){
    $(".required").on('keyup', function() {
        if($(this).val() === '') {
            $("#button" + $(this).attr('id').substr(-1)).attr("disabled", "disabled");
        } else {
            $("#button" + $(this).attr('id').substr(-1)).removeAttr("disabled");
        }
    });
});
</script>
<h3>Reports Page</h3>
<form method='POST' name='byuser'>
<input type='text' name='searchbyuser' class='required' id='text1' data-trigger='button1' placeholder='Search by User' />
    <input type='submit' name= 'buttonbyuser' id='button1' value='Search'  disabled/>
</form><b style='margin: 100px;'>or</b><br>
<form method='POST' name='byleave'>
<input type='text' name='searchbyleave' class='required' id='text2' data-trigger='button2' placeholder='Search by Leave'/>
    <input type='submit' name='buttonbyleave' id='button2' value='Search'  disabled/>
</form><b style='margin: 100px;'>or</b><br>
<form method='POST' name='bydate'>
<input type='text' name='searchbydate' class='required' id='text3' data-trigger='button3' placeholder='Search by Date: YYYY-MM-DD'/>
    <input type='submit'  name='buttonbydate' id='button3' value='Search'  disabled/>
</form><br>
<?PHP
if (isset($_POST['buttonbyuser'])){
	$searchword = $_POST['searchbyuser'];
	$sql1 = mysql_query("SELECT * FROM incnet.coreUsers WHERE student_id > 0 AND (name LIKE '%$searchword%' OR lastname LIKE '%$searchword%' OR username LIKE '%$searchword%')");
	while ($row1 = mysql_fetch_array($sql1)){
		$search_user_id = $row1['user_id'];
		$search_student_id = $row1['student_id'];
		$search_student_name = $row1['name'] . " " . $row1['lastname'];
		$search_student_class = $row1['class'];
		echo "
		<form method='POST' name='select_user'>
		<input type='hidden' name='select_user_id' value='$search_user_id'>
		<input style='background:none; border:0; font-weight:bold; color:green' type='submit' name='search_user' value='[search]'>" . $search_student_name . " " . $search_student_class . "
		<br></form>";
	}
}

if (isset($_POST['search_user'])){
	echo "
		<hr><table name='table_user' style= 'border: 1px solid black;'><thead>
		<th>Leave</th>
		<th>Departure Bus</th>
		<th>Arrival Bus</th>
		<th>Departure Date</th>
		<th>Arrival Date</th></thead>";
	$desired_user_id = $_POST['select_user_id'];
	$sql9 = mysql_query("SELECT * FROM incnet.coreUsers WHERE user_id = $desired_user_id");
	while ($row9 = mysql_fetch_array($sql9)){
		/*$user_user_displayname = $row9['student_id'] . " " . $row9['name'] . " " . $row9['lastname'] . " " . $row9['class'];*/
		$user_user_displayname = $row9['name'] . " " . $row9['lastname'];
	echo "<b> $user_user_displayname </b><br>";	
	}
	$sql8 = mysql_query("SELECT * FROM incnet.weekendDepartures_old WHERE user_id = $desired_user_id");
	while ($row8 = mysql_fetch_array($sql8)){
	$user_dep_bus_id = $row8['dep_bus_id'];
	$user_arr_bus_id = $row8['arr_bus_id'];
	$user_leave_id = $row8['leave_id'];
	$user_dep_date = $row8['dep_date'];
	$user_arr_date = $row8['arr_date'];
	$sql10 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE bus_id = $user_dep_bus_id");
	while ($row10 = mysql_fetch_array($sql10)){
	$user_dep_bus_name = $row10['bus_name'];
	}
	$sql11 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE bus_id = $user_arr_bus_id");
	while ($row11 = mysql_fetch_array($sql11)){
	$user_dep_arr_name = $row11['bus_name'];
	}
	$sql12 = mysql_query("SELECT * FROM incnet.weekendLeaves WHERE leave_id = $user_leave_id");
	while ($row12 = mysql_fetch_array($sql12)){
	$user_leave_name = $row12['leave_name'];
	}
	echo "<tbody>
	<tr>
	<td>$user_leave_name</td>
	<td>$user_dep_bus_name</td>
	<td>$user_dep_arr_name</td>
	<td>$user_dep_date</td>
	<td>$user_arr_date</td>
	</tr>
	</tbody></table>";	
}}

if (isset($_POST['buttonbyleave'])){
	$searchword1 = $_POST['searchbyleave'];
	$sql2 = mysql_query("SELECT * FROM incnet.weekendLeaves WHERE leave_name LIKE '%$searchword1%'");
	while ($row2 = mysql_fetch_array($sql2)){
		$search_leave_day_number = $row2['leave_day_number'] - 1;
		$search_leave_day = $week_name[$search_leave_day_number];
		$search_leave_name = $row2['leave_name'];
		$search_leave_displayname = $search_leave_name . " - " . $search_leave_day;
		$search_leave_id = $row2['leave_id'];
		echo "
		<form method='POST' name='select_leave'>
		<input type='hidden' name='select_leave_id' value='$search_leave_id'>
		<input type='hidden' name='select_leave_name' value='$search_leave_name'>	
		<input style='background:none; border:0; font-weight:bold; color:green' type='submit' name='search_leave' value='[search]'>" . $search_leave_displayname .
		"<br></form>";
	}	
}

if (isset($_POST['search_leave'])){
	echo "<hr><table name='table_leave' style= 'border: 1px solid black;'><thead>
		<th>Student Id</th>
		<th>Student Name</th>
		<th>Class</th>
		<th>Departure Bus</th>
		<th>Arrival Bus</th>
		<th>Departure Date</th>
		<th>Arrival Date</th></thead>";
	$desired_leave_name = $_POST['select_leave_name'];
	//echo $desired_leave_name;
	$desired_leave_id = $_POST['select_leave_id'];
	//echo $desired_leave_id;
	$sql13 = mysql_query("SELECT * FROM incnet.weekendDepartures_old WHERE leave_id = '$desired_leave_id'");
	while ($row13 = mysql_fetch_array($sql13)){
	$leave_user_id = $row13['user_id'];
	$leave_dep_bus_id = $row13['dep_bus_id'];
	$leave_arr_bus_id = $row13['arr_bus_id'];
	$leave_dep_date = $row13['dep_date'];
	$leave_arr_date = $row13['arr_date'];
	$sql14 = mysql_query("SELECT * FROM incnet.coreUsers WHERE user_id = '$leave_user_id'");
	while ($row14 = mysql_fetch_array($sql14)){
		$leave_student_id = $row14['student_id'];
		$leave_student_name = $row14['name'] . " " . $row14['lastname'];
		$leave_student_class = $row14['class'];}
	$sql15 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE bus_id = $leave_dep_bus_id");
	while ($row15 = mysql_fetch_array($sql15)){
		$leave_dep_bus_name = $row15['bus_name'];}
	$sql16 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE bus_id = $leave_arr_bus_id");
	while ($row16 = mysql_fetch_array($sql16)){
		$leave_arr_bus_name = $row16['bus_name'];}
	echo "<tbody>
	<tr>
	<td>$leave_student_id</td>
	<td>$leave_student_name</td>
	<td>$leave_student_class</td>
	<td>$leave_dep_bus_name</td>
	<td>$leave_arr_bus_name</td>
	<td>$leave_dep_date</td>
	<td>$leave_arr_date</td>
	</tr>";
	}echo "</tbody></table>";	
}

if (isset($_POST['buttonbydate'])){
	echo "
	<hr><table name='table_date' style= 'border: 1px solid black;'><thead>
	<th>Student Id</th><th>Student Name</th>
	<th>Class</th><th>Leave</th>
	<th>Departure Bus</th><th>Arrival Bus</th>
	<th>Departure Date</th><th>Arrival Date</th>
	<th>Situation</th></thead><tbody>";
	$searchword2 = $_POST['searchbydate'];
	$sql3 = mysql_query("SELECT * FROM incnet.weekendDepartures_old WHERE dep_date='$searchword2' OR arr_date='$searchword2'");
	while ($row3 = mysql_fetch_array($sql3)){
		$search_date_user_id = $row3['user_id'];
		$sql4 = mysql_query("SELECT * FROM incnet.coreUsers WHERE user_id = $search_date_user_id");
		while ($row4 = mysql_fetch_array($sql4)){
			$search_date_student_id = $row4['student_id'];
			$search_date_student_name = $row4['name'] . " " . $row4['lastname'];
			$search_date_student_class = $row4['class'];
		}
		$search_date_dep_busid = $row3['dep_bus_id'];
		$sql5 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE bus_id=$search_date_dep_busid");
		while ($row5 = mysql_fetch_array($sql5)){
			$search_date_dep_busname = $row5['bus_name'];}
		$search_date_arr_busid = $row3['arr_bus_id'];
		$sql6 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE bus_id=$search_date_arr_busid");
		while ($row6 = mysql_fetch_array($sql6)){
			$search_date_arr_busname = $row6['bus_name'];}
		$search_date_leave_id = $row3['leave_id'];
		$sql7 = mysql_query("SELECT * FROM incnet.weekendLeaves WHERE leave_id=$search_date_leave_id");
		while ($row7 = mysql_fetch_array($sql7)){
			$search_date_leave_name = $row7['leave_name'];}
		$search_date_dep_date = $row3['dep_date'];
		$search_date_arr_date = $row3['arr_date'];
		$search_date_sit = $row3['situation'];
		$search_date_sit = $situation[$search_date_sit];
		echo "
		<tr><td>$search_date_student_id</td>
		<td>$search_date_student_name</td>
		<td>$search_date_student_class</td>
		<td>$search_date_leave_name</td>
		<td>$search_date_dep_busname</td>
		<td>$search_date_arr_busname</td>
		<td>$search_date_dep_date</td>
		<td>$search_date_arr_date</td>
		<td>$search_date_sit</td></tr>";
	}
	echo "
	</tbody></table>";
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

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
//week days array
$week_name = array("","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
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
<h3>Edit Student Permissions Page</h3>
Select Leave to Give Permission:<br><br>
<form name='select_leave' method='GET' action='editstudentpermissions2.php'><select name='selectleave'>
<?PHP
$sql = mysql_query("SELECT * FROM incnet.weekendLeaves");
while ($row = mysql_fetch_array($sql)){
	if ($row['leave_id'] != 5){
		$select_leaveID = $row['leave_id'];
		$select_leaveName = $row['leave_name'];
		$select_leaveDay = $week_name[$row['leave_day_number']];
		echo "
		<option value='$select_leaveID'>$select_leaveName - $select_leaveDay</option>";
	}
}
?>
</select><input type='submit' value='Go' name='submitleave'></form>
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

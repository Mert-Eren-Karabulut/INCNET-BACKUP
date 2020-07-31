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
//week name array
$week_name = array("","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");

//get variable
$selected_leave = $_GET['selectleave'];

//allow query
if (isset($_POST['allow'])){
	$posted_studentID = $_POST['posted_studentID'];
	mysql_query("INSERT INTO incnet.weekendStudentperms VALUES ('$posted_studentID', '$selected_leave')");
}

//block query
if (isset($_POST['block'])){
	$posted_studentID = $_POST['posted_studentID'];
	mysql_query("DELETE FROM incnet.weekendStudentperms WHERE student_id='$posted_studentID' AND leave_id='$selected_leave'");
}
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
<a href='editstudentpermissions.php' style='background:none; text-decoration:none; border:0; color:red; font-weight:bold' type='submit' name='back'>[Back to Leave Selection]</a><br><br>
<table style='border: 1px solid black;'><tr>
<td><b>Student ID</b></td>
<td><b>Fullname</b></td>
<td><b>Class</b></td>
<td><b>City</b></td>
<?PHP
$sql = mysql_query("SELECT * FROM incnet.weekendLeaves WHERE leave_id=$selected_leave");
while ($row = mysql_fetch_array($sql)){
	$selected_leaveName = $row['leave_name'];
	$selected_leaveDay = $week_name[$row['leave_day_number']];
	echo "<td><b>$selected_leaveName - $selected_leaveDay</b></td></tr>";
}
$sql0 = mysql_query("SELECT * FROM incnet.coreUsers WHERE student_id > 0 AND ((class != 'Grad' AND class != '13' AND class != 'Old') OR class IS NULL) ORDER BY class ASC");
while ($row0 = mysql_fetch_array($sql0)){
	$list_userID = $row0['user_id'];
	$list_studentID = $row0['student_id'];
	$student_fullName = $row0['name'] . " " . $row0['lastname'];
	$student_class = $row0['class'];
	$student_city = "";
	$sql1 = mysql_query("SELECT * FROM incnet.profilesMain WHERE user_id=$list_userID");
	while ($row1 = mysql_fetch_array($sql1)){
		$student_city = $row1['il'];}
	echo "
	<tr><td>$list_studentID</td>
			<td>$student_fullName</td>
			<td>$student_class</td>
			<td>$student_city</td>";
	$student_perm = 0;
	$sql2 = mysql_query("SELECT * FROM incnet.weekendStudentperms WHERE student_id=$list_userID AND leave_id=$selected_leave");
	while ($row2 = mysql_fetch_array($sql2)){
		$student_perm = 1;}
	if ($student_perm == 1){
		echo "
		<td><form name='block' method='POST'>
		<input type='hidden' name='posted_studentID' value='$list_userID'>
		<input type='submit' style='background:none; border:0; color:green; font-weight:bold;' name='block' value='[Allowed]'>
		</form></td>";
	} else {
		echo "
		<td><form name='allow' method='POST'>
		<input type='hidden' name='posted_studentID' value='$list_userID'>
		<input type='submit' style='background:none; border:0; color:red; font-weight:bold;' name='allow' value='[Blocked]'>
		</form></td>";}
}
?>
</tr></table><br><br>
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

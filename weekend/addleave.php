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
$page_id = "701";
$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='$page_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}
if ($allowance != "1"){
header ("location:login.php");
}
$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}

$teacher_query = mysql_query("SELECT student_id FROM incnet.coreUsers WHERE user_id='$user_id'");
while($teacher_row = mysql_fetch_array($teacher_query)){
	$student_id = $teacher_row['student_id'];
}

if (isset($_POST['addleave'])){
	$new_leave_name = $_POST['leave_name'];
	$new_leave_day_number = $_POST['leave_day'];
	$new_bus_id = $_POST['bus_id'];

$sql = "INSERT into incnet.weekendLeaves (leave_name, leave_day_number, bus_id, leave_group) VALUES ('$new_leave_name', '$new_leave_day_number', '$new_bus_id', '1')";
mysql_query($sql);
}

?>
<!DOCTYPE html>
<html>
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
<h3>Add Leave Page</h3>

<form method='POST' name='add_leave'>
<table><tr>
	<td>Leave name:</td>
	<td><input type='text' name='leave_name'></td>
	</tr><tr>
	<td>Leave day:</td>
	<td><select name='leave_day'>
				<option value='5'>Friday</option>
				<option value='6'>Saturday</option>
				<option value='7'>Sunday</option>
			</select></td>
	</tr><tr>
	<td>Transportation:</td>
	<td><select name='bus_id'>
	<? $sql2 = mysql_query("SELECT * FROM incnet.weekendBuses");
	  while($row2 = mysql_fetch_array($sql2)){
	  	$bus_name = $row2['bus_name'];
	  	$bus_ids = $row2['bus_id'];
	  	echo	"<option value='" . $bus_ids . "'>" . $bus_name . " </option>";				
		}	
		echo	"</select>"?></td>	
</tr></table>	
<input type='submit' name='addleave' value="Add Leave">
</form>

<br><br>
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
</html>

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
$week_name = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");

//state array
$state_array = array("closed", "open");

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
<h3>Edit Global Settings Page</h3>

<?
if (isset($_POST['state'])){
	$new_state = $_POST['state_value'];
	$new_state = ($new_state + 1)%2;
	mysql_query("UPDATE incnet.weekendVars SET value=$new_state WHERE var_id='1'");
} else if (isset($_POST['set_deadline'])){
	$new_day  = $_POST['deadday'];
	$new_hour = $_POST['deadhour'];
	$new_min  = $_POST['deadmin'];
	$new_deadline = array($new_day, $new_hour, $new_min);
	$new_deadline = implode ("-", $new_deadline);
	mysql_query("UPDATE incnet.weekendVars SET value='$new_deadline' WHERE var_id='2'");
}

//vars from db

$sql = mysql_query("SELECT * FROM incnet.weekendVars");
while ($row = mysql_fetch_array($sql)){
	$var_id[] = $row['var_id'];
	$var_value[] = $row['value'];
}

$state = $var_value[0];
$deadline = $var_value[1];
$deadline_expd = explode("-", $deadline);
$deadline_day  = $deadline_expd[0];
$deadline_hour = $deadline_expd[1];
$deadline_min  = $deadline_expd[2];

?>

<form method='POST'>
Apply deadline: 
<select name='deadday'>
<?
foreach ($week_name as $value => $week_day){
	$week_day = htmlspecialchars($week_day);
	$value++;
	if ($value == $deadline_day){
		echo "
		<option selected='yes' value=$value>$week_day</option>";	
	} else {
		echo "
		<option value=$value>$week_day</option>";
	}
} ?>
</select><select name='deadhour'>
<?
$hour = "00";
while ($hour < "24"){
	if ($hour == $deadline_hour){
		echo "
		<option selected='yes' value='$hour'>$hour</option>";
	} else {
		echo "
		<option value='$hour'>$hour</option>";
	}
	$hour = str_pad($hour+1, 2, 0, STR_PAD_LEFT);
} ?>
</select><select name='deadmin'>
<?
$minute = "00";
while ($minute < "60"){
	if ($minute == $deadline_min){
		echo "
		<option selected='yes' value='$minute'>$minute</option>";
	} else {
		echo "
		<option value='$minute'>$minute</option>";
	}
	$minute = str_pad($minute+1, 2, 0, STR_PAD_LEFT);
} ?>
</select><input type='submit' name='set_deadline' value='Set'></form>
<br><form method='POST'>
Weekend Departures Module State: 
<input type='hidden' name='state_value' value='<? echo $state; ?>'>
<input type='submit' name='state' value='<? echo $state_array[$state]; ?>'>
</form>
<br>
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

<?PHP
	error_reporting(0);

$lang = "EN";


session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:login.php");
}
$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];

if (isset($_POST['logoff'])){
	session_destroy();
	header("location:login.php");	
}

include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}

//permissions  
session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:login.php");
}
$user_id = $_SESSION['user_id'];

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='601'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}

if ($allowance != "1"){
	header ("location:../../incnet/login.php");
}


if (isset($_POST['submit'])){
//echo "hello";
	$day = $_POST['slot_day'];
	$start_time = $_POST['start_hour'] . ":" . $_POST['start_minute'];
	$end_time = $_POST['end_hour'] . ":" . $_POST['end_minute'];
	$target = $_POST['student_profile'];

	$sql_query = "INSERT into incnet.poolSlots (day, time_start, time_end, target) VALUES ('$day', '$start_time', '$end_time', '$target')";
	echo  $sql_query;
	mysql_query($sql_query);
	header("location:index.php");
}
?>

<HTML>
<head>
<!--<title>In?net | Pool Reservations<title>-->
<link rel="shortcut icon" href="../../incnet/favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="incnet.css" type="text/css" media="screen" title="no title" charset="utf-8">
</head>
	<div class="top_menubar">
	<?PHP echo $fullname; ?>
	</div>
<br><br>
<div class="page_logo_container">
<table><tr>
<td><a href="index.php"><img src="../../incnet/incnet.png" width="120" border=0/></a><br>


</td>
<td width="3"></td>
<td bgcolor="black" width=0.1px>
<td width="3"></td>
<td valign="middle">
<br>
<b>Add Slot</b>
<form name="newslot"  method="POST">
<table>
	<tr>
		<td>Day: </td>
		<td>
			<select name='slot_day'>
				<option value='1'>Monday</option>
				<option value='2'>Tuesday</option>
				<option value='3'>Wednesday</option>
				<option value='4'>Thursday</option>
				<option value='5'>Friday</option>
				<option value='6'>Saturday</option>
				<option value='7'>Sunday</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Starting Time:</td>
		<td><input type="text" name="start_hour" maxlength="2" size="1">:<input type="text" name="start_minute" maxlength="2" size="1"></td>
	</tr>
	<tr>
		<td>End Time:</td>
		<td><input type="text" name="end_hour" maxlength="2" size="1">:<input type="text" name="end_minute" maxlength="2" size="1"></td>
	</tr>
	<tr>
		<td>For:</td>
		<td>
			<select name="student_profile">
				<option value="swimmers">Swimmers</option>
				<option value="nonswimmers">Non-Swimmers</option>
				<option value="teacher">Teachers</option>
				<option value="personnel">Personnel</option>
			</select>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Add Slot"></td>
	</tr>
	
	
</table>
</form>
<br><br>
</td>
</tr></table>
<div>
<br><br><br>
<div class="logoff_button">
<form name="logoff" method="POST">
<?PHP if ($lang == "EN") {$logoff_string="Log Off";} else if ($lang == "TR") {$logoff_string="Çıkış Yap"; } ?>
<input type ="submit" name="logoff" value="<? echo $logoff_string; ?>">
</form>
</div>


<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2012 Levent Erol</a>
</div>
</HTML>

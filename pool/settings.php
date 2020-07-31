<?PHP
	error_reporting(0);
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

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='601'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}

if ($allowance != "1"){
	header ("location:../../incnet/login.php");
}

//Update vars from db
if (isset($_POST['save'])){
	$new_quota = $_POST['quota'];
	$new_maxres = $_POST['maxres'];
	$new_hrstores = $_POST['hrstores'];
	$new_teachers_maxres = $_POST['teachers_maxres'];

$query1 = "UPDATE incnet.poolVars SET value='$new_quota' WHERE var_id='1'";
$query2 = "UPDATE incnet.poolVars SET value='$new_maxres' WHERE var_id='2'";
$query3 = "UPDATE incnet.poolVars SET value='$new_hrstores' WHERE var_id='3'";
$query4 = "UPDATE incnet.poolVars SET value='$new_teachers_maxres' WHERE var_id='6'";

mysql_query($query1);
mysql_query($query2);
mysql_query($query3);
mysql_query($query4);
//echo $query1;
//echo $query2;

header("location:index.php");
}

if (isset($_POST['openclose'])){
	$openclose_newstate = $_POST['openclose'];

	if ($openclose_newstate == "Close"){//close the pool
		mysql_query("UPDATE incnet.poolVars SET value='closed' WHERE var_id='5'");
	} else if ($openclose_newstate == "Open"){//open the pool
		mysql_query("UPDATE incnet.poolVars SET value='open' WHERE var_id='5'");
	}
}

//Getting the vars from the db
$sql1 = mysql_query("SELECT * FROM incnet.poolVars");
while($row1 = mysql_fetch_array($sql1)){
	$var_id[] = $row1['var_id'];
	$var_value[] = $row1['value'];
}

$quota = $var_value[0];
$maxres = $var_value[1];
$hrstores = $var_value[2];
$openclose = $var_value[4];
$teachers_maxres = $var_value[5];

//echo $openclose;

$openclose_string = "The pool is currently $openclose";

if ($openclose == "open"){
	$openclose_value = "Close";
} else {
	$openclose_value = "Open";
}

/*
if (isset($_POST['reset_week'])){
mysql_query("INSERT INTO incnet.poolRecords_old SELECT * FROM pool.records");
mysql_query("DELETE FROM incnet.poolRecords");
header("location:index.php");
}
*/

?>

<HTML>
<head>
<!--<title>In?net | Pool Reservations<title>-->
<link rel="shortcut icon" href="favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="incnet.css" type="text/css" media="screen" title="no title" charset="utf-8">
<body OnLoad="document.settings.quota.focus();">
</head>
	<div class="top_menubar">
	<?PHP echo $fullname; ?>
	</div>
<br><br>
<div class="page_logo_container">
<table><tr>
<td><a href="index.php"><img src="../incnet/incnet.png" width="120" border=0/></a><br>


</td>
<td width="3"></td>
<td bgcolor="black" width=0.1px>
<td width="3"></td>
<td valign="middle">
<h3>Pool Settings</h3>

<form name='settings' method='POST'>
	<table>
		<tr>
			<td>Quota:</td>
			<td> <input type='text' size='3' name='quota' value="<? echo $quota; ?>">people/slot</td>
		</tr>
		<tr>
			<td>Max Reservations/week for students: </td>
			<td> <input type='text' size='3' name='maxres' value="<? echo $maxres; ?>">reservations/week</td>
		</tr>
		<tr>
			<td>Max Reservations/week for teachers: </td>
			<td> <input type='text' size='3' name='teachers_maxres' value="<? echo $teachers_maxres; ?>">reservations/week</td>
		</tr>
		<tr>
			<td>Hours before list closes: </td>
			<td> <input type='text' size='3' name='hrstores' value="<? echo $hrstores; ?>"></td>
		</tr>
		
		<tr><td></td>
			<td><input type='submit' name='save' value='Save Settings'></form></td></tr><tr><td colspan=2>
			<form method='POST'><br><br><? echo $openclose_string; ?> <input type='submit' name='openclose' value="<? echo $openclose_value ?>"></form></td></td>

	</table>

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
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2012 Levent Erol</a>
</div>
</HTML>

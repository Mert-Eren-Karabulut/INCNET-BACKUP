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
mysql_select_db("incnet");

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}

$teacher_query = mysql_query("SELECT student_id FROM incnet.coreUsers WHERE user_id='$user_id'");
while($teacher_row = mysql_fetch_array($teacher_query)){
	$student_id = $teacher_row['student_id'];
}

if(isset($_POST['delete'])){
	$deleteId = mysql_real_escape_string($deleteId);
	$sql = "DELETE FROM weekend2busses WHERE bus_id=$_POST[deleteId]";
	mysql_query($sql) or die(mysql_error()."\n$sql");
}
?>
<!DOCTYPE html>
<HTML>
<head>
<title>Inçnet | Weekend Departures</title>
<link rel="shortcut icon" href="favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
<style>
	table#leaves td{
		padding: 5px;
	}
	table#leaves th{
		padding: 5px;
	}
	
	button.link {
		background: none!important;
		color: inherit;
		border: none;
		padding: 0!important;
		font: inherit;
		cursor: pointer;
	}
	button.link:hover {
		border-bottom: 1px solid #444;
	}
</style>
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
<h3>Edit Buses</h3>
<table id=leaves>
<tr>
	<th>Bus ID</th><th>Bus Name</th><th>Direction</th><th>Delete</th>
</tr>
<?php
	$sql = "SELECT * FROM weekend2busses";
	$res = mysql_query($sql);
	while($row = mysql_fetch_assoc($res)){
		$direction = (($row['direction'] == "0") ? "Departure" : (($row['direction'] == "1") ? "Arrival" : "Two-Way"));
		echo("</td><td>$row[bus_id]</td><td>$row[bus_name]</td><td>$direction</td><td><form method=POST action=#><button class=link type=submit name=delete value=delete>delete</button><input type=hidden name=deleteId value=$row[bus_id]></form>"."</td></tr>");
	}
?>
</table>
</td>
</tr></table>
</div>
<br><br><br>
<div class="logoff_button">
<form name="logoff" method="POST">
<input type ="submit" name="logoff" value="Log Off">
</form></div>
<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2018 INCNET</a>
</div>
</body>
</HTML>
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

if(isset($_POST['delete']) && deleteId != 5){
	$deleteId = mysql_real_escape_string($deleteId);
	$sql = "DELETE FROM weekend2leaves WHERE leave_id=$_POST[deleteId]";
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
<h3>Edit Leaves</h3>
Note: Since deleting <i>Home</i> or changing its <i>leave_id</i> would instantly break many systems, this page does not allow editing <i>Home</i>.
<table id=leaves>
<tr>
	<th>Leave ID</th><th>Leave Name</th><th>Associated Buses</th><th>Day</th><th>Group</th><th>Delete</th>
</tr>
<?php
	$sql = "SELECT * FROM weekend2leaves";
	$res = mysql_query($sql);
	while($row = mysql_fetch_assoc($res)){
		$temp = explode(",", $row['assoc_busses']);
		foreach($temp as $bus){ 	
			$sql2 = "SELECT * FROM weekend2busses WHERE bus_id=$bus";
			$res2 = mysql_query($sql2);
			$row2 = mysql_fetch_assoc($res2);
			$buses[] = $row2['bus_name'];
		}
		echo("<tr><td>$row[leave_id]</td><td>$row[leave_name]</td><td>");
		foreach($buses as $bus){
			$thing.=", $bus";
		}
		if($thing == ", ") $thing = "  <i>N/A</i>";
		$thing = substr($thing, 2);
		echo $thing;
		unset($thing, $buses, $temp);
		echo("</td><td>$row[day]</td><td>$row[group]</td><td>".($row['leave_id'] == 5 ? "" : "<form method=POST action=#>(<button class=link type=submit name=delete value=delete>delete</button>)<input type=hidden name=deleteId value=$row[leave_id]></form>")."</td></tr>");
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
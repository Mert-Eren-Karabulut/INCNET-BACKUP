<!DOCTYPE html>
<HTML>
﻿<?PHP
	if(isset($_GET['redir'])){
		echo("test");
		header("Location: http://incnet.tevitol.org/".$_GET['redir']);
	}
	
require_once '../mobile_detect/Mobile_Detect.php';
$detect = new Mobile_Detect;
if (!($detect->isMobile())){
	header("location:../../incnet/index.php");
}
session_start();
if ((!(isset($_SESSION['user_id'])))||(!($_SESSION['user_id'])>0)){
	session_destroy;
	header("location:login.php");
	//$newPage = "<meta http-equiv='refresh' content='0; url=login.php'>";
}

var_dump($_SESSION);

if(isset($_SESSION['user_id']) && isset($_GET['continue'])) header("Location:http://incnet.tevitol.org/".str_replace("\n", "", $_GET['continue']));

if ($_SESSION['passchange']=="must"){
	header("location:must_change_pass.php");
}


$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];

if (isset($_POST['logoff'])){
	session_destroy();
	setcookie("remember", "", time()-3600);
	header("location:login.php");
	//$newPage = "<meta http-equiv='refresh' content='0; url=login.php'>";
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

$type_query = mysql_query("SELECT student_id, type FROM incnet.coreUsers WHERE user_id='$user_id'");
while($type_row = mysql_fetch_array($type_query)){
	$student_id = $type_row['student_id'];
	$user_type = $type_row['type'];
}

?>

	<head>
				<title>Inçnet</title>
		<link rel="shortcut icon" href="favicon.ico" >
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
<style>
body {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	font-size: 14px;
}


form { margin: 0; }



.mobilebutton {
	color:white;
	background:#c1272d ;
	width:94%;
	left:3%;
	height:130px;
	font-size: 40pt;
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	text-shadow:5px 5px 7px black;
	box-shadow:6px 6px 5px black;
	border:1;
	position:relative;
	margin-top:40px;
}
.mobileimage{
	position:relative;
	display:block;
	margin-left: auto;
	margin-right: auto;
	margin-top:100px;
	height:500px;
}

.header {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	z-index:1;
	font-size:38pt;
	position: fixed;
	width: 100%;
	padding-bottom:14px;
	padding-top:14px;
	color: white;
	left: 0px;
	background-color: #c1272d;
	top: 0px;
	text-align:right;
	text-decoration:none;
}


.mobilepart{
	width:100%;height:90%
}

#bottomButton{
	top:200px;
	margin-bottom:100px;
	color:white;
}
.taplogoff{
	color:white;
	opacity:0.5;
	text-align:left;
	position:absolute;
}
</style>
</head>
	<body>
		<a href='logoff.php'>
			<div class="header"><div class='taplogoff'>&nbsp; Tap to log off</div>
				<? echo $fullname; ?> 	&nbsp;
			</div>
		</a>

				<a href="index.php">		<img src='./incnet.png' class='mobileimage' style='top:10px;'></a>
				<a href="checkin.php"> 		<button class="mobilebutton" > 	Checkin			</button></a>
				<a href="pool.php">		<button class="mobilebutton" >	Pool Reservations	</button></a>
				<a href="etut.php">		<button class="mobilebutton" >	Etut Reservations	</button></a>
				<a href="exam.php">		<button class="mobilebutton" >	Exam Schedule	</button></a>
				<a href="weekend.php">		<button class="mobilebutton" >	Weekend Departures	</button></a>
				<a href="bulletinmobile.php">	<button class="mobilebutton" >	Weekly Bulletin		</button></a>
				<a href="changepass.php">	<button class="mobilebutton" >	Change Password		</button></a>

	</body>
</HTML>

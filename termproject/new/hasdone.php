<?php
	error_reporting(0);
	
	//connect to mysql server
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}
	
	session_start();
	if (!(isset($_SESSION['user_id']))){
		$newPage = "<meta http-equiv='refresh' content='0; url=../incnet/login.php'>";
	}
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$lang = $_SESSION['lang'];
	
	if (isset($_POST['logoff'])){
		session_destroy();
		$newPage = "<meta http-equiv='refresh' content='0; url=../incnet/index.php'>";
	}
	
	mysql_select_db("incnet");
	
	function spaceToCamelCase($s){
		$arr = str_split($s);
		$str = "";
		$upper = false;
		foreach($arr as $c){
			if($upper){
				$str.=strtoupper($c);
				$upper = false;
			}else{
				if($c == " "){
					$upper = true;
				}else{
					$str.=$c;
				}
			}
		}
		return lcfirst($str);
	}
	$classes = array("Fizik", "Kimya", "Biyoloji");
	$teachers = array(array("Ersin Toy", "Sema Bakioğlu"), array("Haşla-man!", "Nihal İkizoğlu"), array("Samet Teke", "Evren Toy"));
	$allTeachersCamel = array("ersinToy", "semaBakioğlu", "haşla-man!", "nihalİkizoğlu", "sametTeke", "evrenToy");
	$allTeachers = array("Ersin Toy", "Sema Bakioğlu", "Haşla-man!", "Nihal İkizoğlu", "Samet Teke", "Evren Toy");
	
	$chk = 0;
	$sql = "SELECT user_id FROM corepermits WHERE user_id = $user_id AND page_id = 1002";
	$query = mysql_query($sql);
	while($row=mysql_fetch_array($query)){
		$chk=$row[0];
	}
	if ($chk>0){
		$printPetitions = true;
	}
	
	$chk = 0;
	$sql = "SELECT user_id FROM corepermits WHERE user_id = $user_id AND page_id = 1001";
	$query = mysql_query($sql);
	while($row=mysql_fetch_array($query)){
		$chk=$row[0];
	}
	if ($chk>0){
		$viewLists = true;
	}
	function camelCaseToSpaceTitle($s){
		$arr = str_split($s);
		$str = "";
		foreach($arr as $c){
			if(ctype_upper($c)){
				$str.=" ";
			}
			$str.=$c;
		}
		return ucfirst($str);
	}
	
	
	?>
<HTML>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="shortcut icon" href="../../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<title>INÇNET | Term Project Selections</title>
		<style>
			h1{
				color: #c1272d;
				font-size: 16pt;
			}
			label{
				margin: 5px;
				margin-top:10px;
			}
			select{
				margin: 5px;
				margin-top: 10px;
			}
		</style>
	</head>
  
	
	<body OnLoad="document.reservations.seat.focus();">
		<div class="header">
			<?PHP echo $fullname; ?>
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='../../incnet' style="margin-bottom: 40px; display: block;"><img style='position: relative; top:20px; ' src='../../img/etut.png' width='140px'></a>
					<? if($printPetitions) echo "<div style=\"color: black; margin-bottom: 5px; display: block;\"><a style=\"color: black;\" href=./word-test.php>Print Petitions</a></div>"; ?>
					<? if($viewLists) echo "<div style=\"margin-bottom: 5px; display:block; \"><a style=\"color: black;\" href=./view_lists.php>View Lists</a></div>"; ?>
				</td>
				<div style='position:absolute; bottom:30px; z-index:2;' >
					<form name="logoff" method="POST">
						<input type ="submit" name="logoff" value="Log Off">
					</form>
				</div>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<div style="margin: 8px; margin-top:15px;">
						<h1>Term Project Selections for 2017-2018</h1>
						You have selected your projects. If you want to change them, please contact an admisintrator.<br/>
						The term projects you have selected are:
						<ol>
							<?php
								$sql = "SELECT * FROM termproject_entries WHERE user_id=$user_id ORDER BY number ASC";
								$result = mysql_query($sql);
								while($row = mysql_fetch_assoc($result)){
									if($row['real'] == 1) echo "<b>";
									echo("<li>".camelCaseToSpaceTitle($row['lesson'])." from ".$allTeachers[array_search($row['teacher'], $allTeachersCamel)]."</li>");
									if($row['real'] == 1) echo "</b>";
								}
							?>
						</ol>
					</div>
				</td>
			</tr>
		</table>
		<div class="copyright">&nbsp © INCNET</div>
    <p style="display:none;"><? echo $msg; ?></p>
	</body>
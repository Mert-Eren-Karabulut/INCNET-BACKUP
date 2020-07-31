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
	
	$chk = 0;
	$sql = "SELECT user_id FROM termproject_entries WHERE user_id = $user_id";
	$query = mysql_query($sql);
	while($row=mysql_fetch_array($query)){
		$chk=$row[0];
	}
	if ($chk>0){
		header("location:hasdone.php");
		die();
	}
	
	function has_dupes($array) {
		$dupe_array = array();
		foreach ($array as $val) {
			if (++$dupe_array[$val] > 1) {
				return true;
			}
		}
		return false;
	}
	
	if(isset($_POST['go'])){
		if($_POST['option1'] == "none" || $_POST['option2'] == "none" || $_POST['option3'] == "none" || $_POST['option4'] == "none" || $_POST['option5'] == "none") echo("<script>alert(\"Please complete all fields!\");</script>");
		else if(has_dupes(array($_POST['option1'], $_POST['option2'], $_POST['option3'], $_POST['option4'], $_POST['option5'])) && false){
			echo("<script>alert(\"You cannot select the same lesson twice!\");</script>");
		}else{
			for($i = 1; $i <= 5; $i++){
				$sql = "INSERT INTO `termproject_entries`(`entry_id`, `user_id`, `teacher`, `lesson`, `real`, `number`) VALUES (0, $user_id, '".mysql_real_escape_string($_POST['teacher'.$i])."', '" . mysql_real_escape_string($_POST['option'.$i]) ."', " . ((($i == 1) || (($i == 2) && isset($_POST['second']))) ? 1 : 0) . ", " . $i . ")";
				//echo $sql;
				mysql_query($sql);
			}
			
			header("location:hasdone.php");
			die();
		}
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
				<form style="margin: 8px; margin-top:15px;" action=# method=POST>
					<h1>Term Project Selections for 2017-2018</h1>
					<?
						for($i=1; $i <= 5; $i++){
							echo("<label for=option$i>Option $i:<label><select onchange=onUpdate($i); id=option$i name=option$i><option value='none'></option>");
							foreach($classes as $class){
								echo"<option value='".spaceToCamelCase($class)."'>$class</option>";
							}
							echo("</select><label for=teacher$i>&nbsp;from&nbsp;</label><select class='findme$i' name=teacher$i readonly><option selected>(please select lesson)</option></select><br>");
						}
					?>
					<div style="margin: 10px; margin-left: 5px;"><input type=checkbox name=second value=second><label for=second>I want a second term project (option 2 will be your second project)</div>
					<span style="color: grey">Note 1: You will be assigned your first choice. The rest are for legal reasons only.</span><br/>
					<span style="color: grey">Note 2: Please only select your own teachers.</span><br/><br/>
					<button type=button id=findMeSubmit name=go value=Submit onclick="if(confirm('Are you sure you want to select these classes? You will not be able to change them after submitting.')){ $('#findMeSubmit').attr('type', 'submit');setTimeount(function(){$('#findMeSubmit').click();}, 100);}"/>Submit</button>
				</form>
				</td>
			</tr>
		</table>
		<script>
			
			var teachers = [["Ersin Toy", "Sema Bakioğlu"], ["Haşla-man!", "Nihal İkizoğlu"], ["Samet Teke", "Evren Toy"]];
			var teachersCamel = [["ersinToy", "semaBakioğlu"], ["haşla-man!", "nihalİkizoğlu"], ["sametTeke", "evrenToy"]];
			var lessons = ["fizik", "kimya", "biyoloji"];
			
			var quotas = {};
			
			function onUpdate(id){
				var lessonIndex = lessons.indexOf($('#option' + id)[0].value);
				if(lessonIndex == -1){
					$('.findme' + id).html("<option selected>(please select lesson)</option>");
				}
				var anneninki = "";
				for(i = 0; i < teachers[lessonIndex].length; i++){
					anneninki += "<option value=" + teachersCamel[lessonIndex][i] + ">" + teachers[lessonIndex][i] + "</option>";
				}
				$('.findme' + id).html(anneninki);
			}
			
			
		</script>
		<div class="copyright">&nbsp © INCNET</div>
    <p style="display:none;"><? echo $msg; ?></p>
	</body>
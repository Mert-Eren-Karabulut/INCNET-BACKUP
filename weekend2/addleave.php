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

$days = explode(",","Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday"); //IK weeks don't begin with sundays but the idiot who wrote the date() function thinks they do...

$sql = "SELECT * FROM weekend2busses ORDER BY bus_name ASC";
$res = mysql_query($sql) or die(mysql_error());

while($row = mysql_fetch_assoc($res)){
	$busses[$row['bus_id']] = $row['bus_name']." ".($row['direction'] == 2 ? "" : ($row['direction'] == 1 ? "Arrival" : "Departure"));
}

if(isset($_POST['save'])){
	//echo "<pre>";
	//var_dump($_POST);
	//echo "</pre>";
	foreach($_POST as $post){
		if(substr(array_search($post, $_POST), 0, 3) === "bus"){
			//echo "<pre>$post</pre>";
			$selected_busses[] = $post;
		}else{
			//echo "<pre>".substr(array_search($post, $_POST), 0, 3)." !== \"bus\"</pre>";
		}
	}
	$assoc_busses = implode(",", $selected_busses);
	$sql = "INSERT INTO weekend2leaves(leave_id, leave_name, assoc_busses, day, `group`) VALUES (0, '".mysql_real_escape_string($_POST['name'])."', '$assoc_busses', '".mysql_real_escape_string($_POST['day'])."', ".(isset($_POST['group']) ? "0" : "1").")";
	echo "<pre>".$sql."</pre>";
	mysql_query($sql);
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
<td><a href="index.php"><img src="weekend.png" width="120px" border=0 /></a><br>
</td>
<td width="5px"></td>
<td bgcolor="black" width=0.1px>
<td width="3px"></td>
<td valign="middle">
<h3>Add Leave</h3>
<form method=POST action=#>
	<table>
		<tr>
			<td><label for=name>Leave Name</label></td>
			<td><input type=text id=name name=name></td>
		</tr>
		<tr>
			<td><label for=busses>Bus</label></td>
			<td>
					
					<?php
						if(!$busses) $busses = array("Test 1", "Test 2", "Test 3");
						foreach($busses as $bus){
							$i = array_search($bus, $busses);
							echo("<input type=checkbox id=bus$i name=bus$i value=$i style=\"cursor: pointer;\"></input><label for=bus$i style=\"cursor: pointer;\">$bus</label><br/>\n"); 
						}
					?>
			</td>
		</tr>
		<tr>
			<td><label for=day>Day</label></td>
			<td>
				<select name=day id=day>
					
					<?php
						$i = 0;
						foreach($days as $day){
							echo("<option type=checkbox value=".$i++.">$day</option>n"); 
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan=2><input style="cursor: pointer;" type=checkbox id=group name=group> <label style="cursor: pointer;" for=group>Bypass weekly limit</label></td>
		</tr>
		<tr><td><br/><input type=Submit value=Save name=save /></td></tr>
</form>
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
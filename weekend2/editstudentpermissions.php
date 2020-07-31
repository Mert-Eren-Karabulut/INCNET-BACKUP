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

if(isset($_POST['ban'])){
	$temp = explode(";", mysql_real_escape_string($_POST['ban']));
	$sql = "SELECT * FROM coreusers WHERE username='$temp[0]'";
	$res = mysql_query($sql) or die(mysql_error()."<br/> $sql");
	$row = mysql_fetch_assoc($res);
	$ban_user_id = $row['user_id'];
	$ban_id = $temp[1];
	unset($temp);
	
	$sql = "INSERT INTO weekend2bans(user_id, leave_ids) VALUES ($ban_user_id, '$ban_id') ON DUPLICATE KEY UPDATE leave_ids=CONCAT(`leave_ids`,',','$ban_id')";
	
	mysql_query($sql) or die(mysql_error()."<br/> $sql");
}else if(isset($_POST['unban'])){
	$temp = explode(";", mysql_real_escape_string($_POST['unban']));
	$sql = "SELECT * FROM coreusers WHERE username='$temp[0]'";
	$res = mysql_query($sql) or die(mysql_error()."<br/> $sql");
	$row = mysql_fetch_assoc($res);
	$unban_user_id = $row['user_id'];
	$unban_id = $temp[1];
	unset($temp);
	
	$sql = "SELECT * FROM weekend2bans WHERE user_id=$unban_user_id";
	$res = mysql_query($sql) or die(mysql_error()."<br/> $sql");
	$row = mysql_fetch_assoc($res);
	$replaced = str_replace($unban_id.",", "", $row['leave_ids']);
	$replaced = str_replace(",".$unban_id, "", $replaced);
	if(strpos($replaced, ",") === false) $replaced = "";
	$sql = "UPDATE weekend2bans SET leave_ids='$replaced'";
	mysql_query($sql) or die(mysql_error()."<br/>$sql");
}

$check = "&#10003;";
$cross = "&#128473;";
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
		border: 1pt solid black;
	}
	table#leaves th{
		border: 1pt solid black;
	}
	
	button.link {
		background: none!important;
		color: inherit;
		border: none;
		padding: 0!important;
		font: inherit;
		cursor: pointer;
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
<td style="vertical-align: top; padding-top: 20px;"><a href="index.php"><img src="weekend.png" width="120px" border=0 /></a><br>
</td>
<td width="5px"></td>
<td bgcolor="black" width=0.1px>
<td width="3px"></td>
<td valign="middle">
<h3>Edit Student Leave Permission</h3>
<table id=leaves>
<tr>
	<th>Student ID</th><th>Student Name</th> <? 
			$sql = "SELECT * FROM weekend2leaves ORDER BY leave_id ASC";
			$res = mysql_query($sql);
			while($row = mysql_fetch_assoc($res)){
				$leaves[] = $row;
				echo("<th>$row[leave_name]</th>");
			}
		?>
</tr>
<?php
	$current = "(class LIKE 'Hz' OR class LIKE '9' OR class LIKE '10' OR class LIKE '11IB' OR class LIKE '11MEB' OR class LIKE '12IB' OR class LIKE '12MEB') AND (type NOT LIKE 'grad' AND type NOT LIKE 'old')";
	$sql = "(SELECT * FROM coreusers LEFT JOIN weekend2bans ON weekend2bans.user_id=coreusers.user_id WHERE type LIKE 'student' AND $current ORDER BY student_id ASC) UNION (SELECT * FROM coreusers RIGHT JOIN weekend2bans ON weekend2bans.user_id=coreusers.user_id WHERE type LIKE 'student' AND $current ORDER BY student_id ASC) ORDER BY student_id ASC";
	$res = mysql_query($sql);
	while($row = mysql_fetch_assoc($res)){
		echo("<tr><td>$row[student_id]</td><td>$row[name] $row[lastname]</td>");
		foreach($leaves as $leave){
			$banned = array_search($leave['leave_id'], explode(",", $row['leave_ids']));
			echo("<td style=\"text-align: center;\"><form action=# method='POST'><button type=submit class=link>".($banned === false ? $check : $cross)."</button><input type=hidden name=".($banned === false ? "": "un")."ban value=".$row['username'].";$leave[leave_id]></form></td>");
		}
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





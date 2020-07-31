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
if(isset($_POST['go'])){
	$sql = "INSERT INTO weekend2departures(`departure_id`, `user_id`, `dep_bus_id`, `arr_bus_id`, `leave_id`, `dep_date`, `arr_date`, `active`) VALUES (0, $_POST[user], $_POST[depBus], $_POST[arrBus], $_POST[leave], '$_POST[depDate]', '$_POST[arrDate]', 1)";
	echo $sql;
	mysql_query($sql) or die(mysql_errno().": ".mysql_error()."<br/>$sql");
}
?>
<!DOCTYPE html>
<HTML>
<head>
<title>Inçnet | Weekend Departures</title>
<link rel="shortcut icon" href="favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel=stylesheet href="./jquery-ui-1.12.1.custom/jquery-ui.min.css" type="text/css">
<link rel=stylesheet href="./jquery-ui-1.12.1.custom/jquery-ui.structure.css" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="./jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script>
	$(function(){
		if ( $('[type="date"]').prop('type') != 'date' ) {
			$('[type="date"]').datepicker();
		}
		$("input.date").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
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
<h3>Add Departure</h3>
	<form method=POST action=#>
		<table>
			<tr>
				<td><label for=user>User</label></td>
				<td>
					<select name=user id=user><?php
							$current = "(class LIKE 'Hz' OR class LIKE '9' OR class LIKE '10' OR class LIKE '11IB' OR class LIKE '11MEB' OR class LIKE '12IB' OR class LIKE '12MEB') AND (type NOT LIKE 'grad' AND type NOT LIKE 'old')";
							$sql = "SELECT * FROM coreusers WHERE $current OR type LIKE 'teacher' ORDER BY name ASC";
							$res = mysql_query($sql) or die("</select>".mysql_error()."<br/>$sql");
							while($row = mysql_fetch_assoc($res)){
								echo("\n\t\t\t\t\t\t<option value=$row[user_id]>$row[name] $row[lastname]</option>");
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for=depDate>Departure Date</label></td>
				<td><input type=text name=depDate id=depDate class=date></td>
			</tr>
			<tr>
				<td><label for=depDate>Arrival Date</label></td>
				<td><input type=text name=arrDate id=arrDate class=date></td>
			</tr>
			<tr>
				<td><label for=depBus>Departure Bus</label></td>
				<td>
					<select name=depBus id=depBus><?php
							$sql = "SELECT * FROM weekend2busses";
							$res = mysql_query($sql) or die("</select>".mysql_error()."<br/>$sql");
							while($row = mysql_fetch_assoc($res)){
								echo("\n\t\t\t\t\t\t<option value=$row[bus_id]>$row[bus_name]</option>");
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for=arrBus>Arrival Bus</label></td>
				<td>
					<select name=arrBus id=arrBus><?php
							$sql = "SELECT * FROM weekend2busses";
							$res = mysql_query($sql) or die("</select>".mysql_error()."<br/>$sql");
							while($row = mysql_fetch_assoc($res)){
								echo("\n\t\t\t\t\t\t<option value=$row[bus_id]>$row[bus_name]</option>");
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for=leave>Leave</label></td>
				<td>
					<select name=leave id=leave><?php
							$sql = "SELECT * FROM weekend2leaves";
							$res = mysql_query($sql) or die("</select>".mysql_error()."<br/>$sql");
							while($row = mysql_fetch_assoc($res)){
								echo("\n\t\t\t\t\t\t<option value=$row[leave_id]>$row[leave_name]</option>");
							}
						?>
					</select>
				</td>
			</tr>
		</table>
		<input type=submit name=go value=Save>
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
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2017 INCNET</a>
</div>
</body>
</HTML>

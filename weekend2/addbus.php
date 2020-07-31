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

if(isset($_POST['save'])){
	$assoc_busses = implode(",", $selected_busses);
	$sql = "INSERT INTO weekend2busses(bus_id, bus_name, direction) VALUES (0, '".mysql_real_escape_string($_POST['name'])."', ".mysql_real_escape_string($_POST['direction']).")";
	mysql_query($sql) or die(mysql_error()." $sql");
	echo $sql;
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
<h3>Add Bus</h3>
<form method=POST action=#>
	<table>
		<tr>
			<td><label for=name>Bus Name</label></td>
			<td><input type=text id=name name=name></td>
		</tr>
		<tr>
			<td><label for=direction>Direction</label></td>
			<td>
				<select name=direction id=direction>
					<option value=0>Departure</option>
					<option value=1>Arrival</option>
					<option value=2>2-Way</option>
				</select>
			</td>
		</tr>
		<tr><td><br/><input type=Submit name=save value=Save /></td></tr>
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
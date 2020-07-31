<!DOCTYPE html>
<HTML>
<head>
  <title>Inçnet</title>
	<link rel="shortcut icon" href="favicon.ico" >
	<meta charset="utf-8">
</head>
<?PHP
	error_reporting(0);

session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:login.php");
}
$user_id = $_SESSION['user_id'];
include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}

$page_id = "102";
$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='$page_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}
if ($allowance == "1"){
}else {
header ("location:login.php");
}


if (isset($_POST['reset_password'])){
	$reset_user_id = $_POST['select_user'];
	$new_set_password = $_POST['new_password'];
	$new_set_password = md5($new_set_password);
	$info = "<h1>Password reset successfull</h1>";
//	echo $reset_user_id . "<br>";
//	echo $new_set_password;
	mysql_query("UPDATE incnet.coreUsers SET password='$new_set_password' WHERE user_id='$reset_user_id'");
}
?>

<body>
<form method="POST" name="reset_password">
<br>
<h1>Reset user password:</h1>
<br><br>
<table>
<tr><td>
Select user:
</td>
<td>
<select name="select_user">
<?PHP
$sql1 = mysql_query("SELECT * FROM incnet.coreUsers ORDER by name ASC");
while($row1 = mysql_fetch_array($sql1)){
	$user_displayname = $row1['username'] . " - " . $row1['name'] . " " . $row1['lastname'];
	$user_user_id = $row1['user_id'];
	echo "<option value='" . $user_user_id . "'>" . $user_displayname . " (user id: " . $user_user_id . ")</option>";
}
?>
</select></td></tr>
<tr><td>
Enter new password for the user:</td><td>
<input type="text" name="new_password" value="studentpass" autocomplete="off"></td></tr>
<tr><td align='center' colspan='2'><input type="submit" name="reset_password" value="Reset Password"></td>
</form>
</table>
<a href="index.php"> Back to InçNet Home </a>
</body>
</HTML>

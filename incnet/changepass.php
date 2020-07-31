<?PHP
	error_reporting(0);

session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:login.php");
	}
$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];

include ("db_connect.php");
if (!$con){
  die('Could not connect: ' . mysql_error());
}
mysql_select_db("incnet", $con);

if(isset($_POST['cancel'])){
	header("location:index.php");
}

if (isset($_POST['submit'])){
	$oldpass = $_POST['oldpass'];
	$newpass1 = $_POST['newpass1'];
	$newpass2 = $_POST['newpass2'];
	$newpass_length = strlen($newpass1); 	

	$oldpass = md5($oldpass);
	$newpass1 = md5($newpass1);
	$newpass2 = md5($newpass2);

if($newpass_length<6){
	echo "<center><h3>For security reasons, please use a longer password.</h3></center>";
	//echo $newpass_length;
}else{
	if ($newpass1==$newpass2){
		$result = mysql_query("SELECT * FROM coreUsers WHERE user_id='$user_id'");
		
		while($row = mysql_fetch_array($result)){
			$user_oldpass = $row['password'];
			
			if ($user_oldpass == $oldpass){
				mysql_query("UPDATE coreUsers SET password='$newpass1' WHERE user_id='$user_id'");
				header("location: login.php");
			}else{
			echo "<center><h3>Old password incorrect.</h3></center>";
			}
		}
	
	}else{
	echo "<center><h3>New passwords don't match.</h3></center>";
	}

}
}
?>
<!DOCTYPE html>
<HTML>
<head>
<title>Inçnet | Change Password</title>
<link rel="shortcut icon" href="favicon.ico" >
<meta charset=utf-8>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
</head>
<body OnLoad="document.password_input.oldpass.select();">
<div id="pchange_container"><center>
<table>
<tr><td colspan="6px">
<center><h3>Change Password</h3></center>
</td></tr><tr>
<td><a href="index.php"><img src="incnet.png" width="120px" border=0/></a></td>
<td width="3px"></td>
<td bgcolor="black" width="0.1px">
<td width="3px"></td>
<td valign="middle">

	<form method="POST" name="password_input" autocomplete="off">

	<div class="pass_error"><?//PHP echo $errormsg; ?></div>
	<table style="font-size:16px">
	<tr>	
		<td>Old Password:</td><td> <input type="password" name="oldpass"></td>
	</tr>
	<tr>
		<td>New Password:</td><td> <input type="password" name="newpass1"></td>
	</tr>
	<tr>	
		<td>Confirm New Password:</td><td> <input type="password" name="newpass2"></td>
	</tr><tr>
	<td colspan="2px">

<center><input type="submit" name="submit" value="Change Password"><input type="submit" name="cancel" value="Cancel"></center>

	</td></tr>
	</table>
	</form>

</td>
</tr></table>
</center>
</div>
<div class="copyright">
<a style="text-decoration:none; color: white" href="copyright.php" >© INÇNET</a>
</div>	
</body>
</HTML>

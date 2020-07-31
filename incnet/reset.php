<?PHP
	error_reporting(0);

session_start();
if ((isset($_SESSION['user_id']))){
	header("location:index.php");
	}

$message = $_SESSION['reset_message'];
$reset_userid = $_SESSION['reset_username'];
$reset_code = $_SESSION['reset_code'];
$reset_user_password = $_SESSION['reset_user_password'];
$prompt_code = true;

//echo $reset_code;

include ("db_connect.php");

if (!$con){
  die('Could not connect: ' . mysql_error());
}
mysql_select_db("incnet", $con);

$code_message = "<h2>Please do not close this page.</h2><h3>A code was sent to your email. (This might take up to 2 minutes.) Please enter it below:</h3>";
 
if (isset($_POST['submit_resetcode'])){
//$newpass = substr(md5(time()), 0, 20); //I wrote this last year. I hate this now. Giving users predictable af passwords is not a good idea. --Efeyzi
$newpass = substr(md5(time().rand()), 0, 20); //I dislike this slightly less. It still isn't a CSPRNG but at least it has some level of randomness to it. (And it's hashed with the same shitty hashing algorithm we use to keep passwords so that's as good as I can expect from here.) --Efeyzi
$hash_newpass = md5($newpass);
	$submitcode = $_POST['code'];
	if ($submitcode == $reset_code){

	if (((md5($reset_userid)) . $reset_user_password) == $reset_code | true){ //I don't understand why this check exists. We already verified the users identity via the reset code. Disabled by "|| true" on 9/3/2019 --Efeyzi
		mysql_query("UPDATE incnet.coreUsers SET password='$hash_newpass' WHERE user_id='$reset_userid'");

		//echo $reset_userid;
		$code_message="<br/><br/>Your password was reset to: <b>" . $newpass  . "</b><br><a style='color:black; font-size:14' href='login.php'>Click here to log in.</a>";
		$prompt_code = false;
	} else {
		
		$code_message="An error occured, please start from the beginning.";
		}

	} else {
		
		$code_message="The codes don't match, please <a style=\"color: black; text-decoration: underline;\" href=./forgot.php>try again.</a>";
}
}

?>
<!DOCTYPE html>
<HTML>
<head>
<title>Inçnet</title>
<link rel="shortcut icon" href="favicon.ico" >
<meta charset=utf-8>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
<title>Reset Password</title>
</head>

<body OnLoad="document.resetcode_input.code.select();">

<div id="pchange_container">
<center><br><br><br>
<?PHP echo $message; ?><br>

<?PHP echo $code_message; ?>

<?php if($prompt_code) 
	echo(
		"
		<form name='resetcode_input' method='POST' autocomplete='off'>
			<input style='height: 24px; font-size: 14;' type='text' name='code' size='58' maxlength='64'>
			<input style='height: 24px; font-size: 14;' type='submit' name='submit_resetcode' value='Reset Password'>
		</form>
		"
	); 
?>

</center>
</div>

<div class="copyright">
<a style="text-decoration:none; color: white" href="copyright.php" >© 2012 INÇNET Team</a>
</div>	
</body>
</HTML>

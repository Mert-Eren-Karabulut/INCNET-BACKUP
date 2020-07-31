<?PHP
	error_reporting(0);

session_start();
if ((isset($_SESSION['user_id']))){
	header("location:index.php");
	}

include ("db_connect.php");

if (!$con){
  die('Could not connect: ' . mysql_error());
}
mysql_select_db("incnet", $con);

if ((isset($_POST['submit_username']))&&($_POST['username']!="")){
	$username=$_POST['username'];
	
	$result = mysql_query("SELECT * FROM incnet.coreUsers WHERE username='$username'");
	while($row = mysql_fetch_array($result)){
		$user_email = $row['email'];
		$user_fullname = $row['name'] . " " . $row['lastname'];
		$reset_userid = $row['user_id'];
		$reset_user_password = $row['password'];
		$message = "A password reset link for<b> " .$user_fullname . " </b>was sent to:<b> " . $user_email . ".</b>";
		$_SESSION['reset_message'] = $message;
		$_SESSION['reset_username'] = $reset_userid;
		$_SESSION['reset_user_password'] = $reset_user_password;

//		echo $user_email;
	}
	
$reset_code = md5($reset_userid . $reset_user_password . time());
$_SESSION['reset_code'] = $reset_code;
//echo $reset_code;


require("class.phpmailer.php");
require("class.smtp.php");

$mail = new PHPMailer();

$mail->IsSMTP();  // telling the class to use SMTP
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

$mail->Host     = "smtp.gmail.com"; // SMTP server
$mail->Port = 465; //25 for tevitol??
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "incnetmailer"; // SMTP username
$mail->Password = "inc_net_mailer"; // SMTP password

$mail->From     = "incnetmailer@gmail.com";
$mail->AddAddress($user_email);

$mail->Subject  = "INCNET Password Recovery";
$mail->Body     = "Dear ". $user_fullname .",
Your password reset code is: 
" . $reset_code . "
Please enter it to the password reset page to reset your password.";
$mail->WordWrap = 100;

if(!$mail->Send()) {
      $_SESSION['Error'] ="Message was not sent. Mailer error: " . $mail->ErrorInfo;
}
else {
      $_SESSION['Error'] = "Your username and password have been sent to your email address...";
}

	header("location:reset.php");
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

<body OnLoad="document.forgot_password.username.select();">

<div id="pchange_container">
<center>
<br><br><br>
<h3>Forgot password? It's ok. I don't remember<br>what I had for breakfast this morning.<br><br>Just enter your username to get your password:</h3>
		<form name="forgot_password" method="post" autocomplete="off">	
		Enter username:
		<input style='height: 24px; font-size: 14px;' type='text' name='username' size='16'>
		<input style='height: 24px; font-size: 14px;' type='submit' name='submit_username' value='Get Password'><br>
		</form>
		
		<br><a style="color:#c1272d; font-size:14px" href="login.php">Remembered it? Back to Login</a>

</center>
</div>

<div class="copyright">
<a style="text-decoration:none; color: white" href="copyright.php" >© INÇNET</a>
</div>	
</body>
</HTML>

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
		$message = "A password reset link was sent.<b><br> " . $user_fullname . " <br> " . $user_email . "</b>";
		$_SESSION['reset_message'] = $message;
		$_SESSION['reset_username'] = $reset_userid;
		$_SESSION['reset_user_password'] = $reset_user_password;

//		echo $user_email;
	}
	
$reset_code = md5($reset_userid) . $reset_user_password;
$_SESSION['reset_code'] = $reset_code;
//echo $reset_code;


require_once("../incnet/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();  // telling the class to use SMTP
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

$mail->Host     = "smtp.gmail.com"; // SMTP server
$mail->Port = 465;//25 for tevitol??
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
	echo 'ananananan';
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
<style>
body {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	font-size: 14px;
}


form { margin: 0; }  


.mobilebutton {
-webkit-appearance: none;
color:white;
background:#c1272d ;
width:91%;
height:140px; 
font-size: 40pt;
font-family:lucida grande,tahoma,verdana,arial,sans-serif;
text-shadow:5px 5px 7px black;
box-shadow:6px 6px 5px black;
position:relative;
display:block;
margin-right:auto;
margin-left:auto;
top:200px;
}
.mobileimage{
	position:relative;
	display:block;
	margin-left: auto;
	margin-right: auto;
	margin-top:40px;
	height:500px;
}

.header {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	z-index:1;
	font-size:38pt;
	position: fixed;
	width: 100%;
	padding-bottom:14px;
	padding-top:14px;
	color: white;
	left: 0px;
	background-color: #c1272d;
	top: 0px;
	text-align:right;
	text-decoration:none;
}


.mobilepart{
	width:100%;height:90%
}

#bottomButton{
	top:200px;
	margin-bottom:100px;
	color:white;
}
.taplogoff{
	color:white;
	opacity:0.5;
	text-align:left;
	position:absolute;
}
 .textbox { 
    border: 5px solid #c1272d;
    outline:0; 
    height:140px; 
    width: 86%; 
    padding-left:2%; 
    padding-right:2%;
    font-size:35pt;
	margin:0 auto;
	display:block;
	position:relative;
	color:#c1272d;
	top:130px;
	text-align:center;
  } 
::-webkit-input-placeholder { /* WebKit browsers */
    color:    #c1272d;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
   color:    #c1272d;
   opacity:  1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
   color:    #c1272d;
   opacity:  1;
}
:-ms-input-placeholder { /* Internet Explorer 10+ */
   color:    #c1272d;
}
::-o-placeholder { /* Mozilla Firefox 19+ */
   color:    #c1272d;
   opacity:  1;
}
:-o-placeholder { /* Mozilla Firefox 4 to 18 */
   color:    #c1272d;
   opacity:  1;
}
.sent {
	text-align:center;
	font-size:35pt;
	color:#c1272d;
	margin-bottom:-40px;
}
</style>
</head>
	<body>
		<a href='index.php'><img src="../incnet/incnetWhite.png" class="mobileimage"></a>
		<form name="forgot_password" method="post" autocomplete="off" autocapitalize="off" spellcheck="false">	
			<input type='text' class='textbox' name='username' placeholder="Enter Username">
			<input type='submit' class='mobilebutton'  name='submit_username' value='Get Password'>
		</form>
	
</html>

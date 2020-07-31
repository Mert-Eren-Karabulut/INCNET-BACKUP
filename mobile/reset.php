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

//echo $reset_code;

include ("db_connect.php");

if (!$con){
  die('Could not connect: ' . mysql_error());
}
mysql_select_db("incnet", $con);

$code_message = "<h2>Please do not close this page.</h2>";
$prompt_code = true;
if (isset($_POST['submit_resetcode'])){
$newpass = "newpass";
$hash_newpass = md5($newpass);
	$submitcode = $_POST['code'];
	if ($submitcode == $reset_code){

	if (((md5($reset_userid)) . $reset_user_password) == $reset_code){
		mysql_query("UPDATE incnet.coreUsers SET password='$hash_newpass' WHERE user_id='$reset_userid'");

		//echo $reset_userid;
		$code_message="Your password was reset to:<br><b>" . $newpass  . "</b><br><a href='login.php' style='text-decoration:none;'>Click here to log in.</a><br>";
		$prompt_code = false;
	} else {
		
		$code_message="An error occured, please start from the beginning.";
		}

	} else {
		
		$code_message="The codes don't match, please try again.";
}
}

?><!DOCTYPE html>
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
margin-bottom:20px;
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
.text {
	text-align:center;
	font-size:37pt;
	color:#c1272d;
	margin-bottom:-60px;
	margin-top: 20px;
	text-decoration:none;
}
</style>
</head>
	<body>
		<img src='../incnet/incnetWhite.png' class='mobileimage'>
	<div class='text'>
		<?PHP echo $code_message; ?>
		<?PHP if($prompt_code) echo $message;?><br>
	</div>
	<?php
		if($prompt_code) echo(
			"
				<form name='resetcode_input' method='POST' autocomplete='off' autocapitalize='off' spellcheck='false'>
					<input type='text' class='textbox' name='code' placeholder='Please Enter the Code'>
					<input type='submit' class='mobilebutton' name='submit_resetcode' value='Reset Password'>
				</form>
			"
		);
	?>
</body>
</HTML>












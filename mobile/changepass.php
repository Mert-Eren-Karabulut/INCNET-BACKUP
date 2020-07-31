<?PHP
	error_reporting(0);

require_once '../mobile_detect/Mobile_Detect.php';
$detect = new Mobile_Detect;
if (!($detect->isMobile())){
	header("location:../../incnet/index.php");
} 

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

  
<style>
body {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	font-size: 14px;
}
.mobileimage{
	position:relative;
	display:block;
	margin-left: auto;
	margin-right: auto;
	margin-top:130px;
	height:500px;
}

.header {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	z-index:1;
	font-size:38pt;
	padding-bottom:14px;
	padding-top:14px;
	position: fixed;
	width: 100%;
	color: white;
	left: 0px;
	background-color: #c1272d;
	top: 0px;
	text-align:right;
}



.input{
    height:25px;
    width: 275px;
    padding-left:80px;
    padding-right:80px;
    position:relative;
    top:0px;
    left:0px;
    width:80%;
    height:100px;
    outline:0;
    border-right: 5px solid #848484;
    border-left: 5px solid #848484;
    border-top: 0px none;
    border-bottom: 0px none;
    font-size:25pt;
}
 .textbox1 { 
    border: 5px solid #c1272d; 
    outline:0; 
    height:100px; 
    width: 91%; 
    font-size:30pt;
    display:block;
    margin-left:auto;
    margin-right:auto;
    position:relative;
    top:70px;
  } 

 .textbox { 
    border: 5px solid #c1272d;
    outline:0; 
    height:100px; 
    width: 91%; 
    font-size:30pt;
    display:block;
    margin-left:auto;
    margin-right:auto;
    position:relative;
    top:100px;
  } 
.textbox3 { 
    border: 5px solid #c1272d;
    outline:0;
    height:100px;
    width: 91%;
    font-size:30pt;
    display:block;
    margin-left:auto;
    margin-right:auto;
    position:relative;
    top:130px;
  } 
.mobilebutton {
	-webkit-appearance: none;
color:white;
background:#c1272d ;
z-index:0;
width:94%;
height:130px; 
font-size: 40pt;
font-family:lucida grande,tahoma,verdana,arial,sans-serif;
text-shadow:5px 5px 7px black;
box-shadow:6px 6px 5px black;
border:1;
position:relative;
display:block;
margin-right:auto;
margin-left:auto;
top:190px;
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

.taplogoff{
	color:white;
	opacity:0.5;
	text-align:left;
	position:absolute;
}



</style>
<body>
		<a href='logoff.php'>
			<div class="header"><div class='taplogoff'>&nbsp; Tap to log off</div>
				<? echo $fullname; ?> 	&nbsp;	
			</div>	
		</a>
		</a>
	<a href='index.php'><img src='../../incnet/incnet.png' class='mobileimage'></a>
	<form name='login' method='post'>		
		<input type='password' class='textbox1' placeholder='  Old Password' name='oldpass' autocomplete='off'>
		<input type='password' class='textbox' placeholder='  New Password' name='newpass1' autocomplete='off'>
		<input type='password' class='textbox3' placeholder='  Confirm New Password' name='newpass2' autocomplete='off'>
		<input type='submit' class='mobilebutton' name='submit'>
	</form>

</body>
</HTML>













<?PHP
	error_reporting(0);
	
	session_start();
	
	if(isset($_GET['continue']) && isset($_SESSION['continue'])){
		echo("test");
		header("Location: http://incnet.tevitol.org/".$_POST['redir']);
	}

function ae_detect_ie()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}

if (ae_detect_ie()) {
//header("location:browserfail.php");
}
require_once '../mobile_detect/Mobile_Detect.php';
$detect = new Mobile_Detect;
if (!($detect->isMobile())){
	header("location:../../incnet/login.php");
} 

$get = "";


if ((isset($_SESSION['user_id']))&&($_SESSION['user_id'])>0){
	echo "<!--";
	var_dump($_GET);
	echo "-->";
	foreach($_GET as $key => $value)
		$get.=$key."=".$value."&";
	$get = substr($get, 0, -1);
	header("location:../mobile/index.php?abc".$get);
}else{
	session_destroy;
}
 

//connect to mysql server
include ("db_connect.php");
if (!$con){
  die('Could not connect: ' . mysql_error());
}
  
//select database
mysql_select_db("incnet", $con);



//cookie login
if (isset($_COOKIE['remember'])){
	$username_cookie = $_COOKIE['remember'];
	$login_cookie_sql = mysql_query("SELECT * FROM incnet.coreUsers WHERE username='$username_cookie'");
	while($login_cookie_row = mysql_fetch_array($login_cookie_sql)){
		$_SESSION['user_id'] = $login_cookie_row['user_id'];
		$_SESSION['fullname'] = $login_cookie_row['name'] . " " . $login_cookie_row['lastname'];
		$_SESSION['student_id'] = $login_cookie_row['student_id'];
	}
	//header("location:index.php");
}

$redirect = $_GET['rec'];
if (!($redirect == 1)){
	//header("Location:../facerec/facereclogin.php");
	//$newPage = "<meta http-equiv='refresh' content='0; url=../facerec/ad.html'>";
}


if (isset($_POST['enter'])){
	$error='<script>alert("This is embarrassing.\nYou just entered a wrong username or password.")</script>';
	$entered_username=$_POST['username'];
	$entered_pass=$_POST['password'];
	
	
	$entered_pass=md5($entered_pass);
	
	
	//echo $entered_username;
	//echo $entered_pass;
	
	//login easter eggs
	if ($entered_username=='neo'){
		header("location:matrix.php");
	} else if ($entered_username=='admin'){
		header("location:admin.php");
	}
	
	$result = mysql_query("SELECT * FROM coreUsers WHERE (class != 'Grad' OR class IS NULL) AND username='$entered_username'");
	while($row = mysql_fetch_array($result)){
	
		$truepass=$row['password'];

		if ($entered_pass==$truepass){

			$user_id=$row['user_id'];
			session_start();

			//store user info in the session
			$_SESSION['user_id'] = $user_id;
			$_SESSION['fullname'] = $row['name'] . " " . $row['lastname'];
			$_SESSION['student_id'] = $row['student_id'];
			$_SESSION['lang'] = "EN";


			//set cookie
			if (isset($_POST['remember'])){
			$cookie_expire = time()+60*60*24*365; 
			setcookie("remember", $entered_username, $cookie_expire);
			}
			
			//if (($entered_pass=="10660ff76e3abb663590d2a68e420f55")||($entered_pass=="7b5789662fa8e67961aeccb7222eeb29")||($entered_pass=="25e4ee4e9229397b6b17776bfceaf8e7")){
				//$_SESSION['passchange']="must";
				//header("location:must_change_pass.php");
			//}else{
				header("location:index.php?redir=".$_POST['redir']);
			//}
		}else{
		echo $error;
		$wrongpass = "1";
	}

	}
}
?>
<!DOCTYPE html>
<html>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="/js/jquery.countdown.js"></script>
	<style>
		#countdown{
			position: absolute;
			width: 100%;
			text-align: center;
			top: 0;
			height: 10%;
			background-color: #c1272d;
			color: white;
			font-family: Helvetica;
			font-size: 20pt;
		}
	</style>
<style>
body {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	font-size: 14px;
	
}

.mobileimage{
	display:block;
	position:relative;
	margin-left: auto;
	margin-right: auto;	
	width:600px;
	margin-top:60px;
	z-index:-1;
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
.remember{
	font-size:40pt;
	font-weight:bold;
	color:#c1272d;
	top:205px;
	position:relative;
	left:5%;
}
.mobilebutton {
-webkit-appearance: none;
color:white;
background:#c1272d ;
width:90%;
height:120px; 
font-size: 40pt;
font-family:lucida grande,tahoma,verdana,arial,sans-serif;
text-shadow:5px 5px 7px black;
box-shadow:6px 6px 5px black;
position:relative;
display:block;
margin-right:auto;
margin-left:auto;
}
.forgot{
	text-decoration:none;
	font-size:45pt;
	color:#c1272d;
	display:block;
	margin-left:7%;
	margin-top:60px;
	margin-bottom:-90px;
}
</style>
<body>
	<div id=\"countdown\"></div>
	<script type=\"text/javascript\">
	  $('#countdown').countdown('2017/01/01', function(event) {
		$(this).html(event.strftime('<br>%H hours %M minutes %S seconds to 2017'));
	  });
	</script>
	<img src="./incnet.png" class="mobileimage"> 
	<?php 
	if($wrongpass== "1"){
		echo '<br> <a href="forgot.php" class="forgot">Forgot your password?</a> ';
		$wrongpass = '0';
	} 
	
	?>
	<form name="login" method="post"  autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
		<input type="text" class="textbox" placeholder="Username" name="username" style="top:140px;" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" onclick="value=''">
		<input type="text" name="uname" value="" style="display: none" /> 
		<input type="password" class="textbox" placeholder="Password" name="password" style="top:170px;" autocomplete="off" autocorrect="off" autocapitalize="off"  spellcheck="false" onclick="value=''">		
		<input type="password" name="pword" value="" style="display: none" /> 
		<label class="remember"><input type="checkbox" name="remember" value="Remember" style="width:45px;height:45px;"> Remember Me</label>
		<? if(isset($_GET['continue'])) echo("<input type=hidden name=redir value=".$_GET['continue'].">"); ?>
		<input type="submit" class="mobilebutton" value="Sign in" name="enter" style="top:270px;">
	</form>

</body>
</html>







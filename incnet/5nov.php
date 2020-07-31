<?PHP
	error_reporting(0);

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


session_start();
if (isset($_SESSION['user_id'])){
	header("location:index.php");
}


//connect to mysql server
include ("db_connect.php");
if (!$con){
  die('Could not connect: ' . mysql_error());
}
  
//select database
mysql_select_db("incnet", $con);

//date variables
$today = date("Y-m-d");
$cookie_expire = time()+60*60*24*365;



$doodle_result = mysql_query("SELECT * FROM coreDoodles WHERE date='$today'");
while($doodle_row = mysql_fetch_array($doodle_result)){
		$doodle_source=$doodle_row['picture'];
		$doodle_link = $doodle_row['link'];
		$doodle_title = $doodle_row['title'];
}

if ($doodle_source==''){
	$doodle = "<img id='logo' src='v.png' width='250px' border=0 />";
} else {
	$doodle = "<img src='" . $doodle_source . "' width='250px' border=0 title='" . $doodle_title . "' />";
}


//cookie login
/*if (isset($_COOKIE['remember'])){
	$username_cookie = $_COOKIE['remember'];
	$login_cookie_sql = mysql_query("SELECT * FROM incnet.coreUsers WHERE username='$username_cookie'");
	while($login_cookie_row = mysql_fetch_array($login_cookie_sql)){
		$_SESSION['user_id'] = $login_cookie_row['user_id'];
		$_SESSION['fullname'] = $login_cookie_row['name'] . " " . $login_cookie_row['lastname'];
		$_SESSION['student_id'] = $login_cookie_row['student_id'];
	}
	header("location:index.php");
}
*/

if (isset($_POST['enter'])){
	$error="<b>Remember, remember, the fifth of November.</b><br>And your username and password and email. <br><br> <a style='color:white; font-size:14' href='forgot.php'>Forgot password? Click here.</a>";
	
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
	
	$result = mysql_query("SELECT * FROM coreUsers WHERE username='$entered_username'");
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
			setcookie("remember", $entered_username, $cookie_expire);
			}
			
			if (($entered_pass=="10660ff76e3abb663590d2a68e420f55")||($entered_pass=="7b5789662fa8e67961aeccb7222eeb29")||($entered_pass=="25e4ee4e9229397b6b17776bfceaf8e7")){
				$_SESSION['passchange']="must";
				header("location:must_change_pass.php");
			}else{
				header("location:index.php");
			}
		}else{

	}

	}
}
?>
<html>
	<head>
		<meta charset='utf-8'>
		<script type="text/javascript">
		
			var imgObj = null;
			var divObj = null;
			var animate ;
			

			function init(){
				imgObj = document.getElementById('myImage');
				divObj = document.getElementById('login');
				imgObj.style.position= 'absolute'; 
				imgObj.style.top = '200px';
				divObj.style.position= 'absolute'; 
				divObj.style.top = '200px';
				document.loginForm.username.select();

			}

			function initOther(){
				imgObj = document.getElementById('myImage');
				divObj = document.getElementById('login');
				imgObj.style.position= 'absolute'; 
				imgObj.style.top = '60px';
				divObj.style.position= 'absolute'; 
				divObj.style.top = '368px';
				document.loginForm.username.select();

			}
						
			function moveUp(){
				if(imgObj.style.top!='60px'){
					imgObj.style.top = parseInt(imgObj.style.top) + -10 + 'px';
					divObj.style.top = parseInt(divObj.style.top) + 12 + 'px';
					document.loginForm.username.select();
					animate = setTimeout(moveUp,20);
				}
			}
			
			<?PHP
				if ($error!=''){
					echo "window.onload =initOther;";
				}else{
					echo "window.onload =init;";
				}
			?>


		</script>
		
		<style>
			a:link {
				text-decoration: none;
			}
			
			a:visited {
				text-decoration: none;
			}
			
			a:hover {
				text-decoration: underline;
			}
			
			a:active {
				text-decoration: none
			}
		</style>
	</head>

	<body id='body' style="background-color:#000000; font-family:lucida grande,tahoma,verdana,arial,sans-serif; font-size: 14px;">

		<div style='position:absolute; width:300px; margin-left:-150px; left:50%; color:white; top:80px; text-align:center;'>
			Welcome to INÇNET.<br>
			Click the logo to log in.
		</div>
		
		<div style='position:absolute; width:100%; color:white; top:290px; text-align:center; font-size:10pt'>
			<?PHP echo $error; ?>
		</div>
		
		<div id='login' style='width:200px; margin-left:-100px; left:50%; position:absolute; height:140px; text-align:center;'>
			<form method='post' name='loginForm' style='color:white' autocomplete='off'>
				<div style='font-size:15pt;'>Log in to INÇNET</div><div style='height:3px'></div>
				<input id='userbox' type='text' name='username' style='height:35px; font-size: 20pt; width:190px; border:none;' value='username' onClick="this.value='';"><div style='height:3px'></div>
				<input type='password' name='password' style='height:35px; font-size: 20pt; width:190px; border:none' value='username' onClick="this.value='';"><div style='height:3px'></div>
				<input type="checkbox" name="remember" value="Remember"/> Remember?<div style='height:3px'></div>
				<input type='submit' name='enter' value='Log in!' style='width:190px'>
			</form>
		</div>
		<div id='myImage' width="250px" onclick="moveUp();" style="left:50%; margin-left:-125px; height:215px">
			<?PHP echo $doodle; ?>
			<!--<img src="incnetWhite.png" width="250px" />-->
		</div>
	</body>
	
</html>
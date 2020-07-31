<?PHP
	error_reporting(0);

session_start();
if (isset($_SESSION['user_id'])){
	header("location:index.php");
}


//connect to mysql server
include ("../db_connect.php");
if (!$con){
  die('Could not connect: ' . mysql_error());
}
  
//select database
mysql_select_db("incnet", $con);

//date variables
$today = date("Y-m-d");
$cookie_expire = time()+60*60*24*365; 


//cookie login
if (isset($_COOKIE['remember'])){
	$username_cookie = $_COOKIE['remember'];
	$login_cookie_sql = mysql_query("SELECT * FROM incnet.coreUsers WHERE username='$username_cookie'");
	while($login_cookie_row = mysql_fetch_array($login_cookie_sql)){
		$_SESSION['user_id'] = $login_cookie_row['user_id'];
		$_SESSION['fullname'] = $login_cookie_row['name'] . " " . $login_cookie_row['lastname'];
		$_SESSION['student_id'] = $login_cookie_row['student_id'];
	}
	header("location:index.php");
}

if (isset($_POST['enter'])){
	$error="
	
	 <center>
	 <table border='4' bordercolor='#ff0000' rules='none'>
    	<tr>
			<td>
			<center>
			<b>This is emberrasing.</b><br>You just entered a wrong username or password. 
			<br>
			<a style='color:red; font-size:20' href='forgot.php'>Forgot password? Click here.</a>
			</td>
			</center>
		</tr>
    </table>
	</center>";
	
	$entered_username=$_POST['username'];
	$entered_pass=$_POST['password'];
	
	
	$entered_pass=md5($entered_pass);
	
	
	//echo $entered_username;
	//echo $entered_pass;
	
	
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

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <title>INÇNET|MOBILE</title>
  
  <link rel="stylesheet" href="css/jquery.css">
  <link rel="stylesheet" href="css/incnet.css" />
  <link rel="shortcut icon" href="favicon.ico" />
  
  <script src="script/jquery-1.9.1.js"></script>
  <script src="script/jquery.mobile-1.3.1.js"></script>
  <script src="script/codiqa.js"></script>
   
</head>
<body style="background-color:#fffff;">
<br>
<br>
<center>
        <table>
            <tr>
                <td>
                <div style=" text-align:center">
                    <img style="width: 68%; height: 68%" src="incnet.png">
                </div>
               
                </td>
            </tr>
            <tr>
                <td>
                <form method="post" name="loginForm" style="color:white" autocomplete="off">
                    <input id="userbox" type="text" name="username" placeholder="Username" />
                    <input type="password" name="password" placeholder="Password"/>
                        <!--<select name="toggleswitch2" id="remember" data-theme="" >
                                <option value="off">
                                Don't Remember Me!
                                </option>
                                <option value="on">
                                Remember Me!
                                </option>
                            </select>-->
                    <input type='submit' name='enter' value='Log in!'>
                </form>
                </td>
            </tr>
    </table> 
    	

   

<div style='position:absolute; width:100%; color:black; text-align:center; font-size:10pt'>
    <?PHP echo $error; ?>
</div>
            
</center>
</body>
</html>

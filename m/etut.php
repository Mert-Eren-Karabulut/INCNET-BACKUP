<?PHP
	error_reporting(0);
	
	
	//connect to mysql server
	include ("../db_connect.php");
	include ("../etut/functions.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
  
	
	require_once '../mobile_detect/Mobile_Detect.php';
	$detect = new Mobile_Detect;
	if (!($detect->isMobile())){
		header("location:../../etut");
	} 
	session_start();
	if (!(isset($_SESSION['user_id']))){
		$newPage = "<meta http-equiv='refresh' content='0; url=login.php'>";
	}
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	
	if (isset($_POST['logoff'])){
		session_destroy();
		$newPage = "<meta http-equiv='refresh' content='0; url=../incnet/index.php'>";
	}
	
	mysql_select_db("incnet");
	
	if ((checkAdmin($user_id)==0)&&(checkList($user_id)==0)&&(checkStudent($user_id)==0)){
		$newPage = "<meta http-equiv='refresh' content='0; url=../incnet/index.php'>";
	}
	$today= date("Y-m-d");

	if (isset($_POST['saveWeekday'])){
		$room=$_POST['seat'];
		$newSeat = getNewWeekdaySeat($room, $today);
		if ($room==''){//Clear choice, default seat
			$sql1 = "DELETE FROM etut_thisPeriod WHERE user_id=$user_id AND date='$today'";
			mysql_query($sql1);
			
		}else if ((($room=='comp')&&($newSeat<=15))||(($room=='lap')&&($newSeat<=30))){//comp or lap, check places.
			$sql1 = "DELETE FROM etut_thisPeriod WHERE user_id=$user_id AND date='$today'";
			mysql_query($sql1);
			$newSeat = getNewWeekdaySeat($room, $today);
			$sql2 = "INSERT into etut_thisPeriod VALUES (NULL, $user_id, '$room', '$newSeat', '$today')";
			mysql_query($sql2);
			$msg = "Update successful.";
			
		}else if(($room=='coursera')&&(0<15)){
			$sql1 = "DELETE FROM etut_thisPeriod WHERE user_id=$user_id AND date='$today'";
			mysql_query($sql1);
			$sql2 = "INSERT into etut_thisPeriod VALUES (NULL, $user_id, '$room', '', '$today')";
			mysql_query($sql2);
			$msg = "Update successful.";
		}else {//either an error or not enough places
			$msq = "Oops... Not enough places for the selected room!";
		}
		
	}
	
	if (isset($_POST['saveFriday'])){
		$newRoom=$_POST['weekendSeat'];
		$newSeat = getAvalWeekendSeat($newRoom);
		if ($newRoom==''){
			$sql1 = "DELETE FROM etut_weekend WHERE user=$user_id";
			mysql_query($sql1);
			$newSeat = getAvalWeekendSeat($newRoom);
			
		}else if(($newRoom=='sat_lap')&&((getAvalWeekendSeat($newRoom))<=30)){
			$sql1 = "DELETE FROM etut_weekend WHERE user=$user_id";
			mysql_query($sql1);
			$newSeat = getAvalWeekendSeat($newRoom);
			$sql2 = "INSERT into etut_weekend VALUES (NULL, 0, $user_id, 'lap', '$newSeat')";
			mysql_query($sql2);
			$msg = "Update successful.";
			
		}else if(($newRoom=='sat_comp')&&((getAvalWeekendSeat($newRoom))<=15)){
			$sql1 = "DELETE FROM etut_weekend WHERE user=$user_id";
			mysql_query($sql1);
			$newSeat = getAvalWeekendSeat($newRoom);
			$sql2 = "INSERT into etut_weekend VALUES (NULL, 0, $user_id, 'comp', '$newSeat')";
			mysql_query($sql2);
			$msg = "Update successful.";
			
		}else if(($newRoom=='sun_lap')&&((getAvalWeekendSeat($newRoom))<=30)){
			$sql1 = "DELETE FROM etut_weekend WHERE user=$user_id";
			mysql_query($sql1);
			$newSeat = getAvalWeekendSeat($newRoom);
			$sql2 = "INSERT into etut_weekend VALUES (NULL, 1, $user_id, 'lap', '$newSeat')";
			mysql_query($sql2);
			$msg = "Update successful.";
			
		}else if(($newRoom=='sun_comp')&&((getAvalWeekendSeat($newRoom))<=15)){
			$sql1 = "DELETE FROM etut_weekend WHERE user=$user_id";
			mysql_query($sql1);
			$newSeat = getAvalWeekendSeat($newRoom);
			$sql2 = "INSERT into etut_weekend VALUES (NULL, 1, $user_id, 'comp', '$newSeat')";
			mysql_query($sql2);
			$msg = "Update successful.";
			
		}else {
			$msq = "Oops... Not enough places for the selected room on selected day!";
		}
	}
	
	$sql = mysql_query("SELECT value FROM etutvars WHERE var_id=1");
	while ($row=mysql_fetch_array($sql)){
		$startDate = $row[0];
	}
	
	$sql = mysql_query("SELECT value FROM etutvars WHERE var_id=2");
	while ($row=mysql_fetch_array($sql)){
		$endDate = $row[0];
	}
?>
<!doctype html>
<html>
<head>
				<title>Inçnet</title>
		<link rel="shortcut icon" href="favicon.ico" >
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
<style>
body {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	font-size: 14px;
}


form { margin: 0; }  



.default_font{
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	font-size: 12pt;
}

a {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	color: white;
}

.mobilebutton {
	color:white;
	background:#c1272d ;
	width:94%;
	left:3%;
	height:100px; 
	font-size: 35pt;
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	text-shadow:5px 5px 7px black;
	border-radius:7px;
	box-shadow:6px 6px 5px black;
	border:1;
	position:relative;
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
	position: fixed;
	width: 100%;
	padding-bottom:14px;
	padding-top:14px;
	color: white;
	left: 0px;
	background-color: #c1272d;
	top: 0px;
	text-align:right;
}


.mobilepart{
	width:100%;height:90%
}

#bottomButton{
	top:220px;
	margin-bottom:100px;
	color:white;
}
.etut{
	font-size:35pt;
	width:90%;
	display:block;
	margin-left:auto;
	margin-right:auto;
	color:#c1272d;
}
.etutButton{

	color:white;
	background:#c1272d ;
	width:30%;
	float:right;
	height:100px; 
	font-size: 35pt;
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	text-shadow:5px 5px 7px black;
	box-shadow:6px 6px 5px black;
	border:1;
	position:relative;
	margin-top:20px;
	margin-bottom:40px;
    	 -webkit-appearance: none;
}
.etutSelect{
	color:#c1272d;
	background:white;
	font-weight:bold;
	width:65%;
	float:left;
	height:100px;
	font-size:35pt;
	border-radius:7px;
	box-shadow:6px 6px 5px black;
	border:1;
	margin-top:20px;
	margin-bottom:40px;

}

.taplogoff{
	color:white;
	opacity:0.5;
	text-align:left;
	position:absolute;
}
</style>	
</head>
<body>
		<a href='logoff.php'>
			<div class="header"><div class='taplogoff'>&nbsp; Tap to log off</div>
				<? echo $fullname; ?> 	&nbsp;	
			</div>	
		</a>	
	<a href="index.php"><img src="../../incnet/incnet.png" class="mobileimage"></a>
<div class="etut">
<?PHP
					$dayNum = date("N");
					
					if ((checkStudent($user_id))==1){
						echo "<div class='titleDiv'><br>";
						//echo $dayNum . "<br>";
						if ($dayNum<5){//Mon-Thu
							if ((date("G"))<17){//CHANGE TO: ((date("G"))<17)
								include("../etut/weekdays.php");
							}else{
								echo "You must reserve before 17:00<br>";
							}
							if (getWeekdayRoom ($user_id, $today)=='coursera'){
								echo "<b>Your seat is: </b>Coursera";
							}else {
								echo "<b>Your seat is: </b>" . getWeekdayRoom ($user_id, $today) . " " . getWeekdaySeat ($user_id, $today);
							}
							
						} else if ($dayNum==5){
							echo "Weekend etut reservations<br><br></div>";
							if ((date("G"))<20){//CHANGE TO: ((date("G"))<17)
								include("../etut/friday.php");
							}else{
								echo "You must reserve before 20:00<br>";
							}
							echo "<b>Your seats are: </b><br>" . getWeekendRoom($user_id, 0) . " " . getWeekendSeat($user_id, 0) . " on Saturday and<br>" . getWeekendRoom($user_id, 1) . " " . getWeekendSeat($user_id, 1) . " on Sunday";
						} else {
							echo "You cannot reserve today!<br><br></div>
							You must reserve before 20:00 on Fridays.";
							echo "<br><br><b>Your seats are: </b><br>" . getWeekendRoom($user_id, 0) . " " . getWeekendSeat($user_id, 0) . " on Saturday and<br>" . getWeekendRoom($user_id, 1) . " " . getWeekendSeat($user_id, 1) . " on Sunday";
						}
						echo "<br><br>Computer hours booked: <b>" . bookedHrs($user_id) . "</b>";
						echo "<br>Computer hours allowed: <b>" . allowedHrs($user_id) . "</b><br>";
					}
				?>
</div>


</body>
</html>


























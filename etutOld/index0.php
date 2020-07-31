<?PHP
	error_reporting(0);
	
	
	//connect to mysql server
	include ("../db_connect.php");
	include ("functions.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
	

require_once '../mobile_detect/Mobile_Detect.php';
$detect = new Mobile_Detect;
if ( $detect->isMobile() ) {
  echo	"<meta http-equiv='refresh' content='0; url=../mobile/etut.php'>"; 
}

  
	session_start();
	if (!(isset($_SESSION['user_id']))){
		$newPage = "<meta http-equiv='refresh' content='0; url=../incnet/login.php'>";
	}
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$lang = $_SESSION['lang'];
	
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
			$msg = "Oops... Not enough places for the selected room!";
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
			$msg = "Oops... Not enough places for the selected room on selected day!";
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
<HTML>
	<head>
		<?PHP
			if ($newPage!=''){
				echo $newPage;
			}
		?>
		<link rel="shortcut icon" href="../../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	</head>
	
	<body OnLoad="document.reservations.seat.focus();">
		<div class="header">
			<?PHP echo $fullname; ?>
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='../../incnet'><img style='position: relative; top:20px;' src='../../img/etut.png' width='140px'></a>
				</td>
				<div style='position:absolute; bottom:30px; z-index:2;' >
					<form name="logoff" method="POST">
						<input type ="submit" name="logoff" value="Log Off">
					</form>
				</div>
				<td valign='top' style='padding:7px; padding-top:15px;'>
				
				
				
				<?PHP
					$dayNum = date("N");
					if (((checkList($user_id))==1)||((checkAdmin($user_id))==1)){
						echo "<div class='titleDiv'><br>Admin Tools<br></div><br>";
					}

					if ((checkList($user_id))==1){
						if ($dayNum<5){//mon-thu
							echo "<a style='color:black' href='weekdayList.php'> View Lists </a><br><br>";
						} else {
							echo "<a style='color:black' href='satList.php'> Saturday Lists </a><br>";
							echo "<a style='color:black' href='sunList.php'> Sunday Lists </a><br><br>";
						}
						
					}
					
					if ((checkAdmin($user_id))==1){
						echo "<a style='color:black' href='editSeats.php'> Edit Default Seats </a><br>";
						echo "<a style='color:black' href='resetPeriod.php'> Reset the period </a><br>";
						echo "<a style='color:black' href='pageVars.php'> Page Variables </a><br>";
					}
					
					if ((checkStudent($user_id))==1){
						echo "<div class='titleDiv'><br>";
						//echo $dayNum . "<br>";
						if ($dayNum<5){//Mon-Thu
							echo "Etut reservations for today<br><br></div> \n";
							if (((date("G"))<16)&&(5<(date("G")))){//CHANGE TO: ((date("G"))<17)
								include("weekdays.php");
							}else{
								echo "You must reserve between <b>6:00</b> and <b>16:00</b><br>";
							}
							if (getWeekdayRoom ($user_id, $today)=='coursera'){
								echo "<b>Your seat is: </b>Coursera";
							}else {
								echo "<b>Your seat is: </b>" . getWeekdayRoom ($user_id, $today) . " " . getWeekdaySeat ($user_id, $today);
							}
							
						} else if ($dayNum==5){
							echo "Weekend etut reservations<br><br></div>";
							if ((date("G"))<16){//CHANGE TO: ((date("G"))<17)
								include("friday.php");
							}else{
								echo "You must reserve before 20:00<br>";
							}
							echo "<b>Your seats are: </b><br>" . getWeekendRoom($user_id, 0) . " " . getWeekendSeat($user_id, 0) . " on Saturday and<br>" . getWeekendRoom($user_id, 1) . " " . getWeekendSeat($user_id, 1) . " on Sunday";
						} else {
							echo "You cannot reserve today!<br><br></div>
							You must reserve before 16:00 on Fridays.";
							echo "<br><br><b>Your seats are: </b><br>" . getWeekendRoom($user_id, 0) . " " . getWeekendSeat($user_id, 0) . " on Saturday and<br>" . getWeekendRoom($user_id, 1) . " " . getWeekendSeat($user_id, 1) . " on Sunday";
						}
						echo "<br><br>Computer hours booked: <b>" . bookedHrs($user_id) . "</b>";
						echo "<br>Computer hours allowed: <b>" . allowedHrs($user_id) . "</b><br>";
						echo "<br>Period begins: <b>$startDate</b>";
						echo "<br>Period ends: <b>$endDate</b>";
					}
				?>
				</td>
			</tr>
		</table>
		
		<div class="copyright">&nbsp © INCNET</div>
	</body>
</HTML>









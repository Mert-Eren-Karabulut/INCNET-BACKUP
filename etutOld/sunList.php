<?PHP
	error_reporting(0);
	
	
	//connect to mysql server
	include ("../db_connect.php");
	include ("functions.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
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
	
	if (checkList($user_id)==0){
		$newPage = "<meta http-equiv='refresh' content='0; url=index.php'>";
	}
	
	$dayNum = date("N");
	if ($dayNum == 5){//Friday
		$queryDay = date('Y-m-d', strtotime("+2 day"));
	} else if ($dayNum==6){//Saturday
		$queryDay = date('Y-m-d', strtotime("+1 day"));
	} else if ($dayNum==7){//Sunday
		$queryDay = date("Y-m-d");
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
	
	<body>
		<div class="header">
			<?PHP echo $fullname; ?>
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='index.php'><img style='position: relative; top:20px;' src='../../incnet/incnet.png' width='140px'></a>
				</td>
				<div style='position:absolute; bottom:30px; z-index:2;' >
					<form name="logoff" method="POST">
						<input type ="submit" name="logoff" value="Log Off">
					</form>
				</div>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<br>
					<div class='titleDiv'>
						<br>Sunday:
					</div>
					<?PHP
						if ($dayNum<5){
							echo "Warning! This list is finalised after 16.00 on Fridays. That is not today.<br>
							It <u>might</u> change depending on event reservations on Checkin.";
						}
					?>
					<div class='titleDiv'><br></div>
					<table style='border:1px solid black; border-collapse:collapse;'>
						<tr>
							<td style='border:1px solid black; color:#c1272d; font-weight:bold; border-collapse:collapse; padding-left:10px; padding-right:10px; padding-top:2px; padding-bottom:2px'>Student id</td>
							<td style='border:1px solid black; color:#c1272d; font-weight:bold; border-collapse:collapse; padding-left:10px; padding-right:10px; padding-top:2px; padding-bottom:2px'>Name</td>
							<td style='border:1px solid black; color:#c1272d; font-weight:bold; border-collapse:collapse; padding-left:10px; padding-right:10px; padding-top:2px; padding-bottom:2px'>Lastname</td>
							<td style='border:1px solid black; color:#c1272d; font-weight:bold; border-collapse:collapse; padding-left:10px; padding-right:10px; padding-top:2px; padding-bottom:2px'>Class</td>
							<td style='border:1px solid black; color:#c1272d; font-weight:bold; border-collapse:collapse; padding-left:10px; padding-right:10px; padding-top:2px; padding-bottom:2px'>Default Room</td>
							<td style='border:1px solid black; color:#c1272d; font-weight:bold; border-collapse:collapse; padding-left:10px; padding-right:10px; padding-top:2px; padding-bottom:2px'>Default Seat</td>
							<td style='border:1px solid black; color:#c1272d; font-weight:bold; border-collapse:collapse; padding-left:10px; padding-right:10px; padding-top:2px; padding-bottom:2px'>Room</td>
							<td style='border:1px solid black; color:#c1272d; font-weight:bold; border-collapse:collapse; padding-left:10px; padding-right:10px; padding-top:2px; padding-bottom:2px'>Seat</td>
							<td style='border:1px solid black; color:#c1272d; font-weight:bold; border-collapse:collapse; padding-left:10px; padding-right:10px; padding-top:2px; padding-bottom:2px'>Event</td>
							<td style='border:1px solid black; color:#c1272d; font-weight:bold; border-collapse:collapse; padding-left:10px; padding-right:10px; padding-top:2px; padding-bottom:2px'>Weekend Departures</td>
						</tr>
						<?PHP
							//$today = date("Y-m-d");
							$sql = "SELECT user_id, name, lastname, student_id, class FROM coreUsers WHERE coreUsers.type='student' AND class != 'Grad' AND class != '13' AND class != 'Old' ORDER BY coreUsers.lastname";
							$query=mysql_query($sql);
							while ($row=mysql_fetch_array($query)){
								$user=$row[0];
								$name=$row[1];
								$lastname=$row[2];
								$student_id = $row[3];
								$class = $row[4];
								$room = getWeekendRoom ($user, 1);
								if ($room=='class'){
									$room = 'classroom';
								}
								$seat = getWeekendSeat ($user, 1);
								$defaultRoom = getDefaultRoom($user);
								if ($defaultRoom=='class'){
									$defaultRoom = 'classroom';
								}
								$defaultSeat = getDefaultSeat($user);
								echo"
								<tr>
								<td style='text-align:right; border:1px solid black; border-collapse:collapse; padding-left:10px; padding-right:10px; padding-top:2px; padding-bottom:2px'>$student_id</td>
									<td style='border:1px solid black; border-collapse:collapse; padding-left:4px; padding-right:4px; padding-top:2px; padding-bottom:2px;'>$name</td>
									<td style='border:1px solid black; border-collapse:collapse; padding-left:4px; padding-right:4px; padding-top:2px; padding-bottom:2px;'>$lastname</td>
									<td style='border:1px solid black; border-collapse:collapse; padding-left:4px; padding-right:4px; padding-top:2px; padding-bottom:2px;'>$class</td>
									<td style='border:1px solid black; border-collapse:collapse; padding-left:4px; padding-right:4px; padding-top:2px; padding-bottom:2px; color:#3366CC'>$defaultRoom</td>
									<td style='border:1px solid black; border-collapse:collapse; padding-left:4px; padding-right:4px; padding-top:2px; padding-bottom:2px;color:#3366CC'>$defaultSeat</td>
									<td style='border:1px solid black; border-collapse:collapse; padding-left:4px; padding-right:4px; padding-top:2px; padding-bottom:2px;'>$room</td>
									<td style='border:1px solid black; border-collapse:collapse; padding-left:4px; padding-right:4px; padding-top:2px; padding-bottom:2px;'>$seat</td>
									<td style='border:1px solid black; border-collapse:collapse; padding-left:4px; padding-right:4px; padding-top:2px; padding-bottom:2px;'>";
									echo checkinEvent ($user, $queryDay);
									echo "</td>
									<td style='border:1px solid black; border-collapse:collapse; padding-left:4px; padding-right:4px; padding-top:2px; padding-bottom:2px;'>";
									echo checkHome ($user, $queryDay);
									//echo $queryDay;
									echo "</td>
								</tr>";
							}
						?>
					
					</table><div style='height: 20px'></div>
				</td>
			</tr>
		</table>
		
		<div class="copyright">&nbsp © INCNET</div>
	</body>
</HTML>









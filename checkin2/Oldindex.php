<?PHP
	error_reporting(0);
	
	//connect to mysql server
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
//check if its mobile
require_once '../mobile_detect/Mobile_Detect.php';
$detect = new Mobile_Detect;
if ( $detect->isMobile() ) {
  echo	"<meta http-equiv='refresh' content='0; url=../mobile/checkin.php'>"; 
}

  	mysql_select_db("incnet");
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$lang = $_SESSION['lang'];
	
	//permissions  
	$page_id = "201";
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:../../incnet/login.php");
	}
	$user_id = $_SESSION['user_id'];
	
	$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
	while($permit_row = mysql_fetch_array($permit_query)){
		$allowed_pages[] = $permit_row['page_id'];
	}
	
	function check_user_agent ( $type = NULL ) {
        $user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
        if ( $type == 'bot' ) {
                // matches popular bots
                if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
                        return true;
                        // watchmouse|pingdom\.com are "uptime services"
                }
        } else if ( $type == 'browser' ) {
                // matches core browser types
                if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
                        return true;
                }
        } else if ( $type == 'mobile' ) {
                // matches popular mobile devices that have small screens and/or touch inputs
                // mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
                // detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
                if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
                        // these are the most common
                        return true;
                } else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
                        // these are less common, and might not be worth checking
                        return true;
                }
        }
        return false;
}

	$query = mysql_query("SELECT class, type FROM incnet.coreUsers WHERE user_id='$user_id'");
	while($row = mysql_fetch_array($query)){
		$class = $row['class'];
		$type = $row['type'];
		if ($type=='teacher'){
			$class = 'T';
		}else if($type == 'personnel'){
			$class = 'Pe';
		}
		if ($class == 'Hz'){
			$class = 'Pr';
		}
	}

	if (isset($_POST['dropout'])){
		$dropId = $_POST['dropId'];
		mysql_query("DELETE FROM incnet.checkin2Joins WHERE event_id='$dropId' AND user_id='$user_id'");
	}

	if (isset($_POST['join'])){
		$joinId = $_POST['joinId'];
		$sql = "INSERT into incnet.checkin2Joins VALUES(NULL,$joinId,$user_id,'','YES')";
		mysql_query($sql);
	}
/*
	//Time+Device type Check
	$now = date("Hm");
	//$now = 832;
	//echo $now;
	$enable = 0;
	if (!(check_user_agent('mobile'))){//not mobile
		$enable=1;
	}
	
	if ((date("N")==5)&&(1230<=$now)){//Friday after class
		$enable=1;
	}
	
	if (date("N")>5){//Weekends
		$enable=1;
	}
	if (($enable==0)&&($type=='student')){
		header("location:registerForEvents.php");
	}
	*/
	
	$chkDateStart = date('Y-m-d', strtotime("-90 days"));
	$sql2 = "SELECT COUNT(checkin2events.event_id) FROM checkin2events, checkin2joins WHERE checkin2joins.user_id = '$user_id' AND checkin2events.event_id = checkin2joins.event_id AND checkin2events.date>'$chkDateStart'";
	//echo $sql2;
	$query2 = mysql_query($sql2) or die(mysql_error());
	while ($row2 = mysql_fetch_row($query2)){
		$eventCount = $row2[0];
	}

	if ($eventCount>25){
		$divDisp = "block";
	}else{
		$divDisp = "none";
	}
?>

<!doctype html>
<HTML>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">

		<?PHP
			if ($page!=''){
			echo " <meta http-equiv='refresh' content='0; url= $page '> ";
			}
		?>

		
	</head>
	
	<body>
		<div class='header'>
			<?PHP echo $fullname;?>
			&nbsp&nbsp
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<br><a href='../incnet'><img src='../img/checkin.png' width='135px'></a><br>
					<br>
					<?PHP
						if (in_array("201", $allowed_pages)) {
							echo "<a style='color:black' href='createEvent.php'> Create Event </a><br>";
						}
						if (in_array("232", $allowed_pages)) {
							echo "<a style='color:black' href='waiting.php'> Approve Events </a><br>";
						}
						if (in_array("201", $allowed_pages)) {
							echo "<a style='color:black' href='getList.php'> View Lists </a><br>";
						}
						if (in_array("201", $allowed_pages)) {
							echo "<a style='color:black' href='selectEdit.php'> Edit Events </a><br>";
						}
						if (in_array("230", $allowed_pages)) {
							echo "<a style='color:black' href='studentReport.php'> Reports </a><br>";
						}

					?>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<br>
						<div style='display: <? echo $divDisp; ?>'>
							<a href='appeal.php'>
								<table>
									<tr>
										<td style='color:#545454; font-size:20pt'>Please Read:<br>a personal appeal from<br>INCNET Founder Levent Erol</td>
										<td style='width:30px'></td>
										<!--<td><img src='lev.png' style='width:150px'></td>-->
									</tr>
								</table>
							</a>
						</div>

					<div style='color: #c1272d; font-size:16pt'>
						Coming up:<br>
					</div><br>
						<?PHP
							$today = date("Y-m-d");
							$sql = "SELECT * FROM incnet.checkin2Events WHERE date >= DATE '$today' AND approved <= DATE '$today' AND class LIKE '%$class%' ORDER BY event_id DESC";
							//echo $sql;
							$query = mysql_query($sql);
							while ($row = mysql_fetch_array($query)){
								$event_id = $row['event_id'];
								$title = $row['title'];
								$date = $row['date'];
									$event_date = explode("-", $date);
									$event_day = $event_date[2];
									$event_year = $event_date[0];
									$event_month = $event_date[1];
									switch ($event_month) {
										case "01":
											$event_month = "January";
											break;
										 case "02":
										 	$event_month = "February";
										 	break;
										 case "03":
										 	$event_month = "March";
										 	break;
										 case "04":
										 	$event_month = "April";
										 	break;
										 case "05":
										 	$event_month = "May";
										 	break;
										 case "06":
										 	$event_month = "June";
										 	break;
										 case "07":
										 	$event_month = "July";
										 	break;
										 case "08":
										 	$event_month = "August";
										 	break;
										 case "09":
										 	$event_month = "September";
										 	break;
										 case "10":
										 	$event_month = "October";
										 	break;
										 case "11":
										 	$event_month = "November";
										 	break;
										 case "12":
										 	$event_month = "December";
										 	break;
										}
									$date = $event_month . " " . $event_day . ", " . $event_year;
								$depart = $row['departureTime'];
								$eventTime = $row['eventTime'];
								$return = $row['returnTime'];
								$details = $row['details'];
								$location = $row['location'];
								$quota = $row['quota'];
								$deadline = $row['deadlineDay'];
									$deadlineTimestamp = $row['deadlineDay'];
									$deadline = explode("-", $deadline);
									$deadline_day = $deadline[2];
									$deadline_year = $deadline[0];
									$deadline_month = $deadline[1];
									switch ($deadline_month) {
										case "01":
											$deadline_month = "January";
											break;
										 case "02":
										 	$deadline_month = "February";
										 	break;
										 case "03":
										 	$deadline_month = "March";
										 	break;
										 case "04":
										 	$deadline_month = "April";
										 	break;
										 case "05":
										 	$deadline_month = "May";
										 	break;
										 case "06":
										 	$deadline_month = "June";
										 	break;
										 case "07":
										 	$deadline_month = "July";
										 	break;
										 case "08":
										 	$deadline_month = "August";
										 	break;
										 case "09":
										 	$deadline_month = "September";
										 	break;
										 case "10":
										 	$deadline_month = "October";
										 	break;
										 case "11":
										 	$deadline_month = "November";
										 	break;
										 case "12":
										 	$deadline_month = "December";
										 	break;
										}
										$deadlineHour = $row['deadlineHour'];
									$deadline = $deadline_month . " " . $deadline_day . ", " . $deadline_year . ",&nbsp&nbsp" . $row['deadlineHour'] . ":00";
								echo "
								<div style='border:1px solid black; padding:3px; width:372px;'>
									<div style='color: #c1272d; font-weight:bold; font-size:13pt;'>&nbsp$title</div>
									<table>
										<tr>
											<td style='text-align:right; font-weight:bold; padding:3px'>Date:</td>
											<td>$date</td>
										</tr>
										<tr>
											<td style='text-align:right; font-weight:bold; padding:3px'>Departure time:</td>
											<td>$depart</td>
										</tr>
										<tr>
											<td style='text-align:right; font-weight:bold; padding:3px'>Event time:</td>
											<td>$eventTime</td>
										</tr>
										<tr>
											<td style='text-align:right; font-weight:bold; padding:3px'>Return time:</td>
											<td>$return</td>
										</tr>
										<tr>
											<td style='text-align:right; font-weight:bold; padding:3px' valign='top'>Details:</td>
											<td>$details</td>
										</tr>
										<tr>
											<td style='text-align:right; font-weight:bold; padding:3px'>Location:</td>
											<td>$location</td>
										</tr>
										<tr>
											<td style='text-align:right; font-weight:bold; padding:3px'>Apply until:</td>
											<td>$deadline</td>
										</tr>
										";
										$eventFill = 0;
										$remaining = 0;
										$sql2 = "SELECT COUNT(*) FROM incnet.checkin2Joins WHERE come='YES' AND event_id='$event_id'";
										//echo $sql2;
										$query2 = mysql_query($sql2);
										while ($row2 = mysql_fetch_array($query2)){
											$eventFill = $row2['COUNT(*)'];
											//echo $eventFill;
											$remaining = $quota-$eventFill;
											if ($remaining < 1){
												$remaining = 0;
											}
											$remText = $remaining;
											if ($remaining <=5){
												$remText = "<div style='color: #c1272d; font-weight:bold'>$remaining</div>";
											}
										}
										$userCount=0;
										$go='';
										$sql2 = "SELECT COUNT(*) FROM incnet.checkin2Joins WHERE come='YES' AND event_id='$event_id' AND user_id='$user_id'";
										//echo $sql2;
										$query2 = mysql_query($sql2);
										while ($row2 = mysql_fetch_array($query2)){
											$userCount = $row2['COUNT(*)'];
											//echo $eventFill;
											if ($userCount == 1){//going
												$button = "<form method='POST'>You <b>are</b> Going!&nbsp&nbsp<input type='hidden' name='dropId' value='$event_id'><input type='submit' name='dropout' value='Drop out!' style='width:70px; height:20px; background-color: transparent; border:1px solid #c1272d; color:#c1272d'></form>";
												if ($today>$deadlineTimestamp){//too late to register!
													$go = "<div style='color:#527A00; font-size:10pt'>You <b>are</b> going. You can't drop out.";
													$button = "";
												}else if ($today==$deadlineTimestamp){//correct day, check time.
													$thisHour = date(H);
													if ($thisHour>=$deadlineHour){//can't register
														$go = "<div style='color:#527A00; font-size:10pt'>You <b>are</b> going. You can't drop out.";
														$button = "";
													}
												}
											}else if ($userCount == 0){//not going
												$button = "<form method='POST'>You are <b>not</b> going.&nbsp&nbsp<input type='hidden' name='joinId' value='$event_id'><input type='submit' name='join' value='Join!' style='width:70px; height:20px; background-color: transparent; border:1px solid green; color:green'></form>";
												if ($remaining<1){
													$go = "<div style='color:#c1272d; font-size:10pt'>Too late! No places left for \"$title\".</div>";
													$button = "";
												}
												if ($today>$deadlineTimestamp){//too late to register!
													$go = "<div style='color:#c1272d; font-size:10pt'>Too late! Registration deadline has passed for \"$title\".</div>";
													$button = "";
												}else if ($today==$deadlineTimestamp){//correct day, check time.
													$thisHour = date(H);
													if ($thisHour>=$deadlineHour){//can't register
														$go = "<div style='color:#c1272d; font-size:10pt'>Too late! Registration deadline has passed for \"$title\".</div> $go";
														$button = "";
													}
												}
											}else{//re-submitted form, error!
												mysql_query("DELETE FROM incnet.checkin2Joins WHERE event_id='$event_id' AND user_id='$user_id'");
												$go = "<div style='color:#c1272d; font-weight:bold; font-size:13pt'>Error! Please refresh this page.</div>";
												$button='';
											}
											
										}
									echo "
									<tr>
											<td style='text-align:right; font-weight:bold; padding:3px'>Places remaining:</td>
											<td>$remText</td>
										</tr>
										<tr>
											<td colspan=2>
												$go
												$button
											</td>
										</td>
									</table>
								</div><div style='height:5px'>&nbsp</div>
								";
							}
							
						?>
					<br><br><br>
				</td>
			</tr>
		</table>
		
		<div class="copyright">&nbsp © INÇNET</div>
	</body>
</HTML>





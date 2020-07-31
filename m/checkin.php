<?PHP
	error_reporting(0);
	
	//connect to mysql server
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
  mysql_select_db("incnet");
	
	
	
	require_once '../mobile_detect/Mobile_Detect.php';
	$detect = new Mobile_Detect;
	if (!($detect->isMobile())){
		header("location:../../checkin2");
	} 

	session_start();
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	//permissions  
	$page_id = "201";
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:login.php");
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
	
	$chkDateStart = date('d-m-Y', strtotime("-90 days"));
	$sql2 = "SELECT COUNT(checkin2events.event_id) FROM checkin2events, checkin2joins WHERE checkin2joins.user_id = '$user_id' AND checkin2events.event_id = checkin2joins.event_id AND checkin2events.date>'$chkDateStart'";
	//echo $sql2;
	$query2 = mysql_query($sql2) or die(mysql_error());
	while ($row2 = mysql_fetch_row($query2)){
		$eventCount = $row2[0];
	//	echo $eventCount;
	}

	if ($eventCount>25){
		$divDisp = "block";
	}else{
		$divDisp = "none";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		
	</head>
	<style>
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



.mobilebutton {
color:white;
background:#c1272d ;
width:100%;
height:60px; 
font-size: 25pt;
font-family:lucida grande,tahoma,verdana,arial,sans-serif;
text-shadow:2px 2px 3px black;
border-radius:7px;
box-shadow:3px 3px 2px black;
border:1;
margin-bottom:10%;
margin-left:10%;
padding-top:-6px;
}
a {
font-family:lucida grande,tahoma,verdana,arial,sans-serif;
color: white;
}

.eventdiv{
border:5px solid black; 
padding:2px;
left:10px;
right:10px;
font-size:35pt;
width:94%;
margin-left:2.7%;
border-top-style: none;
}

.taplogoff{
	color:white;
	opacity:0.5;
	text-align:left;
	position:absolute;
}

.clickme{
border:7px solid black; 
padding:2px;
width:100%;
position:relative;
margin-left:-1%;
}

.clickmeText{
color: #c1272d;
font-weight:bold;
font-size:70pt;
padding-left:45px;
text-decoration: none;
}
.thebigone{
border:3px solid black;
width:94%;
display:block;
margin:0 auto;
padding:0px;
}
	</style>
	<body>
		<div class="header">
			<a href='logoff.php'><div class='taplogoff'>&nbsp; Tap to log off</div></a>
			<? echo $fullname; ?> 	&nbsp;	
		</div>	
		<a href='index.php'> <img src='../../incnet/incnet.png' class='mobileimage'> </a><br><br>


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
										$sql2 = "SELECT COUNT(*) FROM incnet.checkin2Joins WHERE come='YES' AND event_id='$event_id' AND user_id='$user_id'";
										//echo $sql2;
										$query2 = mysql_query($sql2);
										while ($row2 = mysql_fetch_array($query2)){
											$userCount = $row2['COUNT(*)'];
											switch($userCount){
												case 1:$togoornottogo = 'green';break;
												case 0:$togoornottogo = '#c1272d';break;
											}										
										}
								
								echo "
								<div class='thebigone' style='border:none;'>
								<div  class='clickme' style='border-color:$togoornottogo;'>
									<a href='#' class='clickmeText'>$title</a>
								</div>

								<div class='detailBox'>
								<div class='eventdiv'>
			
									<table>
										<tr>
											<td style='min-width:400px;text-align:right; font-weight:bold; padding:3px'>Date:</td>
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
												$button = "<form method='POST'><input type='hidden' name='dropId' value='$event_id'><input type='submit' name='dropout' value='Drop out!' style='width:94%;; height:100px;display:block;margin-left:auto;margin-right:auto; background-color: transparent; border:7px solid #c1272d; color:#c1272d;font-size:37pt;font-weight:bold;margin-top:20px;margin-bottom:30px;'></form>";
												if ($today>$deadlineTimestamp){//too late to register!
													$go = "<div style='color:#527A00; font-size:38pt'>You <b>are</b> going. You can't drop out.";
													$button = "";
												}else if ($today==$deadlineTimestamp){//correct day, check time.
													$thisHour = date(H);
													if ($thisHour>=$deadlineHour){//can't register
														$go = "<div style='color:#527A00; font-size:38pt'>You <b>are</b> going. You can't drop out.";
														$button = "";
													}
												}
											}else if ($userCount == 0){//not going
												$button = "<form method='POST'><input type='hidden' name='joinId' value='$event_id'><input type='submit' name='join' value='Join!' style='width:94%; height:100px;display:block;margin-left:auto;margin-right:auto; background-color: transparent; border:7px solid green; color:green;font-size:37pt;font-weight:bold;margin-top:20px;margin-bottom:30px;'></form>";
												if ($remaining<1){
													$go = "<div style='color:#c1272d; font-size:35pt'>Too late! No places left for \"$title\".</div>";
													$button = "";
												}
												if ($today>$deadlineTimestamp){//too late to register!
													$go = "<div style='color:#c1272d; font-size:35pt'>Too late! Registration deadline has passed for \"$title\".</div>";
													$button = "";
												}else if ($today==$deadlineTimestamp){//correct day, check time.
													$thisHour = date(H);
													if ($thisHour>=$deadlineHour){//can't register
														$go = "<div style='color:#c1272d; font-size:35pt'>Too late! Registration deadline has passed for \"$title\".</div> $go";
														$button = "";
													}
												}
											}else{//re-submitted form, error!
												mysql_query("DELETE FROM incnet.checkin2Joins WHERE event_id='$event_id' AND user_id='$user_id'");
												$go = '<div style="color:#c1272d; font-weight:bold; font-size:45pt">&nbsp;Error! Please refresh this page.</div><script>alert("ERROR! \nPlease refresh this page.");window.location("index.php");</script>';
												$button='';
											}
											
										}
									echo "
									<tr>
											<td style='text-align:right; font-weight:bold; padding:3px'>Places remaining:</td>
											<td>$remText</td>
										</tr>
									</table>
 
									$go
									$button
								</div><div style='height:5px'>&nbsp</div>
							</div></div></div><br><br>";
							}
							
						?>
		<script>
		$('.detailBox').hide();
		$('.clickme').each(function() {
		    $(this).show(0).on('click', function(e) {
			e.preventDefault();
			$(this).next('.detailBox').slideToggle('fast');
			if (($(this).css("border") == "0px none rgb(0, 0, 0)")||($(this).css("border") == "0px rgb(0, 0, 0)"))
			{
				var y = $(this).parents('.thebigone').css("border");
				$(this).css({"border":y}).next('.detailBox').children(".eventdiv").css({"border":"initial"}).parents('.thebigone').css({"border":"none"});
			}
			else
			{
				//alert("cool");
				var x = $(this).css("border");
				$(this).css({"border":"none"}).next('.detailBox').children(".eventdiv").css({"border":"none"}).parents('.thebigone').css({"border":x});    
			}
			
		    });
		});
		</script>		
	</body>
</html>

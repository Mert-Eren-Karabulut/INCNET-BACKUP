<?PHP
	error_reporting(0);
	
	//connect to mysql server
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
	//check if it's mobile
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
		<title>INÇNET | Checkin</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">

		<?PHP
			if ($page!=''){
			echo " <meta http-equiv='refresh' content='0; url= $page '> ";
			}
		?>		
		<style>
			.btn {
			  cursor: pointer;
			  font-family: Arial;
			  color: #ffffff;
			  font-size: 13px;
			  background: #cc0000;
			  padding: 10px 20px 10px 20px;
			  text-decoration: none;
			}

			.btn:hover {
			  background: #aa0000;
			  text-decoration: none;
			}
			
			table#waitlist tr{
				border: 1pt solid black;
			}
			
			table#waitlist td{
				border: 1pt solid black;
			}
			
			table#waitlist th{
				border: 1pt solid black;
			}
			
			table#waitlist{
				border: 1pt solid black;
				width: 100%;
			}
		</style>
		
	</head>
	
	<body>
		<div class='header'>
			<?PHP echo $fullname;?>
			&nbsp&nbsp
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<br><a href='../checkin2/index.php'><img src='../img/checkin.png' width='135px'></a><br>
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
						if (in_array("231", $allowed_pages)) {
							echo "<a style='color:black' href='banUser.php'> Ban User </a><br>";
						}
						
					?>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<br>
					<div style='color: #c1272d; font-size:16pt; text-align: center;'>
						Waitlist for <?
							$sql = "SELECT title, location FROM checkin2events WHERE event_id = ".(int) $_GET['event'];
							$result = mysql_query($sql);
							if($row = mysql_fetch_assoc($result)){
								echo($row['title']." at ".$row['location']);
							}
						?> (event id <? echo((int) $_GET['event']); ?>)<br>
					</div><br>
					
						
					<?php
						$annen = true;
						$sql = "SELECT * FROM  `checkin2waitlist` WHERE `event_id` = ".(int) $_GET['event']." ORDER BY  `checkin2waitlist`.`id` ASC";
						$result = mysql_query($sql);
						$counter = 1;
							$baban = ("<table id=waitlist><tr><th>No. in Line</th><th style='text-align: left;'>Full Name</th></tr>");
							while($row = mysql_fetch_assoc($result)){
								$sql2 = "SELECT * FROM coreusers WHERE user_id=".$row['student_id'];
								$row2 = mysql_fetch_assoc(mysql_query($sql2));
								$baban.=("<tr><td style=\"width: 15%;\">$counter</td><td style=\"width:80%;\">".$row2['name']." ".$row2['lastname']."</td></tr>");
								$counter++;
								$annen = false;
							}
							if($annen){
								echo("No records found.");
							}else{
								echo $baban;
							}
						?>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
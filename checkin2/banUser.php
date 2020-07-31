<?php
	//check if it's mobile
	require_once '../mobile_detect/Mobile_Detect.php';
	$detect = new Mobile_Detect;
	if ( $detect->isMobile() ) {
	  echo	"<meta http-equiv='refresh' content='0; url=../mobile/checkin.php'>"; 
	}
	
	
	error_reporting(0);
	
	//connect to mysql server
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
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
		if(!in_array("231", $allowed_pages))
			die("You are not allowed to access this page!");
	
		$event = $_POST['event'];
		$user = $_POST['user'];
		$reason = $_POST['reason'];
		if(isset($_POST['lift']) && in_array("231", $allowed_pages)){
			$sql = "DELETE FROM checkin2bans WHERE(user_id='".mysql_real_escape_string($user)."' AND event_id='".mysql_real_escape_string($event)."')";
			mysql_query($sql);
		}
		if(isset($_POST['add']) && in_array("231", $allowed_pages)){
			$sql = "SELECT user_id FROM checkin2bans WHERE user_id=".mysql_real_escape_string($user)." AND event_id=".mysql_real_escape_string($event);
			if(!mysql_fetch_assoc(mysql_query($sql))){
				$sql = "INSERT INTO `checkin2bans`(`ban_id`, `user_id`, `event_id`, `reason`) VALUES (0, '".mysql_real_escape_string($user)."', '".mysql_real_escape_string($event)."', '".mysql_real_escape_string($reason)."')";
				mysql_query($sql);
				$sql = "DELETE FROM checkin2joins WHERE (user_id=".mysql_real_escape_string($user)." AND event_id=".mysql_real_escape_string($event).")";
				mysql_query($sql);
				if($user == "1282"){
					echo("<script>alert(\"Beni kendi silahımla vurdun :(\");</script>");
				}
			} else{
				echo("<script>alert(\"This user has already been banned for this event.\");</script>");
			}
		}
?>
<html>
	<head>
		<meta charset=UTF-8/>
		<title>INÇNET | Ban User</title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<style>
			label{
				font-weight: bold;
			}
		</style>
	</head>
	<body>
		<div class=header>&nbsp;&nbsp;</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<br><a href='index.php'><img src='../img/checkin.png' width='135px'></a><br>
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
				<td valign='top' style='padding:12px; padding-top:35px;'>
					<h1 style="font-size: 30pt; font-weight: initial;">Ban User From Event</h1>
					<b>This tool bans the selected user from an event and drops their join if they have already joined. Use the "Lift Ban" button to lift the selected users ban for the selected event.</b><br/><br/><br/>
					<form action=# method=POST>
						<table>
							<tr>
								<td><label for=event>Select event to edit bans for</label></td>
								<td><select name=event>
									<?php
										$eventQuery = mysql_query("SELECT * FROM checkin2events ORDER BY date DESC LIMIT 0, 30");
										while($row = mysql_fetch_array($eventQuery)){
											echo("<option value=".$row['event_id']." > ".$row['title']." at ".$row['location']."</option>");
										}
									?>
								</select></td>
							</tr>
							<tr><td><label for=reason>Reason (optional)</label></td><td><textarea name=reason></textarea></td></tr>
							<tr>
								<td><label for=user>Select user</label></td>
								<td><select name=user>
									<?php
										$usersQuery = mysql_query("SELECT * FROM coreusers ORDER BY lastname, name");
										while($row = mysql_fetch_array($usersQuery)){
											echo("<option value=".$row['user_id']." > ".$row['lastname'].", ".$row['name']."</option>");
										}
									?>
								</select>
								<button name=add>Ban User</button>
								<button name=lift>Lift Ban</button></td>
								<style>
									.bannedlist{
										border: 1pt solid black;
									}
								</style>
								<table class=bannedlist style="margin-top:280px; margin-left:180px;">
								
								
								<?php
									//connect to mysql server
									include ("../db_connect.php");
									if (!$con){
									  die('Could not connect: ' . mysql_error());
								  }
									mysql_select_db("incnet");

								$sql = "SELECT * FROM checkin2bans";
															$query = mysql_query($sql);
															$first = true;
															while($row = mysql_fetch_assoc($query)){
																if($first){
																	echo "<tr class=bannedlist><th class=bannedlist>Name</th><th class=bannedlist style=\"width: 130px;\">Event Banned</th><th class=bannedlist>Class</th><!--<th class=bannedlist>Lift Ban</th>--></tr>";
																	$first = false;
																}
																$sql2 = "SELECT * FROM checkin2events WHERE (event_id=".mysql_real_escape_string($row['event_id']).")";
																$user = $row['user_id'];
																$query2 = mysql_query("SELECT * FROM coreusers WHERE user_id=$user");
																$query3 = mysql_query($sql2);
																$row3 = mysql_fetch_assoc($query3);
																while($row2 = mysql_fetch_assoc($query2)){
																	$eventname = $row3['title'];
																	$fullnameofbanned = $row2['name']." ".$row2['lastname'];
																	$classofbanned = $row2['class'];
																	if($row2['type'] != "student")
																		$classofbanned = "--";
																	echo "
																		<tr class=bannedlist>
																			<td class=bannedlist>$fullnameofbanned</td>
																			<td class=bannedlist>$eventname</td>
																			<td class=bannedlist>$classofbanned</td>
																			<!--<td class=bannedlist style=\"vertical-align: middle; text-align: center\"><form action=# method=POST><button name=lift>X</form></td>-->
																		</tr>
																	";
																}
															}
								?>
								</table>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
		<div class="copyright">&nbsp © INÇNET</div>
	</body>
</html>
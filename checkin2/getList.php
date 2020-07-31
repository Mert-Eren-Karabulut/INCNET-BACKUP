<?PHP
	error_reporting(0);
	
	//connect to mysql server
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
  
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:login.php");
	}
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
	
	$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='$page_id'");
	while($permit_row = mysql_fetch_array($permit_query)){
		$allowance = "1";
	}
	if ($allowance != "1"){
		header ("location:../../incnet/login.php");
	}

	$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
	while($permit_row = mysql_fetch_array($permit_query)){
		$allowed_pages[] = $permit_row['page_id'];
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
					<br><a href='index.php'><image src='red.png' width='135px'></a><br>
					<br>
					<?PHP
						if (in_array("201", $allowed_pages)) {
							echo "<a style='color:black' href='createEvent.php'> Create Event </a><br>";
						}
						if (in_array("232", $allowed_pages)) {
							echo "<a style='color:black' href='waiting.php'> Approve Events </a><br>";
						}
						if (in_array("201", $allowed_pages)) {
							echo "<a style='color:black' href='selectEdit.php'> Edit Events </a><br>";
						}
						if (in_array("201", $allowed_pages)) {
							echo "<a style='color:black' href='banUser.php'> Ban User </a><br>";
						}

					?>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
						<br>
						<?PHP
							$sql = "SELECT COUNT(*) FROM incnet.corePermits WHERE user_id=$user_id AND page_id = 233";
							$query=mysql_query($sql);
							while ($row = mysql_fetch_row($query)){	$count = $row[0]; }
							
							if ($count>0){//page admin, all lists
								$sql = "SELECT event_id, title, date FROM incnet.checkin2Events WHERE approved is not NULL ORDER BY date DESC";
							}else{//no admin, own events only
								$sql = "SELECT event_id, title, date FROM incnet.checkin2Events WHERE approved is not NULL AND admin=$user_id ORDER BY date DESC";
							}
							//echo $sql;
							$query=mysql_query($sql);
							while ($row = mysql_fetch_array($query)){
								$event_id = $row[0];
								$title = $row[1];
								$date = $row[2];
								echo "
									<div style='border:1px solid black; padding:3px; width:372px;'>
										<form method='GET' action='list.php'>
											<div style='color:#c1272d; font-size:12'>$title</div><div style='height:5px'></div>
											Date: $date <br><div style='height:5px'></div>
											<input type='hidden' name='event' value='$event_id'>
											<input type='submit' name='select' value='View List' style='width:70px; height:20px; background-color: transparent; border:1px solid black; color:black'>
											<div style='height:5px'></div>
										</form>
										<form method='GET' action='waitlistview.php'>
											<input type='hidden' name='event' value='$event_id'>
											<input type='submit' name='select' value='View Waitlist' style='width:auto; height:20px; background-color: transparent; border:1px solid black; color:black'>
										</form>
									</div>
									<div style='height:7px'></div>
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









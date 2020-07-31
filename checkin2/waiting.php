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
	$page_id = "232";
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
		<body OnLoad="init();">
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
						if (in_array("201", $allowed_pages)) {
							echo "<a style='color:black' href='getList.php'> View Lists </a><br>";
						}
						if (in_array("201", $allowed_pages)) {
							echo "<a style='color:black' href='selectEdit.php'> Edit Events </a><br>";
						}

					?>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'><br>
					<div style='color: #c1272d; font-size:16pt'>
						Approve events:<br>
					</div>
						<?PHP
							$query = mysql_query("SELECT event_id, title, date FROM incnet.checkin2Events WHERE approved is NULL");
							while($row = mysql_fetch_array($query)){
								$thisId = $row['event_id'];
								$thisTitle = $row['title'];
								$thisDate = $row['date'];
								$thisDate = explode("-", $thisDate);
								$day = $thisDate[2];
								$thisDate = $thisDate[1];
								switch($thisDate){
									case 1:
										$thisDate='January';
									case 2:
										$thisDate='February';
									case 3:
										$thisDate='March';
									case 4:
										$thisDate='Arpil';
									case 5:
										$thisDate='May';
									case 6:
										$thisDate='June';
									case 7:
										$thisDate='July';
									case 8:
										$thisDate='August';
									case 9:
										$thisDate='September';
									case 10:
										$thisDate='October';
									case 11:
										$thisDate='November';
									case 12:
										$thisDate='December';
								}
								$thisDate = $thisDate . " " . $day;
								echo "<br><form method='GET' action='approve.php'><input type='hidden' name='thisId' value='$thisId'><input type='submit' name='thisEvent' value='$thisTitle' style='font-size:18pt; background-color: white; border:2px solid white; color:#c1272d; font-weight:bold;'><br>on $thisDate</form><br>";
								
							}
							
							if ($thisId == ''){
								echo "<br><br>There are no events to be approved for the moment. <a style='color:#c1272d' href='index.php'> Go back</a>";
							}
						?>
					<br><br><br>
				</td>
			</tr>
		</table>
		
		<div class="copyright">&nbsp © INÇNET</div>
	</body>
</HTML>









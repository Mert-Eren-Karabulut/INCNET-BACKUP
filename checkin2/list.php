<?PHP
	error_reporting(0);
	
	//connect to mysql server
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
  
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:../");
	}
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$lang = $_SESSION['lang'];
	
	if (!(isset($_GET['event']))){
		$page = "getList.php";
	}else{
		$event = $_GET['event'];
	}
	
	
	if (isset($_POST['removeNow'])){
		mysql_select_db("incnet");
		$removePerson = $_POST['selectRemove'];
		$sql = "DELETE FROM incnet.checkin2Joins WHERE user_id = '$removePerson' AND event_id='$event'";
//		echo($sql.';');
		mysql_query($sql);
		if(isset($_POST['addNextPerson'])) if($_POST['addNextPerson'] == "yes"){
			$sql = "SELECT student_id FROM checkin2waitlist WHERE event_id=$event ORDER BY id ASC";
//			echo $sql."\n";
			$result = mysql_query($sql);
//			var_dump($result);
//			echo "\n";
			$temp_userids = (mysql_fetch_assoc($result));
			$temp_userid = $temp_userids['student_id'];
//			var_dump($temp_userids);
			$sql = "INSERT INTO `checkin2joins`(`join_id`, `event_id`, `user_id`, `extra_info`, `come`) VALUES (0, $event, $temp_userid, ' ', 'YES')";
//			echo($sql.'\n');
			mysql_query($sql);
			$sql = "SELECT student_id FROM checkin2waitlist WHERE(event_id=$event) ORDER BY id ASC LIMIT 1";
//			echo($sql.';');
			$temp_userids = mysql_fetch_assoc(mysql_query($sql));
//			var_dump($temp_userids);
			$sql = "DELETE FROM `checkin2waitlist` WHERE `student_id`=".$temp_userids['student_id'];
//			echo($sql.';');
			mysql_query($sql);
		}
	}

	if (isset($_POST['add'])){
		$addPerson = $_POST['addUser'];
		//echo $addPerson;
		$sql="SELECT COUNT(*) FROM incnet.checkin2Joins WHERE user_id = '$addPerson' AND event_id='$event'";
		//echo $sql;
		$query = mysql_query($sql);
		while($row=mysql_fetch_row($query)){
			$hasJoined = $row[0];
		}
		if($hasJoined==0){
			$sql = "INSERT into incnet.checkin2Joins VALUES (NULL, $event, $addPerson, '', 'YES')";
			//echo $sql;
			mysql_query($sql);
		}
	}
	
	


?>

<!doctype html>
<HTML>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<body OnLoad="init();">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
					<br><a href='getList.php'><image src='red.png' width='135px'></a><br>
					<br>
					<form method='GET' action='print.php'>
						<input type='hidden' name='printId' value="<?PHP echo $event; ?>">
						<input type='submit' value='Printable version' style='width:130px; height:20px; background-color: transparent; border:1px solid #c1272d; color:#c1272d'>
					</form>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<br>
					<table style='border:1px solid black; border-collapse:collapse;'>
					<?PHP
						$event_date = "";
						mysql_select_db("incnet");
						$sql = "SELECT date, title, departureTime, eventTime, returnTime, location FROM checkin2Events WHERE event_id='$event'";
						$query = mysql_query($sql);
						while($row = mysql_fetch_row($query)){
							$event_date = $row[0];
							echo "
								<tr>
									<td style='border:1px solid white; border-bottom:1px solid black; border-collapse:collapse; padding:2px;' colspan='4'>
									<div style='color:#c1272d; font-weight:bold; font-size:14pt'>$row[1]</div>
									<table>
										<tr><td>Date: </td><td>$row[0]</td></tr>
										<tr><td>Planned departure: </td><td>$row[2]</td></tr>
										<tr><td>Event time:</td><td> $row[3]</td></tr>
										<tr><td>Planned return: </td><td>$row[4]</td></tr>
										<tr><td>Location:</td><td> $row[5]</td></tr>
									</table>
									</td>
									<td style='border:1px solid white; border-bottom:1px solid black; border-collapse:collapse; padding:2px; text-align:center' colspan='2'>
										<br>List proudly generated by<br><image src='white.png' width='100px'><br>
									</td>

								</tr>
							";
						}
					?>
					<tr>
						<td style='border:1px solid black; border-collapse:collapse; padding:2px; width:40px'></td>
						<td style='border:1px solid black; border-collapse:collapse; padding:2px; width:200px; font-weight:bold; color:#c1272d'>Adı-Soyadı</td>
						<td style='border:1px solid black; border-collapse:collapse; padding:2px; width:60px; font-weight:bold; color:#c1272d'>Okul no</td>
						<td style='border:1px solid black; border-collapse:collapse; padding:2px; width:49px; font-weight:bold; color:#c1272d'>Sınıf</td>
						<td style='border:1px solid black; border-collapse:collapse; padding:2px; width:120px; font-weight:bold; color:#c1272d'>Yatakhane</td>
						<td style='border:1px solid black; border-collapse:collapse; padding:2px; width:40px'></td>
						<td style='border:1px solid black; border-collapse:collapse; padding:2px; width:160px; font-weight:bold; color:#c1272d'>90 gün öncesinden itibaren katılacağı etkinlik sayısı</td>
					</tr>
						<?PHP
							
							//$sql = "SELECT coreUsers.name, coreUsers.lastname, coreUsers.student_id, coreUsers.class, coreUsers.dormroom, coreUsers.type, checkin2Joins.event_id, coreUsers.user_id FROM coreUsers, checkin2Joins WHERE checkin2Joins.event_id = $event AND coreUsers.user_id = checkin2Joins.user_id AND checkin2Joins.come='YES'";
							$sql = "SELECT * FROM checkin2joins AS j JOIN coreusers AS u ON j.user_id = u.user_id WHERE j.event_id=$event ORDER BY u.lastname";
							//echo $sql;
							$query = mysql_query($sql);
							$i=1;
							while ($row = mysql_fetch_array($query)){
								/*$name = $row[0];
								$lastname = $row[1];
								$studentId = $row[2];
								$class = $row[3];
								$dorm = $row[4];
								$type = $row[5];
								$theUser = $row[7];*/
								$name = $row['name'];
								$lastname = $row['lastname'];
								$studentId = $row['student_id'];
								$class = $row['class'];
								$dorm = $row['dormroom'];
								$type = $row['type'];
								$theUser = $row['user_id'];
								
								$chkDateStart = date('d-m-Y', strtotime("-90 days"));
								$eventCount = 0;
								
								$sql2 = mysql_query("SELECT COUNT(checkin2events.event_id) FROM checkin2events, checkin2joins WHERE  checkin2joins.user_id = $theUser AND checkin2events.event_id = checkin2joins.event_id AND checkin2events.date>'$chkDateStart'");
								while ($row2=mysql_fetch_array($sql2)){
									$eventCount = $row2[0];
								}
								echo "
									<tr>
									<td style='border:1px solid black; border-collapse:collapse; padding:2px;'><b>$i.</b></td>";
								if ($type!='student'){
									echo "<td style='border:1px solid black; border-collapse:collapse; padding:2px; color:#c1272d;'>$name $lastname</td>";
								}else{
									echo "<td style='border:1px solid black; border-collapse:collapse; padding:2px;'>$name $lastname</td>";
								}
								echo "
										<td style='border:1px solid black; border-collapse:collapse; padding:2px '>$studentId</td>
										<td style='border:1px solid black; border-collapse:collapse; padding:2px;'>$class</td>
										<td style='border:1px solid black; border-collapse:collapse; padding:2px;'>$dorm</td>
										<td style='border:1px solid black; border-collapse:collapse; padding:2px;'>
											<form method='POST'>
												<input type='hidden' name='selectRemove' value='$theUser'>
												<input type='submit' name='removeNow' style='color:#c1272d; font-weight:bold; border:transparent; background-color:transparent' value='Remove'>
												<input type=hidden name='addNextPerson' value='yes' class='addNextPerson' />
											</form>
										</td>
										<td style='border:1px solid black; border-collapse:collapse; padding:2px '>$eventCount</td>
									</tr>
								";
								$i++;
							}
						?>
					</table>
					<script>//alert("Please do not use this page for a while");</script>
					<noscript><h1>It is absolutely essential for you to have JavaScript enabled for this page to work.</h1></noscript>
					<br>
					<input type=checkbox id=addnext onclick="var nextPersons = $('.addNextPerson'); for(var i = 0; i < nextPersons.length; i++){nextPersons[i].value = ($('#addnext')[0].checked ? 'yes' : 'no');}"> <label for=addnext>Add next person in line on remove</label>
					<br/>
					<form method='post' autocomplete='off'>
						<c style='color:#c1272d'>Add person:</c><br>
						<input type='text' name='searchKey' style='border:1px solid black; width:150px'>&nbsp
						<input type='submit' name='search' value='Find!' style='width:70px; background-color: transparent; border:1px solid black'>
					</form>
					<?PHP
						if ((isset($_POST['search']))&&($_POST['searchKey']!='')){
							$searchKey = $_POST['searchKey'];
							$query = mysql_query("SELECT user_id, name, lastname, class FROM incnet.coreUsers WHERE name LIKE '%$searchKey%' OR lastname LIKE '%$searchKey%'");
							//echo $query;
							while($row = mysql_fetch_array($query)){
								$addUser = $row[0];
								$name = $row[1];
								$lastname = $row[2];
								$class = $row[3];
								echo "<div style='height:5px'></div><form method='POST'><input type='hidden' name='addUser' value='$addUser'><input type='submit' name='add' value='Add' style='width:60px; height:20px; background-color: transparent; border:1px solid green; color:green'>  $name $lastname (class: $class)</form>";
							}
							$recordCount = count($studentRow);
					
						}
					?>
					<br><br><br>
				</td>
			</tr>
		</table>
		
		<div class="copyright">&nbsp © INÇNET</div>
	</body>
</HTML>
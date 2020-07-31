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
	
	if (!(isset($_GET['printId']))){
		$page = "getList.php";
	}else{
		$event = $_GET['printId'];
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
		<div style='width:600px; position:relative; left:50%; margin-left:-300px;'>
		<br>
			<table style='border:1px solid black; border-collapse:collapse;'>
			<?PHP
				mysql_select_db("incnet");
				$sql = "SELECT date, title, departureTime, eventTime, returnTime, location FROM checkin2Events WHERE event_id='$event'";
				$query = mysql_query($sql);
				while($row = mysql_fetch_array($query)){
					echo "
						<tr>
							<td style='border:1px solid white; border-bottom:1px solid black; border-collapse:collapse; padding:2px;' colspan='5'>
							<div style='color:#c1272d; font-weight:bold; font-size:14pt'>$row[1]</div>
							<table>
								<tr><td>Date: </td><td>".$row['date']."</td></tr>
								<tr><td>Planned departure: </td><td>".$row['departureTime']."</td></tr>
								<tr><td>Event time:</td><td>". $row['eventTime']."</td></tr>
								<tr><td>Planned return: </td><td>".$row['returnTime']."</td></tr>
								<tr><td>Location:</td><td>". $row['location']."</td></tr>
							</table>
							</td>
							<td style='border:1px solid white; border-collapse:collapse; padding:2px; text-align:center'>
								<br><a href='list.php?event=$event&select=View+list'><image src='white.png' width='100px'></a><br>
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
			</tr>
				<?PHP
					
					$sql = "SELECT coreUsers.name, coreUsers.lastname, coreUsers.student_id, coreUsers.class, coreUsers.dormroom, coreUsers.type, checkin2Joins.event_id, coreUsers.user_id FROM coreUsers, checkin2Joins WHERE checkin2Joins.event_id = $event AND coreUsers.user_id = checkin2Joins.user_id AND checkin2Joins.come='YES'";
					$sql = "SELECT * FROM checkin2joins AS j JOIN coreusers AS u ON j.user_id = u.user_id WHERE j.event_id=$event ORDER BY u.lastname";
					//echo $sql;
					$query = mysql_query($sql);
					$i=1;
					$teachers = "";
					while ($row = mysql_fetch_array($query)){
						$name = $row['name'];
						$lastname = $row['lastname'];
						$studentId = $row['student_id'];
						$class = $row['class'];
						$dorm = $row['dormroom'];
						$type = $row['type'];
						$currentuser = $row['user_id'];
						$sql2 = "SELECT profilesmain.tckn FROM profilesmain WHERE user_id = $currentuser";
						$sql = mysql_query($sql2);
						$tckn = '';
						while ($row2=mysql_fetch_array($sql)){
							$tckn = $row2[0];
						}
						//$theUser = $row[7];
							$thisRow = "";
							if ($type!='student'){
								$thisRow = "";
							}else{
							$thisRow .="
								<tr>
								<td style='border:1px solid black; border-collapse:collapse; padding:2px;'><b>$i.</b></td>";
								$thisRow .="<td style='border:1px solid black; border-collapse:collapse; padding:2px;'>$name $lastname</td>";
								$thisRow .="
										<td style='border:1px solid black; border-collapse:collapse; padding:2px '>$studentId</td>
										<td style='border:1px solid black; border-collapse:collapse; padding:2px;'>$class</td>
										<td style='border:1px solid black; border-collapse:collapse; padding:2px;'>$dorm</td>
									</tr>
								";
								$i++;
							}
							$tckn='';
							echo $thisRow;
					}
					
					$sql = "SELECT coreUsers.name, coreUsers.lastname, coreUsers.student_id, coreUsers.class, coreUsers.dormroom, coreUsers.type, checkin2Joins.event_id, coreUsers.user_id FROM coreUsers, checkin2Joins WHERE checkin2Joins.event_id = $event AND coreUsers.user_id = checkin2Joins.user_id AND checkin2Joins.come='YES'";
					$sql = "SELECT * FROM checkin2joins AS j JOIN coreusers AS u ON j.user_id = u.user_id WHERE j.event_id=$event ORDER BY u.lastname";
					//echo $sql;
					$query = mysql_query($sql);
					$teachers = "";
					while ($row = mysql_fetch_array($query)){
						$name = $row['name'];
						$lastname = $row['lastname'];
						$studentId = $row['student_id'];
						$class = $row['class'];
						$dorm = $row['dormroom'];
						$type = $row['type'];
						$currentuser = $row['user_id'];
						$sql2 = "SELECT profilesmain.tckn FROM profilesmain WHERE user_id = $currentuser";
						$sql = mysql_query($sql2);
						$tckn = '';
						while ($row2=mysql_fetch_array($sql)){
							$tckn = $row2[0];
						}
						//$theUser = $row[7];
							$thisRow = "";
							if ($type!='student'){
							$thisRow .="
								<tr>
								<td style='border:1px solid black; border-collapse:collapse; padding:2px;'><b>$i</b></td>";
								echo "$thisRow<td style='border:1px solid black; border-collapse:collapse; padding:2px; color:#c1272d;'>$name $lastname</td>
										<td style='border:1px solid black; border-collapse:collapse; padding:2px; color:#c1272d;'>--</td>
										<td style='border:1px solid black; border-collapse:collapse; padding:2px; color:#c1272d;'>--</td>
										<td style='border:1px solid black; border-collapse:collapse; padding:2px; color:#c1272d;'>--</td>
									</tr>
							";
								$thisRow = "";
								$i++;
							}else{
							}
							$tckn='';
							echo $thisRow;
					}
					
				?>
			</table>
		</div>
	</body>
</HTML>









<?PHP
	error_reporting(0);
	
	//connect to mysql server
	include ("../../db_connect.php");
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
	$page_id = "903";
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

		mysql_select_db("incnet");
		$sql = "SELECT profilesDevices.registerId, profilesDevices.type, profilesDevices.make, profilesDevices.identifier, profilesDevices.registerDate, profilesMain.name, profilesMain.lastname FROM profilesDevices, profilesMain WHERE profilesDevices.registerId = profilesMain.registerId";
		//echo $sql;
		$query=mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$name = $row['5'] . " " . $row['6'];
			$type = $row['1'];
			$identifier = $row['3'];
			$registerDate = $row['4'];
			$make = $row['2'];
			$thisRow = "<tr><td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>$name</td>
<td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>$type</td><td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>$make</td><td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>$identifier</td><td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>$registerDate</td></tr>";
			$allRows = $allRows . $thisRow;
		}
?>



<!doctype html>
<HTML>
	<head>
		<link rel="shortcut icon" href="../../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="../style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<body OnLoad="document.selectSearch.searchKey.focus();">
	</head>
	
	<body>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='../../incnet'><img src='../../incnet/incnet.png' width='140px'></a>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
				<div class='titleDiv'>
					<br>Electronic devices
				</div>
					<b>Warning!</b> This form applies to students only.
					<br><br><br>
					<table style='border:1px solid black; border-collapse:collapse;'>
						<tr>
							<td style='border:1px solid black; border-collapse:collapse; color:#c1272d; font-weight:bold; padding:2px'>Owner</td>
							<td style='border:1px solid black; border-collapse:collapse; color:#c1272d; font-weight:bold; padding:2px'>Device type</td>
							<td style='border:1px solid black; border-collapse:collapse; color:#c1272d; font-weight:bold; padding:2px'>Make</td>
							<td style='border:1px solid black; border-collapse:collapse; color:#c1272d; font-weight:bold; padding:2px'>Identifier</td>
							<td style='border:1px solid black; border-collapse:collapse; color:#c1272d; font-weight:bold; padding:2px'>Register date</td>
						</tr>
							<?PHP
								echo $allRows;
							?>
						<tr><td height='100px' colspan=5></td></tr>
					</table>
					
				</td>
			</tr>
		</table>
		
		<div class="copyright">&nbsp © INÇNET</div>
	</body>
</HTML>









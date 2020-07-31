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
	$page_id = "904";
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
		$sql = "SELECT profilesSummerCamps.registerId, profilesSummerCamps.institution, profilesSummerCamps.program, profilesSummerCamps.country, profilesSummerCamps.city, profilesSummerCamps.dateAdded, profilesMain.name, profilesMain.lastname, profilesMain.class FROM profilesSummerCamps, profilesMain WHERE profilesSummerCamps.registerId = profilesMain.registerId";
		//echo $sql;
		$query=mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$name = $row['6'] . " " . $row['7'];
			$class = $row['8'];
			if ($class==14){
				$class="Prep";
			}
			$inst = $row['1'];
			$prog = $row['2'];
			$country = $row['3'];
			$city = $row['4'];
			$dateAdded = $row['5'];
			$dateAdded = explode("-", $dateAdded);
			$dateAdded = $dateAdded[0];
			
			$thisRow = "<tr><td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>$name</td>
<td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>$class</td><td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>$inst</td><td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>$prog</td><td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>$country</td><td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>$city</td><td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>$dateAdded</td></tr>";
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
					<br>Summer camp/internship information:
				</div>
					<br><br>
					<table style='border:1px solid black; border-collapse:collapse;'>
						<tr>
							<td style='border:1px solid black; border-collapse:collapse; color:#c1272d; font-weight:bold; padding:2px'>Student Name</td>
							<td style='border:1px solid black; border-collapse:collapse; color:#c1272d; font-weight:bold; padding:2px'>Class</td>
							<td style='border:1px solid black; border-collapse:collapse; color:#c1272d; font-weight:bold; padding:2px'>Institution</td>
							<td style='border:1px solid black; border-collapse:collapse; color:#c1272d; font-weight:bold; padding:2px'>Name of Program</td>
							<td style='border:1px solid black; border-collapse:collapse; color:#c1272d; font-weight:bold; padding:2px'>Country</td>
							<td style='border:1px solid black; border-collapse:collapse; color:#c1272d; font-weight:bold; padding:2px'>City/State</td>
							<td style='border:1px solid black; border-collapse:collapse; color:#c1272d; font-weight:bold; padding:2px'>Year added</td>
						</tr>
							<?PHP
								echo $allRows;
							?>
					</table>
					
				</td>
			</tr>
			<tr><td height='100px' colspan=7></td></tr>
		</table>
		
		<div class="copyright">&nbsp © INÇNET</div>
	</body>
</HTML>









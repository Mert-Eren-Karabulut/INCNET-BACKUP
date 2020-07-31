<?PHP

	error_reporting(0);

	/*
	 *This page moves the information from the Temp tables to the actual tables and deletes the values in the Temp tables.
	*/
	
	
	//Connect to DB
	include ("../db_connect.php");
	$con;
	if (!$con){
		die('Hata: ' . mysql_error());
	}
	
	session_start();
	if (isset($_SESSION['regid'])){
		$registerId = $_SESSION['regid'];;
	}else{
		header("location:index.php");	
	}
	
	//Main
	mysql_query("INSERT INTO incnet.profilesMain SELECT * FROM incnet.profilesMainTemp WHERE registerId = $registerId");
	//mysql_query("DELETE FROM incnet.profilesMainTemp WHERE registerId = $registerId");

	//Mother
	mysql_query("INSERT INTO incnet.profilesMotherinfo SELECT * FROM incnet.profilesMotherinfoTemp WHERE registerId = $registerId");
	//mysql_query("DELETE FROM incnet.profilesMotherinfoTemp WHERE registerId = $registerId");

	//Father
	mysql_query("INSERT INTO incnet.profilesFatherinfo SELECT * FROM incnet.profilesFatherinfoTemp WHERE registerId = $registerId");
	//mysql_query("DELETE FROM incnet.profilesFatherinfoTemp WHERE registerId = $registerId");

	//Relatives
	mysql_query("INSERT INTO incnet.profilesRelatives SELECT * FROM incnet.profilesRelativesTemp WHERE registerId = $registerId");
	//mysql_query("DELETE FROM incnet.profilesRelativesTemp WHERE registerId = $registerId");

	//Summer
	mysql_query("INSERT INTO incnet.profilesSummerCamps SELECT * FROM incnet.profilesSummerCampsTemp WHERE registerId = $registerId");
	//mysql_query("DELETE FROM incnet.profilesSummerCampsTemp WHERE registerId = $registerId");

	//Devices
	mysql_query("INSERT INTO incnet.profilesDevices SELECT * FROM incnet.profilesDevicesTemp WHERE registerId = $registerId");
	//mysql_query("DELETE FROM incnet.profilesDevicesTemp WHERE registerId = $registerId");

	
?>
<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="../incnet/favicon.ico" >
		<meta charset="utf-8">
		<body OnLoad="document.relatives.name.focus();">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<meta http-equiv="refresh" content="0.5; url=thankyou.php"> 

	</head>
	

	<body>
		<div class='container'>
			<center>
				<table border='0'>
					<tr>
						<td style='padding:15px;'><img src="loading.gif" width='60px' border='0'></td><td style='padding:15px;'> Bilgileriniz Kaydediliyor</td>
					</tr>
					<tr>
						<td colspan='2' style='text-align:center;'>
							<hr><br>
							Lütfen Bekleyiniz
						</td>
					</tr>
				</table></center>
			</div><hr>

		</div><br><br>
		<div class="copyright">© INÇNET</div>
	</body>
</html>
<?php
	error_reporting(0);
	
	//connect to mysql server
	require ("../../db_connect.php");
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
	$page_id = "901";
	session_start();
	$user_id = $_SESSION['user_id'];
	
	$permit_query = mysql_query("SELECT * FROM incnet.corepermits WHERE user_id='$user_id' AND page_id='$page_id'");
	while($permit_row = mysql_fetch_array($permit_query)){
		$allowance = "1";
	}
	if ($allowance != "1"){
		header ("location:../../incnet/login.php");
	}

	//count total records
	$query = mysql_query("SELECT count(*) FROM incnet.profilesmaintemp");
	while($row = mysql_fetch_array($query)){
		$totalRecCount = $row[0];
	}

	if (isset($_POST['search'])){
		$searchKey = $_POST['searchKey'];
		$query = mysql_query("SELECT registerId, name, lastname, class FROM incnet.profilesmaintemp WHERE lastname LIKE '%$searchKey%'");
		//echo $query;
		while($row = mysql_fetch_array($query)){
			$registerId = $row['registerId'];
			$name = $row['name'];
			$lastname = $row['lastname'];
			$class = $row['class'];
			if ($class==14){
				$class='Hz';
			}
			$studentRow[] = "<form method='get' action='viewStudent.php'><input type='hidden' name='selectStudent' value='$registerId'><input type='submit' name='select' value='Detay' style='width:60px; height:20px; background-color: transparent; border:1px solid black'>  $name $lastname (sınıfı: $class)</form>";
		}
		$recordCount = count($studentRow);

	} else if (isset($_POST['searchOld'])){
		$searchKey = $_POST['searchKeyOld'];
		$query = mysql_query("SELECT registerId, name, lastname, class FROM incnet.profilesmain WHERE lastname LIKE '%$searchKey%'");
		//echo $query;
		while($row = mysql_fetch_array($query)){
			$registerId = $row['registerId'];
			$name = $row['name'];
			$lastname = $row['lastname'];
			$class = $row['class'];
			if ($class==14){
				$class='Hz';
			}
			$studentRow[] = "<form method='get' action='viewOldEntry.php'><input type='hidden' name='selectStudent' value='$registerId'><input type='submit' name='select' value='Detay' style='width:60px; height:20px; background-color: transparent; border:1px solid black'>  $name $lastname (sınıfı: $class)</form>";
		}
		$recordCount = count($studentRow);

	}
?>

<!doctype html>
<HTML>
	<head>
		<link rel="shortcut icon" href="../../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="../style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<body OnLoad="document.selectSearch.searchKey.focus();">
		<style>
		a.button {
			width:130px;
			height:20px;
			background-color: transparent;
			border:1px solid #c1272d;
			color:#c1272d;
		}
		
		a.button:link {
			text-decoration: none;
		}

		a.button:visited {
			text-decoration: none;
		}

		a.button:hover {
			text-decoration: none;
		}

		a.button:active {
			text-decoration: none
		}
		</style>
	</head>
	<body>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px; text-align:center;' valign='top'>
					<a href='../../incnet'><img src='../../incnet/incnet.png' width='140px'></a>
					<a href='printAll.php' class='button' style=''>&nbsp;Hepsini Yazdır&nbsp;</a>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
				<div class='titleDiv'>
					<br>Öğrenci profili için:<br><br>
				</div>
					<form method='POST' name='selectSearch' autocomplete='off'>
						<a style='color:#c1272d' href='allProfiles.php'>Tüm kayıtları gör</a>
						<br><br>
						<c style='color:#c1272d'>Soyada göre ara:</c><br>
						<input type='text' name='searchKey' style='border:1px solid black; width:150px'>&nbsp<input type='submit' name='search' value='Ara' style='width:60px; background-color: transparent; border:1px solid black'><br><br>
					</form>
					<form method='POST' name='selectSearchOld' autocomplete='off'>
						<c style='color:#c1272d'>Soyada göre eski kayıt ara:</c><br>
						<input type='text' name='searchKeyOld' style='border:1px solid black; width:150px'>&nbsp<input type='submit' name='searchOld' value='Ara' style='width:60px; background-color: transparent; border:1px solid black'><br><br>
					</form>
						Toplam kayıt sayısı: <?PHP echo $totalRecCount; ?>.<br>
						<?PHP
							if ((isset($_POST['search']))&&($recordCount>0)){
								echo $recordCount . " kayıt bulundu!<br><br>";
							} else if ((isset($_POST['search']))&&($recordCount==0)){
								echo "Kayıt bulunamadı!<br><br>";
							}
							for ($i=0; $i<$recordCount; $i++){
								echo $studentRow[$i];
							}
						?>
					
				</td>
			</tr>
			<tr>
				<td style='height:40px'>
				</td>
			</tr>
		</table>
		<div class="copyright">&nbsp © INÇNET</div>
	</body>
</HTML>

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
	$page_id = "901";
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
	$query = mysql_query("SELECT profilesMain.registerId, profilesMain.name, profilesMain.lastname, profilesMain.DOB, profilesMain.tckn, profilesMain.class, profilesMain.address, profilesMain.semt, profilesMain.ilce, profilesMain.il, profilesMain.zipcode, profilesMain.homePhone, profilesMain.cellPhone, profilesMain.email, profilesMain.socialSecurity, profilesMain.parentsUnity, profilesMain.motherBio, profilesMain.fatherBio, profilesMain.motherLive, profilesMain.fatherLive, profilesMain.parentName, profilesMotherinfo.name, profilesMotherinfo.lastname, profilesMotherinfo.DOB, profilesMotherinfo.tckn, profilesMotherinfo.address, profilesMotherinfo.semt, profilesMotherinfo.ilce, profilesMotherinfo.il, profilesMotherinfo.zipcode, profilesMotherinfo.homePhone, profilesMotherinfo.cellPhone, profilesMotherinfo.fax, profilesMotherinfo.email, profilesMotherinfo.socialSecurity, profilesMotherinfo.profession, profilesMotherinfo.work, profilesMotherinfo.company, profilesMotherinfo.workAddress, profilesMotherinfo.workCity, profilesMotherinfo.workPhone, profilesFatherinfo.name, profilesFatherinfo.lastname, profilesFatherinfo.DOB, profilesFatherinfo.tckn, profilesFatherinfo.address, profilesFatherinfo.semt, profilesFatherinfo.ilce, profilesFatherinfo.il, profilesFatherinfo.zipcode, profilesFatherinfo.homePhone, profilesFatherinfo.cellPhone, profilesFatherinfo.fax, profilesFatherinfo.email, profilesFatherinfo.socialSecurity, profilesFatherinfo.profession, profilesFatherinfo.work, profilesFatherinfo.company, profilesFatherinfo.workAddress, profilesFatherinfo.workCity, profilesFatherinfo.workPhone FROM profilesMain, profilesMotherinfo, profilesFatherinfo WHERE profilesMain.registerId = profilesMotherinfo.registerId AND profilesMain.registerId = profilesFatherinfo.registerId");
	//echo $query;
	while($row = mysql_fetch_row($query)){
		$rowCount = count($row);

		$thisRegId = $row[0];
		$sql2 = "SELECT profilesRelatives.relativeId, profilesRelatives.registerId, profilesRelatives.name, profilesRelatives.lastname, profilesRelatives.relation, profilesRelatives.address, profilesRelatives.semt, profilesRelatives.ilce, profilesRelatives.il, profilesRelatives.zipcode, profilesRelatives.homePhone, profilesRelatives.cellPhone, profilesRelatives.workPhone, profilesRelatives.fax, profilesRelatives.email, profilesRelatives.profession FROM profilesRelatives WHERE profilesRelatives.registerId = '$thisRegId' ORDER BY relativeId DESC LIMIT 2";
		$query2 = mysql_query($sql2);
		while($row2 = mysql_fetch_row($query2)){
			$relRowCount = count($row2);
			for ($e=2; $e<$relRowCount; $e++){
				$relRow = $relRow . "<td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>" . $row2[$e] . "</td>";
			}
		}
				
		$theRow = $theRow . "<tr>";
		for ($i=1; $i<$rowCount; $i++){
			$theRow = $theRow . "<td style='border:1px solid black; border-collapse:collapse; color:black;  padding:2px'>" . $row[$i] . "</td>";
		}
		
		$theRow = $theRow . $relRow . "</tr>";
		$relRow = '';
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
					<br>Tüm kayıtlar:<br><br>
				</div>
				<!--Content-->
				<?PHP
					echo "<table style='border:1px solid black; border-collapse:collapse;'>";
				?>
				<tr>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Öğrenci Adı</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Soyadı</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Doğum Tarihi</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>TC Kimlik no</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Sınıf</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Adres</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Semt</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İlçe</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İl</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Posta kodu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Ev telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Cep telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Email</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Sosyal Güvenlik Kurumu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Anne-Baba birlikte</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Anne Öz</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Baba Öz</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Anne hayatta</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Baba hayatta</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Veli adı soyadı</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Anne Adı</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Soyadı</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Doğum Tarihi</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>TC Kimlik no</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Adres</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Semt</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İlçe</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İl</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Posta kodu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Ev telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Cep telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Fax</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Email</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Sosyal Güvenlik Kurumu</td>			
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Meslek</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Çalışma durumu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İşyeri adı ve ünvanı</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İş adresi</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İşyeri ili</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İş telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Baba Adı</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Soyadı</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Doğum Tarihi</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>TC Kimlik no</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Adres</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Semt</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İlçe</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İl</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Posta kodu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Ev telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Cep telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Fax</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Email</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Sosyal Güvenlik Kurumu</td>			
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Meslek</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Çalışma durumu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İşyeri adı ve ünvanı</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İş adresi</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İşyeri ili</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İş telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Akraba/yakın 1 Adı</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Soyadı</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Yakınlık derecesi</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Adres</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Semt</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İlçe</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İl</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Posta kodu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Ev telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Cep telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İş telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Fax</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Email</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Meslek</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Akraba/yakın 2 Adı</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Soyadı</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Yakınlık derecesi</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Adres</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Semt</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İlçe</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İl</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Posta kodu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Ev telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Cep telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>İş telefonu</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Fax</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Email</td>
					<td style='border:1px solid black; border-collapse:collapse; color:#c1272d;  padding:2px; font-weight:bold'>Meslek</td>

				</tr>
				
				<?PHP echo $theRow . "</table>";
				?>
				<!--/content-->
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









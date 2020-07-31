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
	$user_id = $_SESSION['user_id'];
	
	$permit_query = mysql_query("SELECT * FROM incnet.corepermits WHERE user_id='$user_id' AND page_id='$page_id'");
	while($permit_row = mysql_fetch_array($permit_query)){
		$allowance = "1";
	}
	if ($allowance != "1"){
		header ("location:../../incnet/login.php");
	}

	if (isset($_GET['selectStudent'])){
		$selectedStudent = $_GET['selectStudent'];
		$old = $_GET['old'];
		//echo $selectedStudent;
	} else {
		header("location:fullProfile.php");
	}
	
	if ($old == "false")
	{
		$table1 = "profilesmaintemp";
		$table2 = "profilesmotherinfotemp";
		$table3 = "profilesfatherinfotemp";
		$table4 = "profilesrelativestemp";
	}
	else if ($old == "true")
	{
		$table1 = "profilesmain";
		$table2 = "profilesmotherinfo";
		$table3 = "profilesfatherinfo";
		$table4 = "profilesrelatives";
	}
	
	$sql = "SELECT * FROM incnet.$table1 WHERE registerId = '$selectedStudent'";
	//echo $sql;
	$query=mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		$student_name = $row['name'];
		$student_lastname = $row['lastname'];
		$student_DOB = $row['DOB'];
		$student_tckn = $row['tckn'];
		$class = $row['class'];
		if ($class==14){
			$class='Hz';
		}
		$student_address = $row['address'];
		$student_semt = $row['semt'];
		$student_ilce = $row['ilce'];
		$student_il = $row['il'];
		$student_zipcode = $row['zipcode'];
		$student_homePhone = $row['homePhone'];
		$student_cellPhone = $row['cellPhone'];
		$student_email = $row['email'];
		$student_socialSecurity = $row['socialSecurity'];
		$parentsUnity = $row['parentsUnity'];
		$motherBio = $row['motherBio'];
		$fatherBio = $row['fatherBio'];
		$motherLive = $row['motherLive'];
		$fatherLive = $row['fatherLive'];
		$parentName = $row['parent'];
	}

	$sql = "SELECT * FROM incnet.$table2 WHERE registerId = '$selectedStudent'";
	//echo $sql;
	$query=mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		$mother_name = $row['name'];
		$mother_lastname = $row['lastname'];
		$mother_DOB = $row['DOB'];
		$mother_tckn = $row['tckn'];
		$mother_class = $row['class'];
		$mother_address = $row['address'];
		$mother_semt = $row['semt'];
		$mother_ilce = $row['ilce'];
		$mother_il = $row['il'];
		$mother_zipcode = $row['zipcode'];
		$mother_homePhone = $row['homePhone'];
		$mother_cellPhone = $row['cellPhone'];
		$mother_fax = $row['fax'];
		$mother_email = $row['email'];
		$mother_socialSecurity = $row['socialSecurity'];
		$mother_work = $row['work'];
		$mother_profession = $row['profession'];
		$mother_company = $row['company'];
		$mother_workAddress = $row['workAddress'];
		$mother_workCity = $row['workCity'];
		$mother_workPhone = $row['workPhone'];
	}

	$sql = "SELECT * FROM incnet.$table3 WHERE registerId = '$selectedStudent'";
	//echo $sql;
	$query=mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		$father_name = $row['name'];
		$father_lastname = $row['lastname'];
		$father_DOB = $row['DOB'];
		$father_tckn = $row['tckn'];
		$father_class = $row['class'];
		$father_address = $row['address'];
		$father_semt = $row['semt'];
		$father_ilce = $row['ilce'];
		$father_il = $row['il'];
		$father_zipcode = $row['zipcode'];
		$father_homePhone = $row['homePhone'];
		$father_cellPhone = $row['cellPhone'];
		$father_fax = $row['fax'];
		$father_email = $row['email'];
		$father_socialSecurity = $row['socialSecurity'];
		$father_work = $row['work'];
		$father_profession = $row['profession'];
		$father_company = $row['company'];
		$father_workAddress = $row['workAddress'];
		$father_workCity = $row['workCity'];
		$father_workPhone = $row['workPhone'];
	}
	
	$sql = "SELECT * FROM incnet.$table4 WHERE registerId = '$selectedStudent' ORDER BY relativeId DESC";
	//echo $sql;
	$query=mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		$rel1_ID = $row['relativeId'];
		$rel1_name = $row['name'];
		$rel1_lastname = $row['lastname'];
		$rel1_relation = $row['relation'];
		$rel1_address = $row['address'];
		$rel1_semt = $row['semt'];
		$rel1_ilce = $row['ilce'];
		$rel1_il = $row['il'];
		$rel1_zipcode = $row['zipcode'];
		$rel1_homePhone = $row['homePhone'];
		$rel1_cellPhone = $row['cellPhone'];
		$rel1_workPhone = $row['workPhone'];
		$rel1_fax = $row['fax'];
		$rel1_email = $row['email'];
		$rel1_profession = $row['profession'];
		
	}
	
	$sql = "SELECT * FROM incnet.$table4 WHERE registerId = '$selectedStudent' ORDER BY relativeId ASC";
	//echo $sql;
	$query=mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		$rel2_ID = $row['relativeId'];
		$rel2_name = $row['name'];
		$rel2_lastname = $row['lastname'];
		$rel2_relation = $row['relation'];
		$rel2_address = $row['address'];
		$rel2_semt = $row['semt'];
		$rel2_ilce = $row['ilce'];
		$rel2_il = $row['il'];
		$rel2_zipcode = $row['zipcode'];
		$rel2_homePhone = $row['homePhone'];
		$rel2_cellPhone = $row['cellPhone'];
		$rel2_workPhone = $row['workPhone'];
		$rel2_fax = $row['fax'];
		$rel2_email = $row['email'];
		$rel2_profession = $row['profession'];
		
	}


?>

<!doctype html>
<HTML>
	<head>
		<link rel="shortcut icon" href="../../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="../style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<style>
			@media print {
				body{
				font-size: 8pt;
				font-family:lucida grande,tahoma,verdana,arial,sans-serif;
				}

				.smallTitle{
					font-size:12pt;
					font-weight:bold;
					color: #c1272d;
				}
				
				.break{
					visibility: hidden;
					page-break-after:always;
				}
				
				.top{
					border:0;
					margin-top:75px;
				}				
				
		  }

			.smallTitle{
				font-size:12pt;
				font-weight:bold;
				color: #c1272d;
			}
		</style>
	</head>
	
	<body>
		<div style='position:absolute; width:650px; left:50%; margin-left:-325px;'>
			<table width=650px>
				<tr>
					<td width=110px>
						<img src='tevitol.png' width=105px>
					</td>
					<td width=580px>
						Aşağıdaki bilgiler web üzerinden doldurduğunuz formdan alınmıştır. Lütfen tüm bilgilerin tam ve doğru olduğunu kontrol ediniz.<br>
						Sistem türkçe karakter desteklemektedir, lütfen türkçe karakter kullanın, kullanmadıysanız düzeltin.<br><br>
						<c style='font-size:9pt'>*Evi İstanbul, Kocaeli ya da Yalova'da olan öğrencilerin akraba bilgileri bölümü boş kalabilir.</c>
					</td>
					<td width=110px style='text-align:right'>
						<img src='white.png' width=105px>
					</td>
				</tr>
			</table>
			<table class='top'>
				<tr>
					<td>
						<div class='smallTitle'>
							Öğrenci Bilgileri:<br><br>
						</div>
						<table width='325px' border=0>
							<tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Adı</td>
								<td><?PHP echo $student_name; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Soyadı</td>
								<td><?PHP echo $student_lastname; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Doğum Tarihi</td>
								<td><?PHP echo $student_DOB; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>TC kimlik no</td>
								<td><?PHP echo $student_tckn; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Sınıf</td>
								<td><?PHP echo $class; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Adres</td>
								<td><?PHP echo $student_address; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Semt</td>
								<td><?PHP echo $student_semt; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>İlçe</td>
								<td><?PHP echo $student_ilce; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>İl</td>
								<td><?PHP echo $student_il; ?></td>
							</tr>
						</table>
					</td>
					<td>
						<table width='325px' border=0>
							<tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Posta Kodu</td>
								<td><?PHP echo $student_zipcode; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Ev Telefonu</td>
								<td><?PHP echo $student_homePhone; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Cep Telefonu</td>
								<td><?PHP echo $student_cellPhone; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>email</td>
								<td><?PHP echo $student_email; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Bağlı bulunduğu SGK</td>
								<td><?PHP echo $student_socialSecurity; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Anne-Baba</td>
								<td>
									<?PHP if($parentsUnity=='1'){ echo "Beraber"; } ?>
									<?PHP if($parentsUnity=='0'){ echo "Ayrı"; } ?>
								</td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Anne</td>
								<td>
									<?PHP if($motherBio=='1'){ echo "Öz"; } ?>
									<?PHP if($motherBio=='0'){ echo "Üvey"; } ?>
								</td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Baba</td>
								<td>
									<?PHP if($fatherBio=='1'){ echo "Öz"; } ?>
									<?PHP if($fatherBio=='0'){ echo "Üvey"; } ?>
								</td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Anne</td>
								<td>
									<?PHP if($motherLive=='1'){ echo "Hayatta"; } ?>
									<?PHP if($motherLive=='0'){ echo "Vefat"; } ?>
								</td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Baba</td>
								<td>
									<?PHP if($fatherLive=='1'){ echo "Hayatta"; } ?>
									<?PHP if($fatherLive=='0'){ echo "Vefat"; } ?>
								</td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'> Kanuni Velisi</td>
								<td><?PHP echo $parentName; ?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr><td colspan=2><hr></td></tr>
				<tr>
					<td>
						<div class='smallTitle'>
							Anne Bilgileri:<br><br>
						</div>
						<table border=0>
							<tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Adı</td>
								<td><?PHP echo $mother_name; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Soyadı</td>
								<td><?PHP echo $mother_lastname; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Doğum Tarihi</td>
								<td><?PHP echo $mother_DOB; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>TC Kimlik no</td>
								<td><?PHP echo $mother_tckn; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Adres</td>
								<td><?PHP echo $mother_address; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Semt</td>
								<td><?PHP echo $mother_semt; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>İlçe</td>
								<td><?PHP echo $mother_ilce; ?> </td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>İl</td>
								<td><?PHP echo $mother_il; ?> </td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Posta Kodu</td>
								<td><?PHP echo $mother_zipcode; ?></td>
							</tr>
						</table>
					</td>
					<td>
						<table border=0>
							<tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Ev Telefonu</td>
								<td><?PHP echo $mother_homePhone; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Cep Telefonu</td>
								<td><?PHP echo $mother_cellPhone; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Fax</td>
								<td><?PHP echo $mother_fax; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>email</td>
								<td><?PHP echo $mother_email; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Bağlı bulunduğu SGK</td>
								<td><?PHP echo $mother_socialSecurity; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Mesleği</td>
								<td><?PHP echo $mother_profession; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Çalışma durumu</td>
								<td><?PHP echo $mother_work; ?></td>
							</tr><tr>
								<td colspan=2>
									<div>
										<c style='color:#c1272d; font-weight:bold'>İşyeri Adı ve Ünvanı</c>
										<?PHP echo $mother_company; ?><br>
										<c style='color:#c1272d; font-weight:bold'>Adres</c>
										<?PHP echo $mother_workAddress; ?><br>
										<c style='color:#c1272d; font-weight:bold'>İl</c>
										<?PHP echo $mother_workCity; ?><br>
										<c style='color:#c1272d; font-weight:bold'>İş Telefonu</c>
										<?PHP echo $mother_workPhone; ?><br>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<hr class='break'>
			<table class='top'>
				<tr>
					<td width='325px'>
						<div class='smallTitle'>
							Baba Bilgileri:<br><br>
						</div>
						<table>
							<tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Adı</td>
								<td><?PHP echo $father_name; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Soyadı</td>
								<td><?PHP echo $father_lastname; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Doğum Tarihi</td>
								<td><?PHP echo $father_DOB; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>TC Kimlik no</td>
								<td><?PHP echo $father_tckn; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Adres</td>
								<td><?PHP echo $father_address; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Semt</td>
								<td><?PHP echo $father_semt; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>İlçe</td>
								<td><?PHP echo $father_ilce; ?> </td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>İl</td>
								<td><?PHP echo $father_il; ?> </td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Posta Kodu</td>
								<td><?PHP echo $father_zipcode; ?></td>
							</tr>
						</table>
					</td>
					<td>
						<table>
							<tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Ev Telefonu</td>
								<td><?PHP echo $father_homePhone; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Cep Telefonu</td>
								<td><?PHP echo $father_cellPhone; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Fax</td>
								<td><?PHP echo $father_fax; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>email</td>
								<td><?PHP echo $father_email; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Bağlı bulunduğu <br>SGK</td>
								<td><?PHP echo $father_socialSecurity; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Mesleği</td>
								<td><?PHP echo $father_profession; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Çalışma durumu</td>
								<td><?PHP echo $father_work; ?></td>
							</tr><tr>
								<td colspan=2>
									<div>
										<c style='color:#c1272d; font-weight:bold'>İşyeri Adı ve Ünvanı</c>
										<?PHP echo $father_company; ?><br>
										<c style='color:#c1272d; font-weight:bold'>Adres</c>
										<?PHP echo $father_workAddress; ?><br>
										<c style='color:#c1272d; font-weight:bold'>İl</c>
										<?PHP echo $father_workCity; ?><br>
										<c style='color:#c1272d; font-weight:bold'>İş Telefonu</c>
										<?PHP echo $father_workPhone; ?><br>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan=2><hr></td>
				</tr>
				<tr>
					<td width='325px'>
						<div class='smallTitle'>
							Akraba/Yakın 1:<br><br>
						</div>
						<table>
							<tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Adı</td>
								<td><?PHP echo $rel1_name; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Soyadı</td>
								<td><?PHP echo $rel1_lastname; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Yakınlık Derecesi</td>
								<td><?PHP echo $rel1_relation; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Adres</td>
								<td><?PHP echo $rel1_address; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Semt</td>
								<td><?PHP echo $rel1_semt; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>İlçe</td>
								<td><?PHP echo $rel1_ilce; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>İl</td>
								<td><?PHP echo $rel1_il; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Posta Kodu</td>
								<td><?PHP echo $rel1_zipcode; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Ev Telefonu</td>
								<td><?PHP echo $rel1_homePhone; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Cep Telefonu</td>
								<td><?PHP echo $rel1_cellPhone; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>İş Telefonu</td>
								<td><?PHP echo $rel1_workPhone; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Fax</td>
								<td><?PHP echo $rel1_fax; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>email</td>
								<td><?PHP echo $rel1_email; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Mesleği</td>
								<td><?PHP echo $rel1_profession; ?></td>
							</tr>
					</table>
					</td>
					<td>
						<div class='smallTitle'>
							Akraba/Yakın 2:<br><br>
						</div>
						<table>
							<tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Adı</td>
								<td><?PHP echo $rel2_name; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Soyadı</td>
								<td><?PHP echo $rel2_lastname; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Yakınlık Derecesi</td>
								<td><?PHP echo $rel2_relation; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Adres</td>
								<td><?PHP echo $rel2_address; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Semt</td>
								<td><?PHP echo $rel2_semt; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>İlçe</td>
								<td><?PHP echo $rel2_ilce; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>İl</td>
								<td><?PHP echo $rel2_il; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Posta Kodu</td>
								<td><?PHP echo $rel2_zipcode; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Ev Telefonu</td>
								<td><?PHP echo $rel2_homePhone; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Cep Telefonu</td>
								<td><?PHP echo $rel2_cellPhone; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>İş Telefonu</td>
								<td><?PHP echo $rel2_workPhone; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Fax</td>
								<td><?PHP echo $rel2_fax; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>email</td>
								<td><?PHP echo $rel2_email; ?></td>
							</tr><tr>
								<td style='width:100px; color:#c1272d; font-weight:bold'>Mesleği</td>
								<td><?PHP echo $rel2_profession; ?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
</html>

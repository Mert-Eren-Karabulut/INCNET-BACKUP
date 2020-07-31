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

	if (isset($_GET['selectStudent'])){
		$selectedStudent = $_GET['selectStudent'];
		//echo $selectedStudent;
	} else {
		header("location:fullProfile.php");
	}
	
		if (isset($_POST['save'])){
		$student_name = $_POST['student_name'];
		$student_lastname = $_POST['student_lastname'];
		$student_DOB = $_POST['student_DOB'];
		$student_tckn = $_POST['student_tckn'];
		$class = $_POST['class'];
		$student_address = $_POST['student_address'];
		$student_semt = $_POST['student_semt'];
		$student_ilce = $_POST['student_ilce'];
		$student_il = $_POST['student_il'];
		$student_zipcode = $_POST['student_zipcode'];
		$student_homePhone = $_POST['student_homePhone'];
		$student_cellPhone = $_POST['student_cellPhone'];
		$student_email = $_POST['student_email'];
		$student_socialSecurity = $_POST['student_socialSecurity'];
		$parentsUnity = $_POST['parentsUnity'];
		$motherBio = $_POST['motherBio'];
		$fatherBio = $_POST['fatherBio'];
		$motherLive = $_POST['motherLive'];
		$fatherLive = $_POST['fatherLive'];
		$parentName = $_POST['parentName'];

		$sql = "UPDATE incnet.profilesMain SET name='$student_name', lastname='$student_lastname', DOB='$student_DOB', tckn='$student_tckn', class='$class', address='$student_address', semt='$student_semt', ilce='$student_ilce', il='$student_il', zipcode='$student_zipcode', homePhone='$student_homePhone', cellPhone='$student_cellPhone', email='$student_email', socialSecurity='$student_socialSecurity', parentsUnity='$parentsUnity', motherBio='$motherBio', fatherBio='$fatherBio', motherLive='$motherLive', fatherlive='$fatherLive', parentName='$parentName' WHERE registerId='$selectedStudent'";
		//echo $sql;
		mysql_query($sql);
		
		$mother_name = $_POST['mother_name'];
		$mother_lastname = $_POST['mother_lastname'];
		$mother_DOB = $_POST['mother_DOB'];
		$mother_tckn = $_POST['mother_tckn'];
		$mother_address = $_POST['mother_address'];
		$mother_semt = $_POST['mother_semt'];
		$mother_ilce = $_POST['mother_ilce'];
		$mother_il = $_POST['mother_il'];
		$mother_zipcode = $_POST['mother_zipcode'];
		$mother_homePhone = $_POST['mother_homePhone'];
		$mother_cellPhone = $_POST['mother_cellPhone'];
		$mother_fax = $_POST['mother_fax'];
		$mother_email = $_POST['mother_email'];
		$mother_socialSecurity = $_POST['mother_socialSecurity'];
		$mother_profession = $_POST['mother_profession'];
		$mother_work = $_POST['mother_work'];
		$mother_company = $_POST['mother_company'];
		$mother_workAddress = $_POST['mother_workAddress'];
		$mother_workCity = $_POST['mother_workCity'];
		$mother_workPhone = $_POST['mother_workPhone'];
		
		$sql = "UPDATE incnet.profilesMotherinfo SET name='$mother_name', lastname='$mother_lastname', DOB='$mother_DOB', tckn='$mother_tckn', address='$mother_address', semt='$mother_semt', ilce='$mother_ilce', il='$mother_il', zipcode='$mother_zipcode', homePhone='$mother_homePhone', cellPhone='$mother_cellPhone', fax='$mother_fax', email='$mother_email', socialSecurity='$mother_socialSecurity', profession='$mother_profession', work='$mother_work', company='$mother_company', workAddress='$mother_workAddress', workCity='$mother_workCity', workPhone='$mother_workPhone' WHERE registerId='$selectedStudent'";
		//echo $sql;
		mysql_query($sql);
		
		$father_name = $_POST['father_name'];
		$father_lastname = $_POST['father_lastname'];
		$father_DOB = $_POST['father_DOB'];
		$father_tckn = $_POST['father_tckn'];
		$father_address = $_POST['father_address'];
		$father_semt = $_POST['father_semt'];
		$father_ilce = $_POST['father_ilce'];
		$father_il = $_POST['father_il'];
		$father_zipcode = $_POST['father_zipcode'];
		$father_homePhone = $_POST['father_homePhone'];
		$father_cellPhone = $_POST['father_cellPhone'];
		$father_fax = $_POST['father_fax'];
		$father_email = $_POST['father_email'];
		$father_socialSecurity = $_POST['father_socialSecurity'];
		$father_profession = $_POST['father_profession'];
		$father_work = $_POST['father_work'];
		$father_company = $_POST['father_company'];
		$father_workAddress = $_POST['father_workAddress'];
		$father_workCity = $_POST['father_workCity'];
		$father_workPhone = $_POST['father_workPhone'];
		
		$sql = "UPDATE incnet.profilesFatherinfo SET name='$father_name', lastname='$father_lastname', DOB='$father_DOB', tckn='$father_tckn', address='$father_address', semt='$father_semt', ilce='$father_ilce', il='$father_il', zipcode='$father_zipcode', homePhone='$father_homePhone', cellPhone='$father_cellPhone', fax='$father_fax', email='$father_email', socialSecurity='$father_socialSecurity', profession='$father_profession', work='$father_work', company='$father_company', workAddress='$father_workAddress', workCity='$father_workCity', workPhone='$father_workPhone' WHERE registerId='$selectedStudent'";
		//echo $sql;
		mysql_query($sql);
		
		$rel1_ID = $_POST['rel1_ID'];
		$rel1_name = $_POST['rel1_name'];
		$rel1_lastname = $_POST['rel1_lastname'];
		$rel1_relation = $_POST['rel1_relation'];
		$rel1_address = $_POST['rel1_address'];
		$rel1_semt = $_POST['rel1_semt'];
		$rel1_ilce = $_POST['rel1_ilce'];
		$rel1_il = $_POST['rel1_il'];
		$rel1_zipcode = $_POST['rel1_zipcode'];
		$rel1_homePhone = $_POST['rel1_homePhone'];
		$rel1_cellPhone = $_POST['rel1_cellPhone'];
		$rel1_workPhone = $_POST['rel1_workPhone'];
		$rel1_fax = $_POST['rel1_fax'];
		$rel1_email = $_POST['rel1_email'];
		$rel1_profession = $_POST['rel1_profession'];
		
		if ($rel1_ID==''){
			$sql = "INSERT INTO incnet.profilesRelatives values(NULL, '$selectedStudent', '$rel1_name', '$rel1_lastname', '$rel1_relation', '$rel1_address', '$rel1_semt', '$rel1_ilce', '$rel1_il', '$rel1_zipcode', '$rel1_homePhone', '$rel1_cellPhone', '$rel1_workPhone', '$rel1_fax', '$rel1_email', '$rel1_profession')";	
		}else{
			$sql = "UPDATE incnet.profilesRelatives SET name='$rel1_name', lastname='$rel1_lastname', relation='$rel1_relation', address='$rel1_address', semt='$rel1_semt', ilce='$rel1_ilce', il='$rel1_il', zipcode='$rel1_zipcode', homePhone='$rel1_homePhone', cellPhone='$rel1_cellPhone', workPhone='$rel1_workPhone', fax='$rel1_fax', email='$rel1_email', profession='$rel1_profession' WHERE registerId='$selectedStudent' AND relativeId='$rel1_ID'";	
		}
		
		//echo $sql;
		mysql_query($sql);

		$rel2_ID = $_POST['rel2_ID'];		
		$rel2_name = $_POST['rel2_name'];
		$rel2_lastname = $_POST['rel2_lastname'];
		$rel2_relation = $_POST['rel2_relation'];
		$rel2_address = $_POST['rel2_address'];
		$rel2_semt = $_POST['rel2_semt'];
		$rel2_ilce = $_POST['rel2_ilce'];
		$rel2_il = $_POST['rel2_il'];
		$rel2_zipcode = $_POST['rel2_zipcode'];
		$rel2_homePhone = $_POST['rel2_homePhone'];
		$rel2_cellPhone = $_POST['rel2_cellPhone'];
		$rel2_workPhone = $_POST['rel2_workPhone'];
		$rel2_fax = $_POST['rel2_fax'];
		$rel2_email = $_POST['rel2_email'];
		$rel2_profession = $_POST['rel2_profession'];
		
if ($rel2_ID==''){
			$sql = "INSERT INTO incnet.profilesRelatives values(NULL, '$selectedStudent', '$rel2_name', '$rel2_lastname', '$rel2_relation', '$rel2_address', '$rel2_semt', '$rel2_ilce', '$rel2_il', '$rel2_zipcode', '$rel2_homePhone', '$rel2_cellPhone', '$rel2_workPhone', '$rel2_fax', '$rel2_email', '$rel2_profession')";	
		}else{
			$sql = "UPDATE incnet.profilesRelatives SET name='$rel2_name', lastname='$rel2_lastname', relation='$rel2_relation', address='$rel2_address', semt='$rel2_semt', ilce='$rel2_ilce', il='$rel2_il', zipcode='$rel2_zipcode', homePhone='$rel2_homePhone', cellPhone='$rel2_cellPhone', workPhone='$rel2_workPhone', fax='$rel2_fax', email='$rel2_email', profession='$rel2_profession' WHERE registerId='$selectedStudent' AND relativeId='$rel2_ID'";	
		}
		//echo $sql;
		mysql_query($sql);

	}

	
	$sql = "SELECT * FROM incnet.profilesMain WHERE registerId = '$selectedStudent'";
	//echo $sql;
	$query=mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		$student_name = $row['name'];
		$student_lastname = $row['lastname'];
		$student_DOB = $row['DOB'];
		$student_tckn = $row['tckn'];
		$class = $row['class'];
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
		$parentName = $row['parentName'];
	}

	$sql = "SELECT * FROM incnet.profilesMotherinfo WHERE registerId = '$selectedStudent'";
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

	$sql = "SELECT * FROM incnet.profilesFatherinfo WHERE registerId = '$selectedStudent'";
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
	
	$sql = "SELECT * FROM incnet.profilesRelatives WHERE registerId = '$selectedStudent' ORDER BY relativeId DESC";
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
	
	$sql = "SELECT * FROM incnet.profilesRelatives WHERE registerId = '$selectedStudent' ORDER BY relativeId ASC";
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
		<body OnLoad="document.selectSearch.searchName.focus();">
			</head>
	
	<body>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='fullProfile.php'><img src='../../incnet/incnet.png' width='140px'></a>
					<form method='GET' action='printStudent.php'>
						<input type='hidden' name='selectStudent' value="<?PHP echo $selectedStudent; ?>">
						<input type='submit' name='printNow' value='Yazıcı Versiyonu' style='width:130px; height:20px; background-color: transparent; border:1px solid #c1272d; color:#c1272d'>
					</form>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<!--Content-->
					<form name="allInfo" method='POST' autocomplete='off'>
					<div style='color: #c1272d; font-size:12pt'><?PHP echo $error; ?></div>
						<div class='titleDiv'>
							Öğrenci Bilgileri:
						</div>
						<table>
							<tr>
								<td>Adı</td>
								<td><input type='text' name='student_name' maxlength='25' value='<?PHP echo $student_name; ?>' ></td>
							</tr><tr>
								<td>Soyadı</td>
								<td><input type='text' name='student_lastname' maxlength='25' value='<?PHP echo $student_lastname; ?>' ></td>
							</tr><tr>
								<td>Doğum Tarihi</td>
								<td><input type='text' name='student_DOB' maxlength='10' value="<?PHP echo $student_DOB; ?>" ></td>
							</tr><tr>
								<td>TC kimlik no</td>
								<td><input type='text' name='student_tckn' maxlength='11' value="<?PHP echo $student_tckn; ?>" ></td>
							</tr><tr>
								<td>Sınıf</td>
								<td>
									<select name="class">
										<option value="">Seçiniz…</option>
										<option value="14" <?PHP if($class=='14'){ echo "selected='yes'"; } ?>>Hazırlık</option>
										<option value="9" <?PHP if($class=='9'){ echo "selected='yes'"; } ?>>9. Sınıf</option>
										<option value="10" <?PHP if($class=='10'){ echo "selected='yes'"; } ?>>10. Sınıf</option>
										<option value="11" <?PHP if($class=='11'){ echo "selected='yes'"; } ?>>11. Sınıf</option>												
										<option value="12" <?PHP if($class=='12'){ echo "selected='yes'"; } ?>>12. Sınıf</option>
								</select>
							</tr><tr>
								<td>Adres</td>
								<td><input type='text' name='student_address' maxlength='200' value="<?PHP echo $student_address; ?>" ></td>
							</tr><tr>
								<td>Semt</td>
								<td><input type='text' name='student_semt' maxlength='40' value="<?PHP echo $student_semt; ?>" ></td>
							</tr><tr>
								<td>İlçe</td>
								<td><input type='text' name='student_ilce' maxlength='40' value="<?PHP echo $student_ilce; ?>" ></td>
							</tr><tr>
								<td>İl</td>
								<td><input type='text' name='student_il' maxlength='40' value="<?PHP echo $student_il; ?>" ></td>
							</tr><tr>
								<td>Posta Kodu</td>
								<td><input type='text' name='student_zipcode' maxlength='5' value="<?PHP echo $student_zipcode; ?>" ></td>
							</tr><tr>
								<td>Ev Telefonu</td>
								<td><input type='text' name='student_homePhone' maxlength='11' value="<?PHP echo $student_homePhone; ?>" ></td>
							</tr><tr>
								<td>Cep Telefonu</td>
								<td><input type='text' name='student_cellPhone' maxlength='11' value="<?PHP echo $student_cellPhone; ?>" ></td>
							</tr><tr>
								<td>email</td>
								<td><input type='email' name='student_email' maxlength='100' value="<?PHP echo $student_email; ?>" ></td>
							</tr><tr>
								<td>Bağlı bulunduğu <br>Sosyal güvenlik kurumu</td>
								<td><select name='student_socialSecurity'>
											<option value=''>Seçiniz...</option>
											<option value='SGK' <?PHP if($student_socialSecurity=='SGK'){ echo "selected='yes'"; } ?>>SGK</option>
											<option value='Bagkur' <?PHP if($student_socialSecurity=='Bagkur'){ echo "selected='yes'"; } ?>>Bağkur</option>
											<option value='Emekli Sandığı' <?PHP if($student_socialSecurity=='Emekli Sandığı'){ echo "selected='yes'"; } ?>>Emekli Sandığı</option>
											<option value='Diğer' <?PHP if($student_socialSecurity=='Diğer'){ echo "selected='yes'"; } ?>>Diğer</option>
										</select>
								</td>
							</tr><tr>
								<td>Anne-Baba</td>
								<td>
									<input type="radio" name="parentsUnity" onclick="hideMe()" value="1" <?PHP if($parentsUnity=='1'){ echo "checked='checked'"; } ?>>Beraber &nbsp
									<input type="radio" name="parentsUnity" onclick="showMe()" value="0" <?PHP if($parentsUnity=='0'){ echo "checked='checked'"; } ?>>Ayrı
								</td>
							</tr><tr>
								<td>Anne</td>
								<td>
									<input type="radio" name="motherBio" value="1" <?PHP if($motherBio=='1'){ echo "checked='checked'"; } ?>>Öz &nbsp
									<input type="radio" name="motherBio" value="0" <?PHP if($motherBio=='0'){ echo "checked='checked'"; } ?>>Üvey
								</td>
							</tr><tr>
								<td>Baba</td>
								<td>
									<input type="radio" name="fatherBio" value="1" <?PHP if($fatherBio=='1'){ echo "checked='checked'"; } ?>>Öz &nbsp
									<input type="radio" name="fatherBio" value="0" <?PHP if($fatherBio=='0'){ echo "checked='checked'"; } ?>>Üvey
								</td>
							</tr><tr>
								<td>Anne</td>
								<td>
									<input type="radio" name="motherLive" value="1" <?PHP if($motherLive=='1'){ echo "checked='checked'"; } ?>>Hayatta &nbsp
									<input type="radio" name="motherLive" value="0" <?PHP if($motherLive=='0'){ echo "checked='checked'"; } ?>>Vefat
								</td>
							</tr><tr>
								<td>Baba</td>
								<td>
									<input type="radio" name="fatherLive" value="1" <?PHP if($fatherLive=='1'){ echo "checked='checked'"; } ?>>Hayatta &nbsp
									<input type="radio" name="fatherLive" value="0" <?PHP if($fatherLive=='0'){ echo "checked='checked'"; } ?>>Vefat
								</td>
							</tr><tr>
								<td> Kanuni Velisi:</td>
								<td>
									<table id="p1">
										<tr>
											<td><input type='text' name='parentName' maxlength='40' value='<?PHP echo $parentName; ?>'></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						
						<div class='titleDiv'>
							<br>Anne Bilgileri:
						</div>
						<table>
							<tr>
								<td>Adı</td>
								<td><input type='text' name='mother_name' maxlength='25' value='<?PHP echo $mother_name; ?>' ></td>
							</tr><tr>
								<td>Soyadı</td>
								<td><input type='text' name='mother_lastname' maxlength='25' value='<?PHP echo $mother_lastname; ?>' ></td>
							</tr><tr>
								<td>Doğum Tarihi</td>
								<td><input type='text' name='mother_DOB' maxlength='10' value="<?PHP echo $mother_DOB; ?>" ></td>
							</tr><tr>
								<td>TC Kimlik no</td>
								<td><input type='text' name='mother_tckn' maxlength='11' value='<?PHP echo $mother_tckn; ?>' ></td>
							</tr><tr>
								<td>Adres</td>
								<td><input type='text' name='mother_address' maxlength='200' value='<?PHP echo $mother_address; ?>' ></td>
							</tr><tr>
								<td>Semt</td>
								<td><input type='text' name='mother_semt' maxlength='40'  value='<?PHP echo $mother_semt; ?>' ></td>
							</tr><tr>
								<td>İlçe</td>
								<td><input type='text' name='mother_ilce' maxlength='40' value='<?PHP echo $mother_ilce; ?>' ></td>
							</tr><tr>
								<td>İl</td>
								<td><input type='text' name='mother_il' maxlength='40' value='<?PHP echo $mother_il; ?>' ></td>
							</tr><tr>
								<td>Posta Kodu</td>
								<td><input type='text' name='mother_zipcode' maxlength='5' value="<?PHP echo $mother_zipcode; ?>" ></td>
							</tr><tr>
								<td>Ev Telefonu</td>
								<td><input type='text' name='mother_homePhone' maxlength='11' value="<?PHP echo $mother_homePhone; ?>" ></td>
							</tr><tr>
								<td>Cep Telefonu</td>
								<td><input type='text' name='mother_cellPhone' maxlength='11' value="<?PHP echo $mother_cellPhone; ?>" ></td>
							</tr><tr>
								<td>Fax</td>
								<td><input type='text' name='mother_fax' maxlength='11' value="<?PHP echo $mother_fax; ?>" ></td>
							</tr><tr>
								<td>email</td>
								<td><input type='email' name='mother_email' maxlength='100' value="<?PHP echo $mother_email; ?>" ></td>
							</tr><tr>
								<td>Bağlı bulunduğu <br>Sosyal güvenlik kurumu</td>
								<td><select name='mother_socialSecurity'>
											<option value=''>Seçiniz...</option>
											<option value='SGK' <?PHP if($mother_socialSecurity=='SGK'){ echo "selected='yes'"; } ?>>SGK</option>
											<option value='Bagkur' <?PHP if($mother_socialSecurity=='Bagkur'){ echo "selected='yes'"; } ?>>Bağkur</option>
											<option value='Emekli Sandığı' <?PHP if($mother_socialSecurity=='Emekli Sandığı'){ echo "selected='yes'"; } ?>>Emekli Sandığı</option>
											<option value='Diğer' <?PHP if($mother_socialSecurity=='Diğer'){ echo "selected='yes'"; } ?>>Diğer</option>
										</select>
								</td>
							</tr><tr>
								<td>Mesleği</td>
								<td><input type='text' name='mother_profession' maxlength='100' value="<?PHP echo $mother_profession; ?>" ></td>
							</tr><tr>
								<td>Çalışma durumu</td>
								<td><select name='mother_work'>
											<option value=''>Seçiniz...</option>
											<option value='ücretli' <?PHP if($mother_work=='ücretli'){ echo "selected='yes'"; }?>>Ücretli</option>
											<option value='bağımsız' <?PHP if($mother_work=='bağımsız'){ echo "selected='yes'"; }?>>Bağımsız</option>
											<option value='kamu' <?PHP if($mother_work=='kamu'){ echo "selected='yes'"; }?>>Kamu</option>
											<option value='isteğe bağlı' <?PHP if($mother_work=='isteğe bağlı'){ echo "selected='yes'"; }?>>İsteğe Bağlı</option>
											<option value='tarım' <?PHP if($mother_work=='tarım'){ echo "selected='yes'"; }?>>Tarım</option>
											<option value='emekli' <?PHP if($mother_work=='emekli'){ echo "selected='yes'"; }?>>Emekli</option>
											<option value='ev hanımı' <?PHP if($mother_work=='ev hanımı'){ echo "selected='yes'"; }?>>Ev Hanımı</option>
											<option value='öğrenci' <?PHP if($mother_work=='öğrenci'){ echo "selected='yes'"; }?>>Öğrenci</option>
											<option value='çalışmıyor' <?PHP if($mother_work=='çalışmıyor'){ echo "selected='yes'"; }?>>Çalışmıyor</option>
										</select>
								</td>
							</tr><tr>
								<td colspan=2>
									<div>
										İşyeri Adı ve Ünvanı<br>
										<input type='text' name='mother_company' maxlength='200' value="<?PHP echo $mother_company; ?>" ><br>
										Adres<br>
										<input type='text' name='mother_workAddress' maxlength='40' value="<?PHP echo $mother_workAddress; ?>" ><br>
										İl<br>
										<input type='text' name='mother_workCity' maxlength='40' value="<?PHP echo $mother_workCity; ?>" ><br>
										İş Telefonu<br>
										<input type='text' name='mother_workPhone' maxlength='11' value="<?PHP echo $mother_workPhone; ?>" ><br>
										</tr>
									</div>
		
								</td>
							</tr>
						</table>
						<div class='titleDiv'>
							<br>Baba Bilgileri:
						</div>
						<table>
							<tr>
								<td>Adı</td>
								<td><input type='text' name='father_name' maxlength='25' value='<?PHP echo $father_name; ?>' ></td>
							</tr><tr>
								<td>Soyadı</td>
								<td><input type='text' name='father_lastname' maxlength='25' value='<?PHP echo $father_lastname; ?>' ></td>
							</tr><tr>
								<td>Doğum Tarihi</td>
								<td><input type='text' name='father_DOB' maxlength='10' value="<?PHP echo $father_DOB; ?>" ></td>
							</tr><tr>
								<td>TC Kimlik no</td>
								<td><input type='text' name='father_tckn' maxlength='11' value='<?PHP echo $father_tckn; ?>' ></td>
							</tr><tr>
								<td>Adres</td>
								<td><input type='text' name='father_address' maxlength='200' value='<?PHP echo $father_address; ?>' ></td>
							</tr><tr>
								<td>Semt</td>
								<td><input type='text' name='father_semt' maxlength='40'  value='<?PHP echo $father_semt; ?>' ></td>
							</tr><tr>
								<td>İlçe</td>
								<td><input type='text' name='father_ilce' maxlength='40' value='<?PHP echo $father_ilce; ?>' ></td>
							</tr><tr>
								<td>İl</td>
								<td><input type='text' name='father_il' maxlength='40' value='<?PHP echo $father_il; ?>' ></td>
							</tr><tr>
								<td>Posta Kodu</td>
								<td><input type='text' name='father_zipcode' maxlength='5' value="<?PHP echo $father_zipcode; ?>" ></td>
							</tr><tr>
								<td>Ev Telefonu</td>
								<td><input type='text' name='father_homePhone' maxlength='11' value="<?PHP echo $father_homePhone; ?>" ></td>
							</tr><tr>
								<td>Cep Telefonu</td>
								<td><input type='text' name='father_cellPhone' maxlength='11' value="<?PHP echo $father_cellPhone; ?>" ></td>
							</tr><tr>
								<td>Fax</td>
								<td><input type='text' name='father_fax' maxlength='11' value="<?PHP echo $father_fax; ?>" ></td>
							</tr><tr>
								<td>email</td>
								<td><input type='email' name='father_email' maxlength='100' value="<?PHP echo $father_email; ?>" ></td>
							</tr><tr>
								<td>Bağlı bulunduğu <br>Sosyal güvenlik kurumu</td>
								<td><select name='father_socialSecurity'>
											<option value=''>Seçiniz...</option>
											<option value='SGK' <?PHP if($father_socialSecurity=='SGK'){ echo "selected='yes'"; } ?>>SGK</option>
											<option value='Bagkur' <?PHP if($father_socialSecurity=='Bagkur'){ echo "selected='yes'"; } ?>>Bağkur</option>
											<option value='Emekli Sandığı' <?PHP if($father_socialSecurity=='Emekli Sandığı'){ echo "selected='yes'"; } ?>>Emekli Sandığı</option>
											<option value='Diğer' <?PHP if($father_socialSecurity=='Diğer'){ echo "selected='yes'"; } ?>>Diğer</option>
										</select>
								</td>
							</tr><tr>
								<td>Mesleği</td>
								<td><input type='text' name='father_profession' maxlength='100' value="<?PHP echo $father_profession; ?>" ></td>
							</tr><tr>
								<td>Çalışma durumu</td>
								<td><select name='father_work'>
											<option value=''>Seçiniz...</option>
											<option value='ücretli' <?PHP if($father_work=='ücretli'){ echo "selected='yes'"; }?>>Ücretli</option>
											<option value='bağımsız' <?PHP if($father_work=='bağımsız'){ echo "selected='yes'"; }?>>Bağımsız</option>
											<option value='kamu' <?PHP if($father_work=='kamu'){ echo "selected='yes'"; }?>>Kamu</option>
											<option value='isteğe bağlı' <?PHP if($father_work=='isteğe bağlı'){ echo "selected='yes'"; }?>>İsteğe Bağlı</option>
											<option value='tarım' <?PHP if($father_work=='tarım'){ echo "selected='yes'"; }?>>Tarım</option>
											<option value='emekli' <?PHP if($father_work=='emekli'){ echo "selected='yes'"; }?>>Emekli</option>
											<option value='öğrenci' <?PHP if($father_work=='öğrenci'){ echo "selected='yes'"; }?>>Öğrenci</option>
											<option value='çalışmıyor' <?PHP if($father_work=='çalışmıyor'){ echo "selected='yes'"; }?>>Çalışmıyor</option>
										</select>
								</td>
							</tr><tr>
								<td colspan=2>
									<div>
										İşyeri Adı ve Ünvanı<br>
										<input type='text' name='father_company' maxlength='200' value="<?PHP echo $father_company; ?>" ><br>
										Adres<br>
										<input type='text' name='father_workAddress' maxlength='40' value="<?PHP echo $father_workAddress; ?>" ><br>
										İl<br>
										<input type='text' name='father_workCity' maxlength='40' value="<?PHP echo $father_workCity; ?>" ><br>
										İş Telefonu<br>
										<input type='text' name='father_workPhone' maxlength='11' value="<?PHP echo $father_workPhone; ?>" ><br>
										</tr>
									</div>
		
								</td>
							</tr>
						</table>
						<div class='titleDiv'>
							<br>Akraba/Yakın 1:
						</div>
						<table>
							<tr>
								<td>Adı<input type='hidden' name='rel1_ID' value='<?PHP echo $rel1_ID; ?>'></td>
								<td><input type='text' name='rel1_name' maxlength='25' value="<?PHP echo $rel1_name; ?>"></td>
							</tr><tr>
								<td>Soyadı</td>
								<td><input type='text' name='rel1_lastname' maxlength='25' value="<?PHP echo $rel1_lastname; ?>"></td>
							</tr><tr>
								<td>Yakınlık Derecesi</td>
								<td><input type='text' name='rel1_relation' maxlength='25' value="<?PHP echo $rel1_relation; ?>"></td>
							</tr><tr>
								<td>Adres</td>
								<td><input type='text' name='rel1_address' maxlength='200' value="<?PHP echo $rel1_address; ?>"></td>
							</tr><tr>
								<td>Semt</td>
								<td><input type='text' name='rel1_semt' maxlength='40' value="<?PHP echo $rel1_semt; ?>"></td>
							</tr><tr>
								<td>İlçe</td>
								<td><input type='text' name='rel1_ilce' maxlength='40' value="<?PHP echo $rel1_ilce; ?>"></td>
							</tr><tr>
								<td>İl</td>
								<td><input type='text' name='rel1_il' maxlength='40' value="<?PHP echo $rel1_il; ?>"></td>
							</tr><tr>
								<td>Posta Kodu</td>
								<td><input type='text' name='rel1_zipcode' maxlength='5' value="<?PHP echo $rel1_zipcode; ?>"></td>
							</tr><tr>
								<td>Ev Telefonu</td>
								<td><input type='text' name='rel1_homePhone' maxlength='11' value="<?PHP echo $rel1_homePhone; ?>" ></td>
							</tr><tr>
								<td>Cep Telefonu</td>
								<td><input type='text' name='rel1_cellPhone' maxlength='11' value="<?PHP echo $rel1_cellPhone; ?>" ></td>
							</tr><tr>
								<td>İş Telefonu</td>
								<td><input type='text' name='rel1_workPhone' maxlength='11' value="<?PHP echo $rel1_workPhone; ?>" ></td>
							</tr><tr>
								<td>Fax</td>
								<td><input type='text' name='rel1_fax' maxlength='11' value="<?PHP echo $rel1_fax; ?>" ></td>
							</tr><tr>
								<td>email</td>
								<td><input type='email' name='rel1_email' maxlength='100' value="<?PHP echo $rel1_email; ?>"></td>
							</tr><tr>
								<td>Mesleği</td>
								<td><input type='text' name='rel1_profession' maxlength='25' value="<?PHP echo $rel1_profession; ?>"></td>
							</tr>
					</table>
						<div class='titleDiv'>
							<br>Akraba/Yakın 2:
						</div>
						<table>
							<tr>
								<td>Adı<input type='hidden' name='rel2_ID' value='<?PHP echo $rel2_ID; ?>'></td>
								<td><input type='text' name='rel2_name' maxlength='25' value="<?PHP echo $rel2_name; ?>"></td>
							</tr><tr>
								<td>Soyadı</td>
								<td><input type='text' name='rel2_lastname' maxlength='25' value="<?PHP echo $rel2_lastname; ?>"></td>
							</tr><tr>
								<td>Yakınlık Derecesi</td>
								<td><input type='text' name='rel2_relation' maxlength='25' value="<?PHP echo $rel2_relation; ?>"></td>
							</tr><tr>
								<td>Adres</td>
								<td><input type='text' name='rel2_address' maxlength='200' value="<?PHP echo $rel2_address; ?>"></td>
							</tr><tr>
								<td>Semt</td>
								<td><input type='text' name='rel2_semt' maxlength='40' value="<?PHP echo $rel2_semt; ?>"></td>
							</tr><tr>
								<td>İlçe</td>
								<td><input type='text' name='rel2_ilce' maxlength='40' value="<?PHP echo $rel2_ilce; ?>"></td>
							</tr><tr>
								<td>İl</td>
								<td><input type='text' name='rel2_il' maxlength='40' value="<?PHP echo $rel2_il; ?>"></td>
							</tr><tr>
								<td>Posta Kodu</td>
								<td><input type='text' name='rel2_zipcode' maxlength='5' value="<?PHP echo $rel2_zipcode; ?>"></td>
							</tr><tr>
								<td>Ev Telefonu</td>
								<td><input type='text' name='rel2_homePhone' maxlength='11' value="<?PHP echo $rel2_homePhone; ?>" ></td>
							</tr><tr>
								<td>Cep Telefonu</td>
								<td><input type='text' name='rel2_cellPhone' maxlength='11' value="<?PHP echo $rel2_cellPhone; ?>" ></td>
							</tr><tr>
								<td>İş Telefonu</td>
								<td><input type='text' name='rel2_workPhone' maxlength='11' value="<?PHP echo $rel2_workPhone; ?>" ></td>
							</tr><tr>
								<td>Fax</td>
								<td><input type='text' name='rel2_fax' maxlength='11' value="<?PHP echo $rel2_fax; ?>" ></td>
							</tr><tr>
								<td>email</td>
								<td><input type='email' name='rel2_email' maxlength='100' value="<?PHP echo $rel2_email; ?>"></td>
							</tr><tr>
								<td>Mesleği</td>
								<td><input type='text' name='rel2_profession' maxlength='25' value="<?PHP echo $rel2_profession; ?>"></td>
							</tr>
					</table>
						<br><input type='submit' name='save' value='Kaydet' style='width:120px; height: 40px; font-size:14pt; color:green;'></form><br>

						<form method='GET' action='destroyRecord.php'><input type='hidden' name='delStudent' value='<?PHP echo $selectedStudent ;?>'><input type='submit' name='deleteStudent' value='Kaydı Sil' style='width:120px; height: 40px; font-size:14pt; color:red;'></form><br><br><br>
						</form>
				</td>
			</tr>
		</table>
		</form>
		
		<div class="copyright">&nbsp © INÇNET</div>
	</body>
</HTML>
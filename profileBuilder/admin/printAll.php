<?php
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
	
	//Query for RegisterID & Personal Info	
	$stmt0 = "SELECT * FROM incnet.profilesmaintemp ORDER BY registerId ASC";
	$query0 = mysql_query($stmt0);
	while ($row0 = mysql_fetch_array($query0))
	{
	//echo " NO PROBLEM";
		$registerID = $row0["registerId"];
		$student_name = $row0['name'];
		$student_lastname = $row0['lastname'];
		$student_DOB = $row0['DOB'];
		$student_tckn = $row0['tckn'];
		$class = $row0['class'];
		if ($class==14){
			$class='Hz';
		}
		$student_address = $row0['address'];
		$student_semt = $row0['semt'];
		$student_ilce = $row0['ilce'];
		$student_il = $row0['il'];
		$student_zipcode = $row0['zipcode'];
		$student_homePhone = $row0['homePhone'];
		$student_cellPhone = $row0['cellPhone'];
		$student_email = $row0['email'];
		$student_socialSecurity = $row0['socialSecurity'];
		$parentsUnity = $row0['parentsUnity'];
		$motherBio = $row0['motherBio'];
		$fatherBio = $row0['fatherBio'];
		$motherLive = $row0['motherLive'];
		$fatherLive = $row0['fatherLive'];
		$parent = $row0['parent'];
		
		//Mother Query
		$stmt = "SELECT * FROM incnet.profilesmotherinfotemp WHERE registerId = '$registerID'";
		$query = mysql_query($stmt);
		while ($row = mysql_fetch_array($query))
		{
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
		
		//Father Query
		$stmt = "SELECT * FROM incnet.profilesfatherinfotemp WHERE registerId = '$registerID'";
		$query = mysql_query($stmt);
		while ($row = mysql_fetch_array($query))
		{
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
		
		$stmt = "SELECT * FROM incnet.profilesrelativestemp WHERE registerId = '$registerID' ORDER BY relativeId ASC LIMIT 1";
		$query = mysql_query($stmt);
		while ($row = mysql_fetch_array($query))
		{
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
		
		$stmt = "SELECT * FROM incnet.profilesrelativestemp WHERE registerId = '$registerID' ORDER BY relativeId DESC LIMIT 1";
		$query = mysql_query($stmt);
		while ($row = mysql_fetch_array($query))
		{
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
		
		if ($infoHTML != "")
		{
			$infoHTML .= "
			<hr class='break'>";
		}
		$infoHTML .= "
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
							<td>$student_name</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Soyadı</td>
							<td>$student_lastname</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Doğum Tarihi</td>
							<td>$student_DOB</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>TC kimlik no</td>
							<td>$student_tckn</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Sınıf</td>
							<td>$class</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Adres</td>
							<td>$student_address</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Semt</td>
							<td>$student_semt</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>İlçe</td>
							<td>$student_ilce</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>İl</td>
							<td>$student_il</td>
						</tr>
					</table>
				</td>
				<td>
					<table width='325px' border=0>
						<tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Posta Kodu</td>
							<td>$student_zipcode</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Ev Telefonu</td>
							<td>$student_homePhone</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Cep Telefonu</td>
							<td>$student_cellPhone</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>email</td>
							<td>$student_email</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Bağlı bulunduğu SGK</td>
							<td>$student_socialSecurity</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Anne-Baba</td>
							<td>";
		
		if ($parentsUnity=='1')
		{
			$infoHTML .= "Beraber";
		}
		else if($parentsUnity=='0')
		{
			$infoHTML .= "Ayrı";
		}
		
		$infoHTML .= "</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Anne</td>
							<td>";
		if ($motherBio=='1')
		{
			$infoHTML .= "Öz";
		}
		else if ($motherBio=='0')
		{
			$infoHTML .= "Üvey";
		}
		
		$infoHTML .= "</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Baba</td>
							<td>";
		
		if ($fatherBio=='1')
		{
			$infoHTML .= "Öz";
		} 
		else if ($fatherBio=='0')
		{
			$infoHTML .= "Üvey";
		}
		
		$infoHTML .= "</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Anne</td>
							<td>";
		
		if ($motherLive=='1')
		{
			$infoHTML .= "Hayatta";
		} 
		else if ($motherLive=='0')
		{
			$infoHTML .= "Vefat";
		}
		
		$infoHTML .= "</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Baba</td>
							<td>";
		if ($fatherLive=='1')
		{
			$infoHTML .= "Hayatta";
		} 
		else if ($fatherLive=='0')
		{
			$infoHTML .= "Vefat";
		}
		
		$infoHTML .= "</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'> Kanuni Velisi</td>
							<td>$parentName</td>
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
							<td>$mother_name</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Soyadı</td>
							<td>$mother_lastname</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Doğum Tarihi</td>
							<td>$mother_DOB</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>TC Kimlik no</td>
							<td>$mother_tckn</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Adres</td>
							<td>$mother_address</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Semt</td>
							<td>$mother_semt</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>İlçe</td>
							<td>$mother_ilce </td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>İl</td>
							<td>$mother_il </td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Posta Kodu</td>
							<td>$mother_zipcode</td>
						</tr>
					</table>
				</td>
				<td>
					<table border=0>
						<tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Ev Telefonu</td>
							<td>$mother_homePhone</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Cep Telefonu</td>
							<td>$mother_cellPhone</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Fax</td>
							<td>$mother_fax</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>email</td>
							<td>$mother_email</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Bağlı bulunduğu SGK</td>
							<td>$mother_socialSecurity</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Mesleği</td>
							<td>$mother_profession</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Çalışma durumu</td>
							<td>$mother_work</td>
						</tr><tr>
							<td colspan=2>
								<div>
									<c style='color:#c1272d; font-weight:bold'>İşyeri Adı ve Ünvanı</c>
									$mother_company<br>
									<c style='color:#c1272d; font-weight:bold'>Adres</c>
									$mother_workAddress<br>
									<c style='color:#c1272d; font-weight:bold'>İl</c>
									$mother_workCity<br>
									<c style='color:#c1272d; font-weight:bold'>İş Telefonu</c>
									$mother_workPhone<br>
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
							<td>$father_name</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Soyadı</td>
							<td>$father_lastname</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Doğum Tarihi</td>
							<td>$father_DOB</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>TC Kimlik no</td>
							<td>$father_tckn</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Adres</td>
							<td>$father_address</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Semt</td>
							<td>$father_semt</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>İlçe</td>
							<td>$father_ilce </td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>İl</td>
							<td>$father_il </td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Posta Kodu</td>
							<td>$father_zipcode</td>
						</tr>
					</table>
				</td>
				<td>
					<table>
						<tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Ev Telefonu</td>
							<td>$father_homePhone</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Cep Telefonu</td>
							<td>$father_cellPhone</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Fax</td>
							<td>$father_fax</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>email</td>
							<td>$father_email</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Bağlı bulunduğu <br>SGK</td>
							<td>$father_socialSecurity</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Mesleği</td>
							<td>$father_profession</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Çalışma durumu</td>
							<td>$father_work</td>
						</tr><tr>
							<td colspan=2>
								<div>
									<c style='color:#c1272d; font-weight:bold'>İşyeri Adı ve Ünvanı</c>
									$father_company<br>
									<c style='color:#c1272d; font-weight:bold'>Adres</c>
									$father_workAddress<br>
									<c style='color:#c1272d; font-weight:bold'>İl</c>
									$father_workCity<br>
									<c style='color:#c1272d; font-weight:bold'>İş Telefonu</c>
									$father_workPhone<br>
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
							<td>$rel1_name</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Soyadı</td>
							<td>$rel1_lastname</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Yakınlık Derecesi</td>
							<td>$rel1_relation</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Adres</td>
							<td>$rel1_address</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Semt</td>
							<td>$rel1_semt</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>İlçe</td>
							<td>$rel1_ilce</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>İl</td>
							<td>$rel1_il</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Posta Kodu</td>
							<td>$rel1_zipcode</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Ev Telefonu</td>
							<td>$rel1_homePhone</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Cep Telefonu</td>
							<td>$rel1_cellPhone</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>İş Telefonu</td>
							<td>$rel1_workPhone</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Fax</td>
							<td>$rel1_fax</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>email</td>
							<td>$rel1_email</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Mesleği</td>
							<td>$rel1_profession</td>
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
							<td>$rel2_name</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Soyadı</td>
							<td>$rel2_lastname</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Yakınlık Derecesi</td>
							<td>$rel2_relation</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Adres</td>
							<td>$rel2_address</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Semt</td>
							<td>$rel2_semt</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>İlçe</td>
							<td>$rel2_ilce</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>İl</td>
							<td>$rel2_il</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Posta Kodu</td>
							<td>$rel2_zipcode</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Ev Telefonu</td>
							<td>$rel2_homePhone</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Cep Telefonu</td>
							<td>$rel2_cellPhone</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>İş Telefonu</td>
							<td>$rel2_workPhone</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Fax</td>
							<td>$rel2_fax</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>email</td>
							<td>$rel2_email</td>
						</tr><tr>
							<td style='width:100px; color:#c1272d; font-weight:bold'>Mesleği</td>
							<td>$rel2_profession</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>";
		$registerID = "";
		$student_name = "";
		$student_lastname = "";
		$student_DOB = "";
		$student_tckn = "";
		$class = "";
		$student_address = "";
		$student_semt = "";
		$student_ilce = "";
		$student_il = "";
		$student_zipcode = "";
		$student_homePhone = "";
		$student_cellPhone = "";
		$student_email = "";
		$student_socialSecurity = "";
		$parentsUnity = "";
		$motherBio = "";
		$fatherBio = "";
		$motherLive = "";
		$fatherLive = "";
		$parent = "";
		$mother_name = "";
		$mother_lastname = "";
		$mother_DOB = "";
		$mother_tckn = "";
		$mother_class = "";
		$mother_address = "";
		$mother_semt = "";
		$mother_ilce = "";
		$mother_il = "";
		$mother_zipcode = "";
		$mother_homePhone = "";
		$mother_cellPhone = "";
		$mother_fax = "";
		$mother_email = "";
		$mother_socialSecurity = "";
		$mother_work = "";
		$mother_profession = "";
		$mother_company = "";
		$mother_workAddress = "";
		$mother_workCity = "";
		$mother_workPhone = "";
		$father_name = "";
		$father_lastname = "";
		$father_DOB = "";
		$father_tckn = "";
		$father_class = "";
		$father_address = "";
		$father_semt = "";
		$father_ilce = "";
		$father_il = "";
		$father_zipcode = "";
		$father_homePhone = "";
		$father_cellPhone = "";
		$father_fax = "";
		$father_email = "";
		$father_socialSecurity = "";
		$father_work = "";
		$father_profession = "";
		$father_company = "";
		$father_workAddress = "";
		$father_workCity = "";
		$father_workPhone = "";
		$rel1_ID = "";
		$rel1_name = "";
		$rel1_lastname = "";
		$rel1_relation = "";
		$rel1_address = "";
		$rel1_semt = "";
		$rel1_ilce = "";
		$rel1_il = "";
		$rel1_zipcode = "";
		$rel1_homePhone = "";
		$rel1_cellPhone = "";
		$rel1_workPhone = "";
		$rel1_fax = "";
		$rel1_email = "";
		$rel1_profession = "";
		$rel2_ID = "";
		$rel2_name = "";
		$rel2_lastname = "";
		$rel2_relation = "";
		$rel2_address = "";
		$rel2_semt = "";
		$rel2_ilce = "";
		$rel2_il = "";
		$rel2_zipcode = "";
		$rel2_homePhone = "";
		$rel2_cellPhone = "";
		$rel2_workPhone = "";
		$rel2_fax = "";
		$rel2_email = "";
		$rel2_profession = "";
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
			<?php echo  $infoHTML; ?>
		</div>
	</body>
</html>

<?PHP
	error_reporting(0);
	
	session_start();
	$incnetUserId = $_SESSION['user_id'];
	//echo $incnetUserId;
	
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}

	if (isset($_POST['submit'])){
		$name = $_POST['name'];
		$name = explode(" ", $name);
		$firstname = ucfirst(strtolower($name[0]));
		$secondname = ucfirst(strtolower($name[1]));
		$thirdname = ucfirst(strtolower($name[2]));
		$name = $firstname . " " . $secondname . " " . $thirdname;
		$name = trim($name);
		
		$lastname = ucfirst(strtolower($_POST['lastname']));
		$DOB = $_POST['DOBYear'] . "-" . $_POST['DOBMonth'] . "-" . $_POST['DOBDay'];
		$tckn = $_POST['tckn'];
		
		if ((strlen($tckn))!=11){
			$tckn = "";
		}else{
			$tckn = str_split ($tckn);
			$digSum = 0;
			for ($i=0; $i<10; $i++){
				$digSum = $digSum + $tckn[$i];
			}
			if (($digSum % 10) == $tckn[10]){
				$tckn = $_POST['tckn'];
			} else {
				$tckn = "";
			}
			
		}
		
		$class = $_POST['class'];
		$address = $_POST['address'];
		$semt = ucfirst(strtolower($_POST['semt']));
		$ilce = ucfirst(strtolower($_POST['ilce']));
		$il = ucfirst(strtolower($_POST['il']));
		$zipcode = $_POST['zipcode'];
		$homePhone = "0" . $_POST['homePhoneArea'] . $_POST['homePhone'];
		$cellPhone = "0" . $_POST['cellProvider'] . $_POST['cellPhone'];
		$email = $_POST['email'];
		$socialSecurity = $_POST['socialSecurity'];
		$parentsUnity = $_POST['parentsUnity'];
		$motherBio = $_POST['motherBio'];
		$fatherBio = $_POST['fatherBio'];
		$motherLive = $_POST['motherLive'];
		$fatherLive = $_POST['fatherLive'];
		$parentName = ucfirst(strtolower($_POST['parentName'])) . " " . ucfirst(strtolower($_POST['parentLastName']));
		
		
		if (($name=='')||($lastname=='')||(strlen($_POST['DOBYear'])!=4)||($_POST['DOBDay']=='')||($tckn=='')||($class=='')||($address=='')||($semt=='')||($ilce=='')||($il=='')||((strlen($zipcode))!=5)||((strlen($homePhone))!=11)||((strlen($cellPhone))!=11)||($email=='')||($socialSecurity=='')||($parentsUnity=='')||($motherBio=='')||($fatherBio=='')||($motherLive=='')||($fatherLive=='')||(($parentsUnity=='0')&&(strlen($parentName)<3))){
			$error = "Lütfen eksik veya hatalı bilgi olmadığından emin olunuz.";
		}else{
			$registerNoQ = mysql_query("SELECT * FROM incnet.profilesMain WHERE tckn='$tckn'");
			while($regRow = mysql_fetch_array($registerNoQ)){
				$registerNo[] = $regRow['registerId'];
			}
			$regsCount = count($registerNo);
			if ($regsCount>0){
				echo "regsCount= " . $regsCount;
				$page = "alreadyRegistered.php";
			}else{
	
				$registerNoQ = mysql_query("SELECT * FROM incnet.profilesMainTemp WHERE tckn='$tckn'");
				while($regRow = mysql_fetch_array($registerNoQ)){
					$registerNo[] = $regRow['registerId'];
				}
				$regsCount = count($registerNo);
				
				if ($regsCount>0){
					for ($i=0; $i<$regsCount; $i++){
						$thisRegId = $registerNo[$i];
						mysql_query("DELETE from incnet.profilesMainTemp WHERE registerId='$thisRegId'");
						mysql_query("DELETE from incnet.profilesMotherTemp WHERE registerId='$thisRegId'");
						mysql_query("DELETE from incnet.profilesFatherTemp WHERE registerId='$thisRegId'");
						mysql_query("DELETE from incnet.profilesRelativeTemp WHERE registerId='$thisRegId'");
						mysql_query("DELETE from incnet.profilesSummerCampsTemp WHERE registerId='$thisRegId'");
						mysql_query("DELETE from incnet.profilesDevicesTemp WHERE registerId='$thisRegId'");
					}
				}
				
				$query = "INSERT into incnet.profilesMainTemp VALUES ('$incnetUserId', 'NULL', '$name', '$lastname', '$DOB', '$tckn', '$class', '$address', '$semt', '$ilce', '$il', '$zipcode', '$homePhone', '$cellPhone', '$email', '$socialSecurity', '$parentsUnity', '$motherBio', '$fatherBio', '$motherLive', '$fatherLive', '$parentName')";
				//echo $query . "<br>";
				mysql_query($query);
				
				$registerNoQ = mysql_query("SELECT * FROM incnet.profilesMainTemp WHERE tckn='$tckn'");
				while($regRow = mysql_fetch_array($registerNoQ)){
					$registerId = $regRow['registerId'];
				}
				//echo "Register id: " . $registerId;
				
				session_start();
				$_SESSION['regid'] = $registerId;
				
				//echo "Register id: " . $_SESSION['regid'];
				$page = "mother.php";
				
			}


		}	
	}
?>
<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="../incnet/favicon.ico" >
		<meta charset="utf-8">
		<body OnLoad="init();">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<?PHP
			if ($page!=''){
				echo " <meta http-equiv='refresh' content='0; url= $page '> ";
			}
		?>
		

		<script>
		
		function init(){
			<?PHP
				if ($parentsUnity=='0'){
					echo "showMe()";
				} else {
					echo "hideMe()";
				}
			?>
			;
			document.studentInfo.name.focus();
		}

		function isGoodKey(evt){
	    var charCode = (evt.which) ? evt.which : event.keyCode
			var charCode = evt.which || evt.keyCode;
			var charTyped = String.fromCharCode(charCode);
			var myChars = new Array("A","B","C","Ç","D","E","F","G","Ğ","H","I","İ","J","K","L","M","N","O","Ö","P","R","S","Ş","T","U","Ü","V","Y","Z","1","2","3","4","4","5","6","7","8","9","0",",",":",".","/","a","b","c","ç","d","e","f","g","ğ","h","ı","i","j","k","l","m","n","o","ö","p","r","s","ş","t","u","ü","v","y","z","Q","q","W","w","x","X"," ","@");
			
			if((myChars.indexOf(charTyped) != -1)||charCode==8){
				return true;
			}else{
				alert("Bu alana kullandığınız karakterlerle giriş yapılamaz!");
				return false;
			}
			
		}
		
			function showMe(){
				ele = document.getElementById("p1");
				ele.style.display="inline";
				ele = document.getElementById("p2");
				ele.style.display="inline";
			}

			function hideMe(){
				ele = document.getElementById("p1");
				ele.style.display="none";
				ele = document.getElementById("p2");
				ele.style.display="none";
			}

		</script>
	</head>
	

	<body>
		<div class='container'>
			<div class='titleDiv'>
				1. Öğrenci Bilgileri
				
			</div><hr>
			<form name="studentInfo" method='POST' autocomplete='off'>
			 <div style='color: #c1272d; font-size:12pt'><?PHP echo $error; ?></div>
				<table>
					<tr>
						<td>Adı</td>
						<td><input type='text' name='name' maxlength='25' value='<?PHP echo $name; ?>' onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Soyadı</td>
						<td><input type='text' name='lastname' maxlength='25' value='<?PHP echo $lastname; ?>' onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Doğum Tarihi</td>
						<td>
							<input type='text' name='DOBDay' size='1' maxlength='2' value="<?PHP echo $_POST['DOBDay']; ?>" onkeypress='return isGoodKey(event)'>
							<select name="DOBMonth">
								<option value="01" <?PHP if($_POST['DOBMonth']==1){ echo "selected='yes'"; } ?>>Ocak</option>
								<option value="02" <?PHP if($_POST['DOBMonth']==2){ echo "selected='yes'"; } ?>>Şubat</option>
								<option value="03" <?PHP if($_POST['DOBMonth']==3){ echo "selected='yes'"; } ?>>Mart</option>
								<option value="04" <?PHP if($_POST['DOBMonth']==4){ echo "selected='yes'"; } ?>>Nisan</option>												
								<option value="05" <?PHP if($_POST['DOBMonth']==5){ echo "selected='yes'"; } ?>>Mayıs</option>
								<option value="06" <?PHP if($_POST['DOBMonth']==6){ echo "selected='yes'"; } ?>>Haziran</option>
								<option value="07" <?PHP if($_POST['DOBMonth']==7){ echo "selected='yes'"; } ?>>Temmuz</option>												
								<option value="08" <?PHP if($_POST['DOBMonth']==8){ echo "selected='yes'"; } ?>>Ağustos</option>
								<option value="09" <?PHP if($_POST['DOBMonth']==9){ echo "selected='yes'"; } ?>>Eylül</option>
								<option value="10" <?PHP if($_POST['DOBMonth']==10){ echo "selected='yes'"; } ?>>Ekim</option>												
								<option value="11" <?PHP if($_POST['DOBMonth']==11){ echo "selected='yes'"; } ?>>Kasım</option>
								<option value="12"> <?PHP if($_POST['DOBMonth']==12){ echo "selected='yes'"; } ?>Aralık</option>
						</select>
						<input type='text' name='DOBYear' size='3' maxlength='4' value="<?PHP echo $_POST['DOBYear']; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>TC kimlik no</td>
						<td><input type='text' name='tckn' maxlength='11' value="<?PHP echo $tckn; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Devam edeceği sınıf</td>
						<td>
							<select name="class">
								<option value="">Seçiniz…</option>
								<option value="14" <?PHP if($_POST['class']=='14'){ echo "selected='yes'"; } ?>>Hazırlık</option>
								<option value="9" <?PHP if($_POST['class']=='9'){ echo "selected='yes'"; } ?>>9. Sınıf</option>
								<option value="10" <?PHP if($_POST['class']=='10'){ echo "selected='yes'"; } ?>>10. Sınıf</option>
								<option value="11" <?PHP if($_POST['class']=='11'){ echo "selected='yes'"; } ?>>11. Sınıf</option>												
								<option value="12" <?PHP if($_POST['class']=='12'){ echo "selected='yes'"; } ?>>12. Sınıf</option>
						</select>
					</tr><tr>
						<td>Adres</td>
						<td><input type='text' name='address' maxlength='200' value="<?PHP echo $address; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Semt</td>
						<td><input type='text' name='semt' maxlength='40' value="<?PHP echo $semt; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>İlçe</td>
						<td><input type='text' name='ilce' maxlength='40' value="<?PHP echo $ilce; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>İl</td>
						<td><input type='text' name='il' maxlength='40' value="<?PHP echo $il; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Posta Kodu</td>
						<td><input type='text' name='zipcode' maxlength='5' value="<?PHP echo $_POST['zipcode']; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Ev Telefonu</td>
						<td>0 (<input type='text' name='homePhoneArea' size='3' maxlength='3' value="<?PHP echo $_POST['homePhoneArea']; ?>" onkeypress='return isGoodKey(event)'>)<input type='text' name='homePhone' size='7' maxlength='7' value="<?PHP echo $_POST['homePhone']; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Cep Telefonu</td>
						<td>0 (<input type='text' name='cellProvider' size='3' maxlength='3'  value="<?PHP echo $_POST['cellProvider']; ?>" onkeypress='return isGoodKey(event)'>)<input type='text' name='cellPhone' size='7' maxlength='7' value="<?PHP echo $_POST['cellPhone']; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>email</td>
						<td><input type='email' name='email' maxlength='100' value="<?PHP echo $_POST['email']; ?>"></td>
					</tr><tr>
						<td>Bağlı bulunduğu <br>Sosyal güvenlik kurumu</td>
						<td><select name='socialSecurity'>
									<option value=''>Seçiniz...</option>
									<option value='SGK' <?PHP if($_POST['socialSecurity']=='SGK'){ echo "selected='yes'"; } ?>>SGK</option>
									<option value='Bagkur' <?PHP if($_POST['socialSecurity']=='Bagkur'){ echo "selected='yes'"; } ?>>Bağkur</option>
									<option value='Emekli Sandığı' <?PHP if($_POST['socialSecurity']=='Emekli Sandığı'){ echo "selected='yes'"; } ?>>Emekli Sandığı</option>
								</select>
						</td>
					</tr><tr>
						<td>Anne-Baba</td>
						<td>
							<input type="radio" name="parentsUnity" onclick="hideMe()" value="1" <?PHP if($_POST['parentsUnity']=='1'){ echo "checked='checked'"; } ?>>Beraber &nbsp
							<input type="radio" name="parentsUnity" onclick="showMe()" value="0" <?PHP if($_POST['parentsUnity']=='0'){ echo "checked='checked'"; } ?>>Ayrı
						</td>
					</tr><tr>
						<td>Anne</td>
						<td>
							<input type="radio" name="motherBio" value="1" <?PHP if($_POST['motherBio']=='1'){ echo "checked='checked'"; } ?>>Öz &nbsp
							<input type="radio" name="motherBio" value="0" <?PHP if($_POST['motherBio']=='0'){ echo "checked='checked'"; } ?>>Üvey
						</td>
					</tr><tr>
						<td>Baba</td>
						<td>
							<input type="radio" name="fatherBio" value="1" <?PHP if($_POST['fatherBio']=='1'){ echo "checked='checked'"; } ?>>Öz &nbsp
							<input type="radio" name="fatherBio" value="0" <?PHP if($_POST['fatherBio']=='0'){ echo "checked='checked'"; } ?>>Üvey
						</td>
					</tr><tr>
						<td>Anne</td>
						<td>
							<input type="radio" name="motherLive" value="1" <?PHP if($_POST['motherLive']=='1'){ echo "checked='checked'"; } ?>>Hayatta &nbsp
							<input type="radio" name="motherLive" value="0" <?PHP if($_POST['motherLive']=='0'){ echo "checked='checked'"; } ?>>Vefat
						</td>
					</tr><tr>
						<td>Baba</td>
						<td>
							<input type="radio" name="fatherLive" value="1" <?PHP if($_POST['fatherLive']=='1'){ echo "checked='checked'"; } ?>>Hayatta &nbsp
							<input type="radio" name="fatherLive" value="0" <?PHP if($_POST['fatherLive']=='0'){ echo "checked='checked'"; } ?>>Vefat
						</td>
					</tr><tr>
						<td style='padding-top:10px' valign='top' id='p2'>Kanuni Velisi:</td>
						<td>
							<table id="p1">
								<tr>
									<td><input type='text' name='parentName' maxlength='40' value="<?PHP echo ucfirst(strtolower($_POST['parentName'])); ?>" onkeypress='return isGoodKey(event)'></td>
									<td><input type='text' name='parentLastName' maxlength='40' value="<?PHP echo ucfirst(strtolower($_POST['parentLastName'])); ?>" onkeypress='return isGoodKey(event)'></td>
								</tr>
								<tr>
									<td valign='top' style='font-size:8pt; color:grey'>Adı</td>
									<td valign='top' style='font-size:8pt; color:grey'>Soyadı</td>
								</tr>
								<tr>
									<td colspan='2'>
										*Velayet belgesinin bir örneğinin okula teslimi gerekmektedir.
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			<br><input type='submit' name='submit' value='Devam' style='width:120px; height: 40px; font-size:18pt;'>
			<br>*Lütfen tüm alanları doldurunuz.
			</form><br><br>
		</div><div class="copyright">© INÇNET</div>
	</body>
</html>
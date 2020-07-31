<?PHP
	error_reporting(0);
	
	session_start();
	$incnetUserId = $_SESSION['user_id'];
	//echo $incnetUserId;
	$registerId = $_SESSION['registerid'];
	
	require ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}
	
	if ((isset($_POST['submit']))||(isset($_POST['later']))){
		$name = $_POST['name'];
		$name = explode(" ", $name);
		$firstname = ucfirst(strtolower($name[0]));
		$secondname = ucfirst(strtolower($name[1]));
		$thirdname = ucfirst(strtolower($name[2]));
		$name = $firstname . " " . $secondname . " " . $thirdname;
		$name = trim($name);
		
		$lastname = ucfirst(strtolower($_POST['lastname']));
		$DOB = $_POST['DOBYear'] . "-" . $_POST['DOBMonth'] . "-" . $_POST['DOBDay'];
		$DOBDay = $_POST['DOBDay'];
		$DOBMonth = $_POST['DOBMonth'];
		$DOBYear = $_POST['DOBYear'];
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
		$homePhoneArea = $_POST['homePhoneArea'];
		$homePhoneNo = $_POST['homePhone'];
		$cellPhone = "0" . $_POST['cellProvider'] . $_POST['cellPhone'];
		$cellProvider = $_POST['cellProvider'];
		$cellPhoneNo = $_POST['cellPhone'];
		$email = $_POST['email'];
		$socialSecurity = $_POST['socialSecurity'];
		$parentsUnity = $_POST['parentsUnity'];
		$motherBio = $_POST['motherBio'];
		$fatherBio = $_POST['fatherBio'];
		$motherLive = $_POST['motherLive'];
		$fatherLive = $_POST['fatherLive'];
		$parent = $_POST['parent'];
		
		
		if (($name=='')||($lastname=='')||(strlen($_POST['DOBYear'])!=4)||($_POST['DOBDay']=='')||($tckn=='')||($class=='')||($address=='')||($ilce=='')||($il=='')||((strlen($zipcode))!=5)||($socialSecurity=='')||($parentsUnity=='')||($motherBio=='')||($fatherBio=='')||($motherLive=='')||($fatherLive=='')||(($parentsUnity=='0')&&($parent=='none'))){
			$error = "Lütfen eksik veya hatalı bilgi olmadığından emin olunuz.";
		}else{
			$registerNoQ = mysql_query("SELECT * FROM incnet.profilesmain WHERE tckn='$tckn'");
			while($regRow = mysql_fetch_array($registerNoQ)){
				$registerNo[] = $regRow['registerId'];
			}
			$regsCount = count($registerNo);
			if (false){
			//if ($regsCount>0){
				//echo "regsCount= " . $regsCount;
				//$page = "alreadyRegistered.php";
			}else{
			
				if ((isset($registerId))&&($registerId != "")){
					$query = "UPDATE incnet.profilesmainTemp SET user_id = '$incnetUserId', name = '$name', lastname = '$lastname', DOB = '$DOB', tckn = '$tckn', class = '$class', address = '$address', semt = '$semt', ilce = '$ilce', il = '$il', zipcode = '$zipcode', homePhone = '$homePhone', cellPhone = '$cellPhone', email = '$email', socialSecurity = '$socialSecurity', parentsUnity = '$parentsUnity', motherBio = '$motherBio', fatherBio = '$fatherBio', motherLive = '$motherLive', fatherLive = '$fatherLive', parent = '$parent' WHERE registerId = $registerId";
					//echo $query . "<br>";
					mysql_query($query);
				}
				else {
					$registerNoQ = mysql_query("SELECT * FROM incnet.profilesmainTemp WHERE tckn='$tckn'");
					while($regRow = mysql_fetch_array($registerNoQ)){
						$registerNo[] = $regRow['registerId'];
					}
					$regsCount = count($registerNo);
				
					if ($regsCount>0){
						for ($i=0; $i<$regsCount; $i++){
							$thisRegId = $registerNo[$i];
							mysql_query("DELETE from incnet.profilesmainTemp WHERE registerId='$thisRegId'");
							mysql_query("DELETE from incnet.profilesmotherTemp WHERE registerId='$thisRegId'");
							mysql_query("DELETE from incnet.profilesfatherTemp WHERE registerId='$thisRegId'");
							mysql_query("DELETE from incnet.profilesrelativeTemp WHERE registerId='$thisRegId'");
							mysql_query("DELETE from incnet.profilessummerCampsTemp WHERE registerId='$thisRegId'");
							mysql_query("DELETE from incnet.profilesdevicesTemp WHERE registerId='$thisRegId'");
						}
					}
				
					$query = "INSERT into incnet.profilesmainTemp VALUES ('$incnetUserId', 'NULL', '$name', '$lastname', '$DOB', '$tckn', '$class', '$address', '$semt', '$ilce', '$il', '$zipcode', '$homePhone', '$cellPhone', '$email', '$socialSecurity', '$parentsUnity', '$motherBio', '$fatherBio', '$motherLive', '$fatherLive', '$parent')";
					//echo $query . "<br>";
					mysql_query($query);
				
					$registerNoQ = mysql_query("SELECT * FROM incnet.profilesmainTemp WHERE tckn='$tckn'");
					while($regRow = mysql_fetch_array($registerNoQ)){
						$registerId = $regRow['registerId'];
					}
					//echo "Register id: " . $registerId;
				
					session_start();
					$_SESSION['registerid'] = $registerId;
				
					//echo "Register id: " . $_SESSION['regid'];
				}
					
				if (isset($_POST['later']))
				{
					$page = "continueLater.php";
				}
				else
				{
					$page = "mother.php";
				}
			}
		}	
	}
	else if (isset($_SESSION['user_id']))
	{
		//Old Students
		$oldStudent_stmt = "SELECT * FROM incnet.profilesmain WHERE user_id = $incnetUserId";
		$oldStudent_query = mysql_query($oldStudent_stmt);
		while ($oldStudent_row = mysql_fetch_array($oldStudent_query))
		{
			$regID = $oldStudent_row['registerId'];
			$_SESSION['regid'] = $regID;
			$name = $oldStudent_row["name"];
			$lastname = $oldStudent_row["lastname"];
			$DOB = explode("-", $oldStudent_row["DOB"]);
			$DOBDay = $DOB[2];
			$DOBMonth = $DOB[1];
			$DOBYear = $DOB[0];
			$tckn = $oldStudent_row["tckn"];
			$class = $oldStudent_row["class"];
			$address = $oldStudent_row["address"];
			$semt = $oldStudent_row["semt"];
			$ilce = $oldStudent_row["ilce"];
			$il = $oldStudent_row["il"];
			$zipcode = $oldStudent_row["zipcode"];
			$homePhone = $oldStudent_row["homePhone"];
			$homePhoneArea = $homePhone[1] . $homePhone[2] . $homePhone[3];
			$homePhoneNo = $homePhone[4] .$homePhone[5] . $homePhone[6] . $homePhone[7] . $homePhone[8] . $homePhone[9] . $homePhone[10];
			$cellPhone = $oldStudent_row["cellPhone"];
			$cellProvider = $cellPhone[1] . $cellPhone[2] . $cellPhone[3];
			$cellPhoneNo = $cellPhone[4] . $cellPhone[5] . $cellPhone[6] . $cellPhone[7] . $cellPhone[8] . $cellPhone[9] . $cellPhone[10];
			$email = $oldStudent_row["email"];
			$socialSecurity = $oldStudent_row["socialSecurity"];
			$parentsUnity = $oldStudent_row["parentsUnity"];
			$motherBio = $oldStudent_row["motherBio"];
			$fatherBio = $oldStudent_row["fatherBio"];
			$motherLive = $oldStudent_row["motherLive"];
			$fatherLive = $oldStudent_row["fatherLive"];
			$parent = $oldStudent_row["parent"];
		}
	}
	else if (isset($_SESSION['registerid']))
	{
		//Continue
		$contStudent_stmt = "SELECT * FROM incnet.profilesmaintemp WHERE registerId = $registerId";
		$contStudent_query = mysql_query($contStudent_stmt);
		while ($contStudent_row = mysql_fetch_array($contStudent_query))
		{
			$name = $contStudent_row["name"];
			$lastname = $contStudent_row["lastname"];
			$DOB = explode("-", $contStudent_row["DOB"]);
			$DOBDay = $DOB[2];
			$DOBMonth = $DOB[1];
			$DOBYear = $DOB[0];
			$tckn = $contStudent_row["tckn"];
			$class = $contStudent_row["class"];
			$address = $contStudent_row["address"];
			$semt = $contStudent_row["semt"];
			$ilce = $contStudent_row["ilce"];
			$il = $contStudent_row["il"];
			$zipcode = $contStudent_row["zipcode"];
			$homePhone = $contStudent_row["homePhone"];
			$homePhoneArea = $homePhone[1] . $homePhone[2] . $homePhone[3];
			$homePhoneNo = $homePhone[4] .$homePhone[5] . $homePhone[6] . $homePhone[7] . $homePhone[8] . $homePhone[9] . $homePhone[10];
			$cellPhone = $contStudent_row["cellPhone"];
			$cellProvider = $cellPhone[1] . $cellPhone[2] . $cellPhone[3];
			$cellPhoneNo = $cellPhone[4] . $cellPhone[5] . $cellPhone[6] . $cellPhone[7] . $cellPhone[8] . $cellPhone[9] . $cellPhone[10];
			$email = $contStudent_row["email"];
			$socialSecurity = $contStudent_row["socialSecurity"];
			$parentsUnity = $contStudent_row["parentsUnity"];
			$motherBio = $contStudent_row["motherBio"];
			$fatherBio = $contStudent_row["fatherBio"];
			$motherLive = $contStudent_row["motherLive"];
			$fatherLive = $contStudent_row["fatherLive"];
			$parent = $contStudent_row["parent"];
		}
	}
?>
<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="../incnet/favicon.ico" >
		<meta charset="utf-8">
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
		<link rel="stylesheet" href="chosen.css">
	</head>
	

	<body OnLoad="init();">
		<div class='container'>
			<div class='titleDiv'>
				1. Öğrenci Bilgileri
				
			</div><hr>
			<form name="studentInfo" method='POST' autocomplete='off'>
			 <div style='color: #c1272d; font-size:12pt'><?PHP echo $error; ?></div>
				<table>
					<tr>
						<td colspan='2'>
							<span id='error-msg'></span>
						</td>
					</tr>
					<tr>
						<td>Adı</td>
						<td><input type='text' name='name' data-validation='length' data-validation-length='1-25' value='<?PHP echo $name; ?>' onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Soyadı</td>
						<td><input type='text' name='lastname' data-validation='length' data-validation-length='1-25' value='<?PHP echo $lastname; ?>' onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Doğum Tarihi</td>
						<td>
							<input type='text' class='no-bgimg' name='DOBDay' data-validation='number length' data-validation-length='1-2' size='1' maxlength='2' value="<?PHP echo $DOBDay; ?>" onkeypress='return isGoodKey(event)'>
							<select name="DOBMonth" id='month-chosen'>
								<option value="01" <?PHP if($DOBMonth==1){ echo "selected='yes'"; } ?>>Ocak</option>
								<option value="02" <?PHP if($DOBMonth==2){ echo "selected='yes'"; } ?>>Şubat</option>
								<option value="03" <?PHP if($DOBMonth==3){ echo "selected='yes'"; } ?>>Mart</option>
								<option value="04" <?PHP if($DOBMonth==4){ echo "selected='yes'"; } ?>>Nisan</option>												
								<option value="05" <?PHP if($DOBMonth==5){ echo "selected='yes'"; } ?>>Mayıs</option>
								<option value="06" <?PHP if($DOBMonth==6){ echo "selected='yes'"; } ?>>Haziran</option>
								<option value="07" <?PHP if($DOBMonth==7){ echo "selected='yes'"; } ?>>Temmuz</option>												
								<option value="08" <?PHP if($DOBMonth==8){ echo "selected='yes'"; } ?>>Ağustos</option>
								<option value="09" <?PHP if($DOBMonth==9){ echo "selected='yes'"; } ?>>Eylül</option>
								<option value="10" <?PHP if($DOBMonth==10){ echo "selected='yes'"; } ?>>Ekim</option>												
								<option value="11" <?PHP if($DOBMonth==11){ echo "selected='yes'"; } ?>>Kasım</option>
								<option value="12" <?PHP if($DOBMonth==12){ echo "selected='yes'"; } ?>>Aralık</option>
						</select>
						<input type='text' name='DOBYear' class='no-bgimg' size='3' data-validation='number length' data-validation-length='min4' data-validation-allowing='range[1990;2010]' maxlength='4' value="<?PHP echo $DOBYear; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>TC kimlik no</td>
						<td><input type='text' name='tckn' data-validation='tckn' maxlength='11' value="<?PHP echo $tckn; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Devam edeceği sınıf</td>
						<td>
							<select name="class" class='make-chosen' data-placeholder='Seçiniz…'>
								<option value=""></option>
								<option value="14" <?PHP if($class=='14'){ echo "selected='yes'"; } ?>>Hazırlık</option>
								<option value="9" <?PHP if($class=='9'){ echo "selected='yes'"; } ?>>9. Sınıf</option>
								<option value="10" <?PHP if($class=='10'){ echo "selected='yes'"; } ?>>10. Sınıf</option>
								<option value="11" <?PHP if($class=='11'){ echo "selected='yes'"; } ?>>11. Sınıf</option>												
								<option value="12" <?PHP if($class=='12'){ echo "selected='yes'"; } ?>>12. Sınıf</option>
						</select>
					</tr><tr>
						<td>Adres</td>
						<td><input type='text' name='address' data-validation='length' data-validation-length='10-200' maxlength='200' value="<?PHP echo $address; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Semt</td>
						<td><input type='text' name='semt' data-validation-optional='true' data-validation='length' data-validation-length='2-40' maxlength='40' value="<?PHP echo $semt; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>İl</td>
						<td>
							<select name='il' id='il' class='make-chosen' data-placeholder="İl seçiniz...">
								<option value=''></option>
								<option value="Adana">Adana</option>
								<option value="Adıyaman">Adıyaman</option>
								<option value="Afyonkarahisar">Afyonkarahisar</option>
								<option value="Ağrı">Ağrı</option>
								<option value="Aksaray">Aksaray</option>
								<option value="Amasya">Amasya</option>
								<option value="Ankara">Ankara</option>
								<option value="Antalya">Antalya</option>
								<option value="Ardahan">Ardahan</option>
								<option value="Artvin">Artvin</option>
								<option value="Aydın">Aydın</option>
								<option value="Balıkesir">Balıkesir</option>
								<option value="Bartın">Bartın</option>
								<option value="Batman">Batman</option>
								<option value="Bayburt">Bayburt</option>
								<option value="Bilecik">Bilecik</option>
								<option value="Bingöl">Bingöl</option>
								<option value="Bitlis">Bitlis</option>
								<option value="Bolu">Bolu</option>
								<option value="Burdur">Burdur</option>
								<option value="Bursa">Bursa</option>
								<option value="Çanakkale">Çanakkale</option>
								<option value="Çankırı">Çankırı</option>
								<option value="Çorum">Çorum</option>
								<option value="Denizli">Denizli</option>
								<option value="Diyarbakır">Diyarbakır</option>
								<option value="Düzce">Düzce</option>
								<option value="Edirne">Edirne</option>
								<option value="Elazığ">Elazığ</option>
								<option value="Erzincan">Erzincan</option>
								<option value="Erzurum">Erzurum</option>
								<option value="Eskişehir">Eskişehir</option>
								<option value="Gaziantep">Gaziantep</option>
								<option value="Giresun">Giresun</option>
								<option value="Gümüşhane">Gümüşhane</option>
								<option value="Hakkari">Hakkari</option>
								<option value="Hatay">Hatay</option>
								<option value="Iğdır">Iğdır</option>
								<option value="Isparta">Isparta</option>
								<option value="İstanbul">İstanbul</option>
								<option value="İzmir">İzmir</option>
								<option value="Kahramanmaraş">Kahramanmaraş</option>
								<option value="Karabük">Karabük</option>
								<option value="Karaman">Karaman</option>
								<option value="Kars">Kars</option>
								<option value="Kastamonu">Kastamonu</option>
								<option value="Kayseri">Kayseri</option>
								<option value="Kilis">Kilis</option>
								<option value="Kırıkkale">Kırıkkale</option>
								<option value="Kırklareli">Kırklareli</option>
								<option value="Kırşehir">Kırşehir</option>
								<option value="Kocaeli">Kocaeli</option>
								<option value="Konya">Konya</option>
								<option value="Kütahya">Kütahya</option>
								<option value="Malatya">Malatya</option>
								<option value="Manisa">Manisa</option>
								<option value="Mardin">Mardin</option>
								<option value="Mersin">Mersin</option>
								<option value="Muğla">Muğla</option>
								<option value="Muş">Muş</option>
								<option value="Nevşehir">Nevşehir</option>
								<option value="Niğde">Niğde</option>
								<option value="Ordu">Ordu</option>
								<option value="Osmaniye">Osmaniye</option>
								<option value="Rize">Rize</option>
								<option value="Sakarya">Sakarya</option>
								<option value="Samsun">Samsun</option>
								<option value="Siirt">Siirt</option>
								<option value="Sinop">Sinop</option>	
								<option value="Sivas">Sivas</option>
								<option value="Şanlıurfa">Şanlıurfa</option>
								<option value="Şırnak">Şırnak</option>
								<option value="Tekirdağ">Tekirdağ</option>
								<option value="Tokat">Tokat</option>
								<option value="Trabzon">Trabzon</option>
								<option value="Tunceli">Tunceli</option>
								<option value="Uşak">Uşak</option>
								<option value="Van">Van</option>
								<option value="Yalova">Yalova</option>
								<option value="Yozgat">Yozgat</option>
								<option value="Zonguldak">Zonguldak</option>
							</select>
						</td>
					</tr><tr>
						<td>İlçe</td>
						<td>
							<select name='ilce' id='ilce' class='make-chosen' data-placeholder="İlçe seçiniz...">
								<option value=''></option>
							</select>
						</td>
					</tr><tr>
						<td>Posta Kodu</td>
						<td><input type='text' name='zipcode' data-validation='length' data-validation-length='min5' maxlength='5' value="<?PHP echo $zipcode; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Ev Telefonu</td>
						<td>0 ( <input type='text' name='homePhoneArea' data-validation-optional='true' data-validation='number length' data-validation-length='min3' size='4' maxlength='3' value="<?PHP echo $homePhoneArea; ?>" onkeypress='return isGoodKey(event)'> ) &nbsp;<input type='text' name='homePhone' data-validation-optional='true' data-validation='number length' data-validation-length='min7' size='8' maxlength='7' value="<?PHP echo $homePhoneNo; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Cep Telefonu</td>
						<td>0 ( <input type='text' name='cellProvider' data-validation-optional='true' data-validation='number length' data-validation-allowing='range[500;599]' data-validation-length='min3' size='4' maxlength='3' value="<?PHP echo $cellProvider; ?>" onkeypress='return isGoodKey(event)'> ) &nbsp;<input type='text' name='cellPhone' data-validation-optional='true' data-validation='number length' data-validation-length='min7' size='8' maxlength='7' value="<?PHP echo $cellPhoneNo; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>email</td>
						<td><input type='email' name='email' maxlength='100' data-validation-optional='true' data-validation='email' value="<?PHP echo $email; ?>"></td>
					</tr><tr>
						<td>Bağlı bulunduğu <br>Sosyal güvenlik kurumu</td>
						<td><select name='socialSecurity' class='make-chosen' data-placeholder='Seçiniz…'>
									<option value=''></option>
									<option value='SGK' <?PHP if($socialSecurity=='SGK'){ echo "selected='yes'"; } ?>>SGK</option>
									<option value='Bagkur' <?PHP if($socialSecurity=='Bagkur'){ echo "selected='yes'"; } ?>>Bağkur</option>
									<option value='Emekli Sandığı' <?PHP if($socialSecurity=='Emekli Sandığı'){ echo "selected='yes'"; } ?>>Emekli Sandığı</option>
								</select>
						</td>
					</tr><tr>
						<td>Anne-Baba</td>
						<td>
							<input type="radio" name="parentsUnity" onclick="hideMe()" value="1" <?PHP if($parentsUnity=='1'){ echo "checked='checked'"; } ?>>Beraber &nbsp;
							<input type="radio" name="parentsUnity" onclick="showMe()" value="0" <?PHP if($parentsUnity=='0'){ echo "checked='checked'"; } ?>>Ayrı
						</td>
					</tr><tr>
						<td>Anne</td>
						<td>
							<input type="radio" name="motherBio" value="1" <?PHP if($motherBio=='1'){ echo "checked='checked'"; } ?>>Öz &nbsp;
							<input type="radio" name="motherBio" value="0" <?PHP if($motherBio=='0'){ echo "checked='checked'"; } ?>>Üvey
						</td>
					</tr><tr>
						<td>Baba</td>
						<td>
							<input type="radio" name="fatherBio" value="1" <?PHP if($fatherBio=='1'){ echo "checked='checked'"; } ?>>Öz &nbsp;
							<input type="radio" name="fatherBio" value="0" <?PHP if($fatherBio=='0'){ echo "checked='checked'"; } ?>>Üvey
						</td>
					</tr><tr>
						<td>Anne</td>
						<td>
							<input type="radio" name="motherLive" value="1" <?PHP if($motherLive=='1'){ echo "checked='checked'"; } ?>>Hayatta &nbsp;
							<input type="radio" name="motherLive" value="0" <?PHP if($motherLive=='0'){ echo "checked='checked'"; } ?>>Vefat
						</td>
					</tr><tr>
						<td>Baba</td>
						<td>
							<input type="radio" name="fatherLive" value="1" <?PHP if($fatherLive=='1'){ echo "checked='checked'"; } ?>>Hayatta &nbsp
							<input type="radio" name="fatherLive" value="0" <?PHP if($fatherLive=='0'){ echo "checked='checked'"; } ?>>Vefat
						</td>
					</tr><tr>
						<td style='padding-top:10px' valign='top' id='p2'>Kanuni Velisi:</td>
						<td>
							<table id="p1">
<!--
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
-->

							<tr>
								<td>
									<select name='parent' id='parent' class='make-chosen' data-placeholder="Seçiniz...">
										<option value='none'></option>
										<option value='Anne'>Anne</option>
										<option value='Baba'>Baba</option>
									</select>
								</td>
							</tr>									
							<tr>
								<td colspan='2'>
									<span class='tip'>*Velayet belgesinin bir örneğinin<br>okula teslimi gerekmektedir.</span>
								</td>
							</tr>
							</table>
						</td>
					</tr>
				</table>
			<br>
			<input type='submit' name='submit' value='Devam' style='width:120px; height: 40px; font-size:18pt;'>
			<input type='submit' name='later' value='Kaydet ve Sonra Devam Et' style='width:175px; height: 40px; font-size:10pt;'>
			<br>
			</form><br><br>
		</div><div class="copyright">© INÇNET</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
		<script src="../profileBuilder/form-validator/jquery.form-validator.js"></script>
  	<!--<script src="jquery-1.10.2.min.js" type="text/javascript"></script>-->
  	<script src="chosen.jquery.js" type="text/javascript"></script>
		<script>	
			$(document).ready(function(){
				errorSpan = $("#error-msg");
				$.validate({errorMessagePosition : errorSpan});
				$('.make-chosen').chosen({width:"100%", no_results_text:"Sanırım yanlış yazdınız", allow_single_deselect:true, disable_search_threshold:12});
				$('#month-chosen').chosen({width:"56%", no_results_text:"Sanırım yanlış yazdınız", allow_single_deselect:true, disable_search_threshold:12});
				selectedCount=0;
				$('#il').change(function(){
					il = $(this).val();			
					$.ajax({
						type			:	"POST",
						url				:	"ilce.php",
						data			:	"province="+il,
						dataType	:	"html"
					}).done(function(options){
						$('#ilce').empty().append(options);
						if (selectedCount != 1)
						{
							$("#ilce option[value='<?php echo $ilce; ?>']").prop("selected", true);
							selectedCount = 1;
						}
						$('#ilce').trigger("chosen:updated");
					});
				});
				$("#il option[value='<?php echo $il; ?>']").prop("selected", true);
				if ($('#il').val() != "")
				{
					$('#il').change();
					$('#il').trigger("chosen:updated");
				}
				$("#parent option[value='<?php echo $parent; ?>']").prop("selected", true);
				$("#parent").trigger("chosen:updated");
			});
		</script>
	</body>
</html>

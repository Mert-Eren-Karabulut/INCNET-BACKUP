<?PHP
	error_reporting(0);
	
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}
	
	session_start();
	
	if (isset($_SESSION['regid'])){
		$registerId = $_SESSION['regid'];;
	}else{
		echo "No session";
		$page = "index.php";
	}
	
	$registerQ = "SELECT * FROM incnet.profilesMainTemp WHERE registerId='$registerId'";
	//echo $registerQ;
	$registerQ = mysql_query($registerQ);
	while($regRow = mysql_fetch_array($registerQ)){
		$lastname = $regRow['lastname'];
		$address = $regRow['address'];
		$semt = $regRow['semt'];
		$ilce = $regRow['ilce'];
		$il = $regRow['il'];
		$zipcode = $regRow['zipcode'];
		$lastname = $regRow['lastname'];
		$homePhone = $regRow['homePhone'];
		$homePhone = str_split($homePhone);
		$homePhoneStart = $homePhone[1] . $homePhone[2] . $homePhone[3];
		$homePhoneEnd = $homePhone[4] . $homePhone[5] . $homePhone[6] . $homePhone[7] . $homePhone[8] . $homePhone[9] . $homePhone[10];
		
	}
	
	
//	echo "regId" . $registerId;

	
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

		$address = $_POST['address'];
		$semt = ucfirst(strtolower($_POST['semt']));
		$ilce = ucfirst(strtolower($_POST['ilce']));
		$il = ucfirst(strtolower($_POST['il']));
		$zipcode = $_POST['zipcode'];
		$homePhone = "0" . $_POST['homePhoneArea'] . $_POST['homePhone'];
		$cellPhone = "0" . $_POST['cellProvider'] . $_POST['cellPhone'];
		$fax = "0" . $_POST['faxArea'] . $_POST['fax'];
		$email = $_POST['email'];
		$socialSecurity = $_POST['socialSecurity'];
		$profession = $_POST['profession'];
		$work = $_POST['work'];
		$company = $_POST['company'];
		$workAddress = $_POST['workAddress'];
		$workCity = $_POST['workCity'];
		$workPhone = "0" . $_POST['workPhoneArea'] . $_POST['workPhone'];
		
		if (($name=='')||($lastname=='')||(strlen($_POST['DOBYear'])!=4)||($_POST['DOBDay']=='')||($tckn=='')||($address=='')||($semt=='')||($ilce=='')||($il=='')||((strlen($zipcode))!=5)||((strlen($homePhone))!=11)||((strlen($cellPhone))!=11)||($email=='')||($socialSecurity=='')||($profession=='')||($work=='')){
			$error = "Lütfen eksik veya hatalı bilgi olmadığından emin olunuz.";
		}else{
			$error = "";
			$query = "INSERT into incnet.profilesMotherinfoTemp VALUES ('NULL', '$registerId', '$name', '$lastname', '$DOB', '$tckn','$address', '$semt', '$ilce', '$il', '$zipcode', '$homePhone', '$cellPhone', '$fax', '$email', '$socialSecurity', '$profession', '$work', '$company', '$workAddress', '$workCity', '$workPhone')";
			mysql_query($query);
			//echo $query . "<br>";
			$page = "father.php";
		}
		
	}
?>
<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="../incnet/favicon.ico" >
		<meta charset="utf-8">
		<body OnLoad="document.motherInfo.name.focus();">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<?PHP
			if ($page!=''){
				echo " <meta http-equiv='refresh' content='0; url= $page '> ";
			}
		?>

		<script>
			function showMe(){
				ele = document.getElementById("p1");
				ele.style.display="inline";
				document.motherInfo.company.focus();
			}

			function hideMe(){
				ele = document.getElementById("p1");
				ele.style.display="none";
			}
			
			function showHide(){
				ele = document.getElementById('work');
				if ((ele.value == "çalışmıyor")||(ele.value == "emekli")||(ele.value == "ev hanımı")||(ele.value == "")){
			    hideMe();
				} else {
					showMe();
				}
			}
			
			<?
				if ((isset($_POST['submit']))&&((($_POST['work'])!='çalışmıyor')||(($_POST['work'])!='emekli')||(($_POST['work'])!='ev hanımı')||(($_POST['work'])!=''))){
					echo "window.onload =showMe;";
				}
			?>

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

		</script>
		
	</head>
	

	<body>
		<div class='container'>
			<div class='titleDiv'>
				2. Anne Bilgileri
			</div><hr>
			<form name="motherInfo" method='POST' autocomplete='off'>
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
						<td>TC Kimlik no</td>
						<td><input type='text' name='tckn' maxlength='11' value='<?PHP echo $tckn; ?>' onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Adres</td>
						<td><input type='text' name='address' maxlength='200' value='<?PHP echo $address; ?>' onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Semt</td>
						<td><input type='text' name='semt' maxlength='40'  value='<?PHP echo $semt; ?>' onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>İlçe</td>
						<td><input type='text' name='ilce' maxlength='40' value='<?PHP echo $ilce; ?>' onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>İl</td>
						<td><input type='text' name='il' maxlength='40' value='<?PHP echo $il; ?>' onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Posta Kodu</td>
						<td><input type='text' name='zipcode' maxlength='5' value="<?PHP echo $zipcode; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Ev Telefonu</td>
						<td>0 (<input type='text' name='homePhoneArea' size='3' maxlength='3' value="<?PHP if(isset($_POST['submit'])){ echo $_POST['homePhoneArea']; } else { echo $homePhoneStart; } ?>" onkeypress='return isGoodKey(event)'>)<input type='text' name='homePhone' size='7' maxlength='7' value="<?PHP if(isset($_POST['submit'])){ echo $_POST['homePhone']; } else { echo $homePhoneEnd; } ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Cep Telefonu</td>
						<td>0 (<input type='text' name='cellProvider' size='3' maxlength='3' value="<?PHP echo $_POST['cellProvider']; ?>" onkeypress='return isGoodKey(event)'>)<input type='text' name='cellPhone' size='7' maxlength='7' value="<?PHP echo $_POST['cellPhone']; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Fax</td>
						<td>0 (<input type='text' name='faxArea' size='3' maxlength='3' value="<?PHP echo $_POST['faxArea']; ?>" onkeypress='return isGoodKey(event)'>)<input type='text' name='fax' size='7' maxlength='7' value="<?PHP echo $_POST['fax']; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>email</td>
						<td><input type='email' name='email' maxlength='100' value="<?PHP echo $_POST['email']; ?>" onkeypress='return isGoodKey(event)'></td>
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
						<td>Mesleği</td>
						<td><input type='text' name='profession' maxlength='100' value="<?PHP echo $_POST['profession']; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Çalışma durumu</td>
						<td><select name='work' id="work" onChange="showHide()">
									<option value=''>Seçiniz...</option>
									<option value='ücretli' <?PHP if($_POST['work']=='ücretli'){ echo "selected='yes'"; }?>>Ücretli</option>
									<option value='bağımsız' <?PHP if($_POST['work']=='bağımsız'){ echo "selected='yes'"; }?>>Bağımsız</option>
									<option value='kamu' <?PHP if($_POST['work']=='kamu'){ echo "selected='yes'"; }?>>Kamu</option>
									<option value='isteğe bağlı' <?PHP if($_POST['work']=='isteğe bağlı'){ echo "selected='yes'"; }?>>İsteğe Bağlı</option>
									<option value='tarım' <?PHP if($_POST['work']=='tarım'){ echo "selected='yes'"; }?>>Tarım</option>
									<option value='emekli' <?PHP if($_POST['work']=='emekli'){ echo "selected='yes'"; }?>>Emekli</option>
									<option value='ev hanımı' <?PHP if($_POST['work']=='ev hanımı'){ echo "selected='yes'"; }?>>Ev Hanımı</option>
									<option value='öğrenci' <?PHP if($_POST['work']=='öğrenci'){ echo "selected='yes'"; }?>>Öğrenci</option>
									<option value='çalışmıyor' <?PHP if($_POST['work']=='çalışmıyor'){ echo "selected='yes'"; }?>>Çalışmıyor</option>
								</select>
						</td>
					</tr><tr>
						<td colspan=2>
							<div id="p1" style='display:none'>
								İşyeri Adı ve Ünvanı<br>
								<input type='text' name='company' maxlength='200' value="<?PHP echo $_POST['company']; ?>" onkeypress='return isGoodKey(event)'><br>
								Adres<br>
								<input type='text' name='workAddress' maxlength='40' value="<?PHP echo $_POST['workAddress']; ?>" onkeypress='return isGoodKey(event)'><br>
								İl<br>
								<input type='text' name='workCity' maxlength='40' value="<?PHP echo $_POST['workCity']; ?>" onkeypress='return isGoodKey(event)'><br>
								İş Telefonu<br>
								0 (<input type='text' name='workPhoneArea' size='3' maxlength='3' value="<?PHP echo $_POST['workPhoneArea']; ?>" onkeypress='return isGoodKey(event)'>)<input type='text' name='workPhone' size='7' maxlength='7' value="<?PHP echo $_POST['workPhone']; ?>" onkeypress='return isGoodKey(event)'><br>
								</tr>
							</div>

						</td>
					</tr>
				</table><br>
				<input type='submit' name='submit' value='Devam' style='width:120px; height: 40px; font-size:18pt;'>
			<br>*Lütfen tüm alanları doldurunuz.<br><br>
			</form><br><br>
		</div><div class="copyright">© INÇNET</div>
	</body>
</html>
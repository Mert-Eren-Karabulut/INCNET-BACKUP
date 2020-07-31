<?PHP
	error_reporting(0);
	
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}
	
	session_start();
	
	if (isset($_SESSION['registerid'])){
		$registerId = $_SESSION['registerid'];;
	}else{
		echo "No session";
		$page = "index.php";
	}
	$user_id = $_SESSION['user_id'];
	/*
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
	*/
	
//	echo "regId" . $registerId;

	if (isset($_SESSION['regid']))
	{
		//echo "no result!";
		//Old Students
		$regID = $_SESSION['regid'];
		//echo $regID;
		$oldStudent_stmt = "SELECT * FROM incnet.profilesmotherinfo WHERE registerId = $regID";
		$oldStudent_query = mysql_query($oldStudent_stmt);
		while ($oldStudent_row = mysql_fetch_array($oldStudent_query))
		{
			//echo "old!";
			$name = $oldStudent_row["name"];
			$lastname = $oldStudent_row["lastname"];
			$tckn = $oldStudent_row["tckn"];
			$DOB = explode("-", $oldStudent_row["DOB"]);
			$DOBDay = $DOB[2];
			$DOBMonth = $DOB[1];
			$DOBYear = $DOB[0];
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
			$fax = $oldStudent_row["fax"];
			$faxArea = $fax[1] . $fax[2] . $fax[3];
			$faxNo = $fax[4] . $fax[5] . $fax[6] . $fax[7] . $fax[8] . $fax[9] . $fax[10];
			$email = $oldStudent_row["email"];
			$socialSecurity = $oldStudent_row["socialSecurity"];
			$profession = $oldStudent_row["profession"];
			$work = $oldStudent_row["work"];
			$company = $oldStudent_row["company"];
			$workAddress = $oldStudent_row["workAddress"];
			$workCity = $oldStudent_row["workCity"];
			$workPhone = $oldStudent_row["workPhone"];
			$workPhoneArea = $workPhone[1] . $workPhone[2] . $workPhone[3];
			$workPhoneNo = $workPhone[4] . $workPhone[5] . $workPhone[6] . $workPhone[7] . $workPhone[8] . $workPhone[9] . $workPhone[10];
		}
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
		$homePhoneArea = $_POST['homePhoneArea'];
		$homePhoneNo = $_POST['homePhone'];
		$cellPhone = "0" . $_POST['cellProvider'] . $_POST['cellPhone'];
		$cellProvider = $_POST['cellProvider'];
		$cellPhoneNo = $_POST['cellPhone'];
		$fax = "0" . $_POST['faxArea'] . $_POST['fax'];
		$faxArea = $_POST['faxArea'];
		$faxNo = $_POST['fax'];
		$email = $_POST['email'];
		$socialSecurity = $_POST['socialSecurity'];
		$profession = $_POST['profession'];
		$work = $_POST['work'];
		$company = $_POST['company'];
		$workAddress = $_POST['workAddress'];
		$workCity = $_POST['workCity'];
		$workPhone = "0" . $_POST['workPhoneArea'] . $_POST['workPhone'];
		$workPhoneArea = $_POST['workPhoneArea'];
		$workPhoneNo = $_POST['workPhone'];
		
		if (($name=='')||($lastname=='')||(strlen($_POST['DOBYear'])!=4)||($_POST['DOBDay']=='')||($tckn=='')||($address=='')||($ilce=='')||($il=='')||((strlen($zipcode))!=5)||($profession=='')||($work=='')){
			$error = "Lütfen eksik veya hatalı bilgi olmadığından emin olunuz.";
		}else{
			$error = "";
			
			$registered = false;
			$regedStmt = "SELECT motherId FROM incnet.profilesmotherinfotemp WHERE registerId = $registerId";
			$regedQuery = mysql_query($regedStmt);
			while ($regedRow = mysql_fetch_array($regedQuery)){
				$registered = true;
			}
			if ($registered)
			{
				$query = "UPDATE incnet.profilesmotherinfotemp SET name = '$name', lastname ='$lastname', DOB = '$DOB', tckn = '$tckn', address = '$address', semt = '$semt', ilce = '$ilce', il = '$il', zipcode = '$zipcode', homePhone = '$homePhone', cellPhone = '$cellPhone', fax ='$fax', email = '$email', socialSecuity = '$socialSecurity', profession = '$profession', work = '$work', company = '$company', workAddress = '$workAddress', workCity = '$workCity', workPhone = '$workPhone'";
			}
			else
			{
				$query = "INSERT into incnet.profilesmotherinfotemp VALUES ('NULL', '$registerId', '$name', '$lastname', '$DOB', '$tckn','$address', '$semt', '$ilce', '$il', '$zipcode', '$homePhone', '$cellPhone', '$fax', '$email', '$socialSecurity', '$profession', '$work', '$company', '$workAddress', '$workCity', '$workPhone')";
			}
			mysql_query($query);
			//echo $query . "<br>";
			if (isset($_POST['later']))
			{
				$page = "continueLater.php";
			}
			else
			{
				$page = "father.php";
			}
		}
	}
	else 
	{
		//Continue
		$contStudent_stmt = "SELECT * FROM incnet.profilesmotherinfotemp WHERE registerId = $registerId";
		$contStudent_query = mysql_query($contStudent_stmt);
		while ($contStudent_row = mysql_fetch_array($contStudent_query))
		{
			$name = $contStudent_row["name"];
			$lastname = $contStudent_row["lastname"];
			$tckn = $contStudent_row["tckn"];
			$DOB = explode("-", $contStudent_row["DOB"]);
			$DOBDay = $DOB[2];
			$DOBMonth = $DOB[1];
			$DOBYear = $DOB[0];
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
			$fax = $contStudent_row["fax"];
			$faxArea = $fax[1] . $fax[2] . $fax[3];
			$faxNo = $fax[4] . $fax[5] . $fax[6] . $fax[7] . $fax[8] . $fax[9] . $fax[10];
			$email = $contStudent_row["email"];
			$socialSecurity = $contStudent_row["socialSecurity"];
			$profession = $contStudent_row["profession"];
			$work = $contStudent_row["work"];
			$company = $contStudent_row["company"];
			$workAddress = $contStudent_row["workAddress"];
			$workCity = $contStudent_row["workCity"];
			$workPhone = $contStudent_row["workPhone"];
			$workPhoneArea = $workPhone[1] . $workPhone[2] . $workPhone[3];
			$workPhoneNo = $workPhone[4] . $workPhone[5] . $workPhone[6] . $workPhone[7] . $workPhone[8] . $workPhone[9] . $workPhone[10];
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
				echo " <meta http-equiv='refresh' content='0; url= $page'> ";
			}
		?>

		<script>
			function showMe(){
				ele = document.getElementById("p1");
				ele.style.display="inline";
				document.getElementById("workAddress").setAttribute("data-validation-optional", "false");
				document.getElementById("company").setAttribute("data-validation-optional", "false");
				document.getElementById("workPhone").setAttribute("data-validation-optional", "false");
				document.getElementById("workPhoneArea").setAttribute("data-validation-optional", "false");
				document.motherInfo.company.focus();
			}

			function hideMe(){
				ele = document.getElementById("p1");
				ele.style.display="none";
				document.getElementById("workAddress").setAttribute("data-validation-optional", "true");
				document.getElementById("company").setAttribute("data-validation-optional", "true");
				document.getElementById("workPhone").setAttribute("data-validation-optional", "true");
				document.getElementById("workPhoneArea").setAttribute("data-validation-optional", "true");
				document.getElementById("workAddress").value("");
				document.getElementById("company").value("");
				document.getElementById("workPhoneArea").value("");
				document.getElementById("workPhone").value("");
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
		<link rel="stylesheet" href="chosen.css">		
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
							<input type='text' name='DOBDay' class='no-bgimg' data-validation='number length' data-validation-length='1-2' size='1' maxlength='2' value="<?PHP echo $DOBDay; ?>" onkeypress='return isGoodKey(event)'>
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
						<input type='text' name='DOBYear' class='no-bgimg' data-validation='number length' data-validation-length='min4' data-validation-allowing='range[1920;2000]' size='3' maxlength='4' value="<?PHP echo $DOBYear; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>TC Kimlik no</td>
						<td><input type='text' name='tckn' data-validation='tckn' maxlength='11' value='<?PHP echo $tckn; ?>' onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Adres</td>
						<td><input type='text' name='address'  data-validation='length' data-validation-length='10-200' maxlength='200' value='<?PHP echo $address; ?>' onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Semt</td>
						<td><input type='text' name='semt' data-validation-optional='true' data-validation='length' data-validation-length='2-40' maxlength='40'  value='<?PHP echo $semt; ?>' onkeypress='return isGoodKey(event)'></td>
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
						<td><input type='text' name='zipcode' data-validation='number length' data-validation-length='min5' maxlength='5' value="<?PHP echo $zipcode; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Ev Telefonu</td>
						<td>0 (<input type='text' name='homePhoneArea' data-validation-optional='true' data-validation='number length' data-validation-length='min3' size='4' maxlength='3' value="<?php echo $homePhoneArea; ?>" onkeypress='return isGoodKey(event)'>)<input type='text' name='homePhone'  data-validation-optional='true' data-validation='number length' data-validation-length='min7' size='8' maxlength='7' value="<?PHP echo $homePhoneNo; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Cep Telefonu</td>
						<td>0 (<input type='text' name='cellProvider' data-validation-optional='true' data-validation='number length' data-validation-allowing='range[500;599]' data-validation-length='min3' size='4' maxlength='3' value="<?PHP echo $cellProvider; ?>" onkeypress='return isGoodKey(event)'>)<input type='text' name='cellPhone' data-validation-optional='true' data-validation='number length' data-validation-length='min7' size='8' maxlength='7' value="<?PHP echo $cellPhoneNo; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Fax</td>
						<td>0 (<input type='text' name='faxArea' data-validation-optional='true' data-validation='number length' data-validation-length='min3' size='4' maxlength='3' value="<?PHP echo $faxArea; ?>" onkeypress='return isGoodKey(event)'>)<input type='text' name='fax' data-validation-optional='true' data-validation='number length' data-validation-length='min7' size='8' maxlength='7' value="<?PHP echo $faxNo; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>email</td>
						<td><input type='email' name='email' data-validation-optional='true' data-validation='email' maxlength='100' value="<?PHP echo $email; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Bağlı bulunduğu <br>Sosyal güvenlik kurumu</td>
						<td><select name='socialSecurity' class='make-chosen' data-placeholder='Seçiniz...'>
									<option value=''></option>
									<option value='SGK' <?PHP if($socialSecurity=='SGK'){ echo "selected='yes'"; } ?>>SGK</option>
									<option value='Bagkur' <?PHP if($socialSecurity=='Bagkur'){ echo "selected='yes'"; } ?>>Bağkur</option>
									<option value='Emekli Sandığı' <?PHP if($socialSecurity=='Emekli Sandığı'){ echo "selected='yes'"; } ?>>Emekli Sandığı</option>
								</select>
						</td>
					</tr><tr>
						<td>Mesleği</td>
						<td><input type='text' name='profession'  data-validation='length' data-validation-length='2-75' maxlength='100' value="<?PHP echo $profession; ?>" onkeypress='return isGoodKey(event)'></td>
					</tr><tr>
						<td>Çalışma durumu</td>
						<td><select name='work' id="work" onChange="showHide()" class='make-chosen' data-placeholder='Seçiniz...'>
									<option value=''></option>
									<option value='ücretli' <?PHP if($work=='ücretli'){ echo "selected='yes'"; }?>>Ücretli</option>
									<option value='bağımsız' <?PHP if($work=='bağımsız'){ echo "selected='yes'"; }?>>Bağımsız</option>
									<option value='kamu' <?PHP if($work=='kamu'){ echo "selected='yes'"; }?>>Kamu</option>
									<option value='isteğe bağlı' <?PHP if($work=='isteğe bağlı'){ echo "selected='yes'"; }?>>İsteğe Bağlı</option>
									<option value='tarım' <?PHP if($work=='tarım'){ echo "selected='yes'"; }?>>Tarım</option>
									<option value='emekli' <?PHP if($work=='emekli'){ echo "selected='yes'"; }?>>Emekli</option>
									<option value='ev hanımı' <?PHP if($work=='ev hanımı'){ echo "selected='yes'"; }?>>Ev Hanımı</option>
									<option value='öğrenci' <?PHP if($work=='öğrenci'){ echo "selected='yes'"; }?>>Öğrenci</option>
									<option value='çalışmıyor' <?PHP if($work=='çalışmıyor'){ echo "selected='yes'"; }?>>Çalışmıyor</option>
								</select>
						</td>
					</tr><tr>
						<td colspan=2>
							<div id="p1" style='display:none'>
								İşyeri Adı ve Ünvanı<br>
								<input type='text' name='company' id='company' data-validation-optional='true' data-validation='length' data-validation-length='2-100' maxlength='100' value="<?PHP echo $company; ?>" onkeypress='return isGoodKey(event)'><br>
								Adres<br>
								<input type='text' name='workAddress' id='workAddress' data-validation-optional='true' data-validation='length' data-validation-length='10-200' maxlength='200' value="<?PHP echo $workAddress; ?>" onkeypress='return isGoodKey(event)'><br>
								İl<br>
								<select id='workIl' name='workCity' class='make-chosen' data-placeholder='Seçiniz...'>
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
								</select><br>
								İş Telefonu<br>
								0 (<input type='text' name='workPhoneArea' id='workPhoneArea' data-validation-optional='true' data-validation='number length' data-validation-length='min3' size='4' maxlength='3' value="<?PHP echo $workPhoneArea; ?>" onkeypress='return isGoodKey(event)'>)<input type='text' id='workPhone' name='workPhone' data-validation-optional='true' data-validation='number length' data-validation-length='min7' size='8' maxlength='7' value="<?PHP echo $workPhoneNo; ?>" onkeypress='return isGoodKey(event)'><br>
								</tr>
							</div>
						</td>
					</tr>
				</table><br>
				<input type='submit' name='submit' value='Devam' style='width:120px; height: 40px; font-size:18pt;'>
				<input type='submit' name='later' value='Kaydet ve Sonra Devam Et' style='width:175px; height: 40px; font-size:10pt;'>
				<br><br>
			</form><br><br>
		</div><div class="copyright">© INÇNET</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
		<script src="../profileBuilder/form-validator/jquery.form-validator.js"></script>
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
				$("#workIl option[value='<?php echo $workCity; ?>']").prop("selected", true);
				$("#workIl").trigger("chosen:updated");
			});
		</script>
	</body>
</html>

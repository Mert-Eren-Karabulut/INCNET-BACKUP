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
	
	if (isset($_POST['submit'])){
		
		$noRelatives = $_POST['noRelatives'];
		$name = $_POST['name'];
		$name = explode(" ", $name);
		$firstname = ucfirst(strtolower($name[0]));
		$secondname = ucfirst(strtolower($name[1]));
		$thirdname = ucfirst(strtolower($name[2]));
		$name = $firstname . " " . $secondname . " " . $thirdname;
		$name = trim($name);
		
		$lastname = ucfirst(strtolower($_POST['lastname']));
		$relation = ucfirst(strtolower($_POST['relation']));
		$address = $_POST['address'];
		$semt = ucfirst(strtolower($_POST['semt']));
		$ilce = ucfirst(strtolower($_POST['ilce']));
		$il = ucfirst(strtolower($_POST['il']));
		$zipcode = $_POST['zipcode'];
		$homePhone = "0" . $_POST['homePhoneArea'] . $_POST['homePhone'];
		$cellPhone = "0" . $_POST['cellProvider'] . $_POST['cellPhone'];
		$workPhone = "0" . $_POST['workPhoneArea'] . $_POST['workPhone'];
		$fax = "0" . $_POST['faxArea'] . $_POST['fax'];
		$email = $_POST['email'];
		$profession = $_POST['profession'];
		
		
		if(($name=='')||($lastname=='')||($relation=='')||($address=='')||($semt=='')||($ilce=='')||($il=='')||($zipcode=='')||((strlen($homePhone))!=11)||((strlen($cellPhone))!=11)||((strlen($workPhone))!=11)||($email=='')||($profession=='')){//not enough info!
			$error = "Lütfen eksik veya hatalı bilgi olmadığından emin olunuz.";
		}else {
			$error = "";
			$query = "INSERT into incnet.profilesRelativesTemp VALUES ('NULL', '$registerId', '$name', '$lastname', '$relation', '$address', '$semt', '$ilce', '$il', '$zipcode', '$homePhone', '$cellPhone', '$workPhone', '$fax', '$email', '$profession')";
			mysql_query($query);
			//echo $query . "<br>";

			$page = "devicesAlt.php";
		}
		
	}
?>
<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="../incnet/favicon.ico" >
		<meta charset="utf-8">
		<body OnLoad="document.relatives.name.focus();">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<?PHP
			if ($page!=''){
				echo " <meta http-equiv='refresh' content='0; url= $page '> ";
			}
		?>
		
		<script>
			function showHide(){
				ele = document.getElementById("p1");
				if (ele.style.display=="none"){
					ele.style.display="inline";
					document.relatives.name.focus();
				} else {
					ele.style.display="none";
				}
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
		</script>
	</head>
	

	<body>
		<div class='container'>
			<div class='titleDiv'>
				4. Yakın bilgileri - II
			</div>
			<hr>
			<form name="relatives" method='POST' autocomplete='off'>
				<div style='color: #c1272d; font-size:12pt'><?PHP echo $error; ?></div>
				<table id='p1'>
					<tr>
						<td colspan="2">
						<b>2. Erişilecek kişi:</b>
						</td>
					</tr>
					<tr>
						<td>Adı</td>
						<td><input type='text' name='name' maxlength='25' onkeypress='return isGoodKey(event)' value="<?PHP echo $name; ?>"></td>
					</tr><tr>
						<td>Soyadı</td>
						<td><input type='text' name='lastname' maxlength='25' onkeypress='return isGoodKey(event)' value="<?PHP echo $lastname; ?>"></td>
					</tr><tr>
						<td>Yakınlık Derecesi</td>
						<td><input type='text' name='relation' maxlength='25' onkeypress='return isGoodKey(event)' value="<?PHP echo $relation; ?>"></td>
					</tr><tr>
						<td>Adres</td>
						<td><input type='text' name='address' maxlength='200' onkeypress='return isGoodKey(event)' value="<?PHP echo $address; ?>"></td>
					</tr><tr>
						<td>Semt</td>
						<td><input type='text' name='semt' maxlength='40' onkeypress='return isGoodKey(event)' value="<?PHP echo $semt; ?>"></td>
					</tr><tr>
						<td>İlçe</td>
						<td><input type='text' name='ilce' maxlength='40' onkeypress='return isGoodKey(event)' value="<?PHP echo $ilce; ?>"></td>
					</tr><tr>
						<td>İl</td>
						<td><input type='text' name='il' maxlength='40' onkeypress='return isGoodKey(event)' value="<?PHP echo $il; ?>"></td>
					</tr><tr>
						<td>Posta Kodu</td>
						<td><input type='text' name='zipcode' maxlength='5' onkeypress='return isGoodKey(event)' value="<?PHP echo $zipcode; ?>"></td>
					</tr><tr>
						<td>Ev Telefonu</td>
						<td>0 (<input type='text' name='homePhoneArea' size='3' maxlength='3' onkeypress='return isGoodKey(event)' value="<?PHP echo $_POST['homePhoneArea']; ?>">)
									<input type='text' name='homePhone' size='7' maxlength='7' onkeypress='return isGoodKey(event)' value="<?PHP echo $_POST['homePhone']; ?>"></td>
					</tr><tr>
						<td>Cep Telefonu</td>
						<td>0 (<input type='text' name='cellProvider' size='3' maxlength='3' onkeypress='return isGoodKey(event)' value="<?PHP echo $_POST['cellProvider']; ?>">)
									<input type='text' name='cellPhone' size='7' maxlength='7' onkeypress='return isGoodKey(event)' value="<?PHP echo $_POST['cellPhone']; ?>"></td>
					</tr><tr>
						<td>İş Telefonu</td>
						<td>0 (<input type='text' name='workPhoneArea' size='3' maxlength='3' onkeypress='return isGoodKey(event)' value="<?PHP echo $_POST['workPhoneArea']; ?>">)
								<input type='text' name='workPhone' size='7' maxlength='7' onkeypress='return isGoodKey(event)' value="<?PHP echo $_POST['workPhone']; ?>"></td>
					</tr><tr>
						<td>Fax</td>
						<td>0 (<input type='text' name='faxArea' size='3' maxlength='3' onkeypress='return isGoodKey(event)' value="<?PHP echo $_POST['faxArea']; ?>">)
								<input type='text' name='fax' size='7' maxlength='7' onkeypress='return isGoodKey(event)' value="<?PHP echo $_POST['fax']; ?>"></td>
					</tr><tr>
						<td>email</td>
						<td><input type='email' name='email' maxlength='100' onkeypress='return isGoodKey(event)' value="<?PHP echo $email; ?>"></td>
					</tr><tr>
						<td>Mesleği</td>
						<td><input type='text' name='profession' maxlength='25' onkeypress='return isGoodKey(event)' value="<?PHP echo $profession; ?>"></td>
					</tr>
			</table><br>
				<input type='submit' name='submit' value='Devam' style='width:120px; height: 40px; font-size:18pt;'>
				<br>*Lütfen tüm alanları doldurunuz.

			</form><br><br>

		</div><br><br>
		<div class="copyright">© INÇNET</div>
	</body>
</html>
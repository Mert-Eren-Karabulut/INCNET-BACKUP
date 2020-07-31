<?PHP
	//error_reporting(0);
	
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}
	
	session_start();
	
	if (isset($_SESSION['registerid'])){
		$registerId = $_SESSION['registerid'];;
	}else{
		echo "No session";
		header("location:index.php");
		$page = "index.php";
	}
	
	if (isset($_SESSION["regid"]))
	{
		//Old Students
		$regID = $_SESSION['regid'];
		$oldStudent_stmt = "SELECT * FROM incnet.profilesrelatives WHERE registerId = $regID ORDER BY relativeId ASC LIMIT 1";
		$oldStudent_query = mysql_query($oldStudent_stmt);
		while ($oldStudent_row = mysql_fetch_array($oldStudent_query))
		{
			$name = $oldStudent_row["name"];
			$lastname = $oldStudent_row["lastname"];
			$relation = $oldStudent_row["relation"];
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
			$wprkPhone = $oldStudent_row["workPhone"];
			$workPhoneArea = $workPhone[1] . $workPhone[2] . $workPhone[3];
			$workPhoneNo = $workPhone[4] . $workPhone[5] . $workPhone[6] . $workPhone[7] . $workPhone[8] . $workPhone[9] . $workPhone[10];
			$fax = $oldStudent_row["fax"];
			$faxArea = $fax[1] . $fax[2] . $fax[3];
			$faxNo = $fax[4] . $fax[5] . $fax[6] . $fax[7] . $fax[8] . $fax[9] . $fax[10];
			$email = $oldStudent_row["email"];
			$profession = $oldStudent_row["profession"];
		}
	}
	
	if ((isset($_POST['submit']))||(isset($_POST['later']))){
		
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
		$homePhoneArea = $_POST['homePhoneArea'];
		$homePhoneNo = $_POST['homePhone'];
		$cellPhone = "0" . $_POST['cellProvider'] . $_POST['cellPhone'];
		$cellProvider = $_POST['cellProvider'];
		$cellPhoneNo = $_POST['cellPhone'];
		$workPhone = "0" . $_POST['workPhoneArea'] . $_POST['workPhone'];
		$workPhoneArea = $_POST['workPhoneArea'];
		$workPhoneNo = $_POST['workPhone'];
		$fax = "0" . $_POST['faxArea'] . $_POST['fax'];
		$faxArea = $_POST['faxArea'];
		$faxNo = $_POST['fax'];
		$email = $_POST['email'];
		$profession = $_POST['profession'];
		
		//echo $noRelatives;
		
		if ($noRelatives=='noRelatives'){
			$page = "devicesAlt.php";
			echo "you're free to go!";
			$page = "devicesAlt.php";
		} else if(($name=='')||($lastname=='')||($relation=='')||($address=='')||($ilce=='')||($il=='')||($zipcode=='')||($profession=='')){//not enough info!
			$error = "Lütfen eksik veya hatalı bilgi olmadığından emin olunuz.";
		}else {
			$error = "";
			
			$registered = false;
			$regedStmt = "SELECT relativeId FROM incnet.profilesrelativestemp WHERE registerId = '$registerId' ORDER BY relativeId ASC LIMIT 1";
			$regedQuery = mysql_query($regedStmt);
			while ($regedRow = mysql_fetch_array($regedQuery))
			{
				$registered = true;
				$relativeId = $regedRow['relativeId'];
			}
			if ($registered)
			{
				$query = "UPDATE incnet.profilesrelativestemp SET name = '$name', lastname = '$lastname', relation = '$relation', address = '$address', semt = '$semt', ilce = '$ilce', il = '$il', zipcode = '$zipcode', homePhone = '$homePhone', cellPhone = '$cellPhone', workPhone = '$workPhone', fax = '$fax', email = '$email', profession = '$profession' WHERE relativeId = '$relativeId'";
			}
			else
			{
				$query = "INSERT into incnet.profilesrelativestemp VALUES ('NULL', '$registerId', '$name', '$lastname', '$relation', '$address', '$semt', '$ilce', '$il', '$zipcode', '$homePhone', '$cellPhone', '$workPhone', '$fax', '$email', '$profession')";
			}
			mysql_query($query);
			//echo $query . "<br>";
			if (isset($_POST['later']))
			{
				$page = "continueLater.php";
			}
			else
			{
				$page = "relatives2.php";
			}
		}	
	}
	else
	{
		//Continue
		$contStudent_stmt = "SELECT * FROM incnet.profilesrelativestemp WHERE registerId = $registerId ORDER BY relativeId ASC LIMIT 1";
		$contStudent_query = mysql_query($contStudent_stmt);
		while ($contStudent_row = mysql_fetch_array($contStudent_query))
		{
			$name = $contStudent_row["name"];
			$lastname = $contStudent_row["lastname"];
			$relation = $contStudent_row["relation"];
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
			$wprkPhone = $contStudent_row["workPhone"];
			$workPhoneArea = $workPhone[1] . $workPhone[2] . $workPhone[3];
			$workPhoneNo = $workPhone[4] . $workPhone[5] . $workPhone[6] . $workPhone[7] . $workPhone[8] . $workPhone[9] . $workPhone[10];
			$fax = $contStudent_row["fax"];
			$faxArea = $fax[1] . $fax[2] . $fax[3];
			$faxNo = $fax[4] . $fax[5] . $fax[6] . $fax[7] . $fax[8] . $fax[9] . $fax[10];
			$email = $contStudent_row["email"];
			$profession = $contStudent_row["profession"];
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
		<link rel="stylesheet" href="chosen.css">
	</head>
	
	<body document.relatives.name.focus();>
		<div class='container'>
			<div class='titleDiv'>
				4. Yakın bilgileri
			</div>
		<!--		Evi İstanbul, Kocaeli ve Yalova dışında olan öğrencilerimizin İstanbul ve/ veya Kocaeli' de oturan bir yakın bilgisi iletmeleri zorunludur.
			--><hr>
			<form name="relatives" method='POST' autocomplete='off'>
				<div style='color: #c1272d; font-size:12pt'><?PHP echo $error; ?></div>
				<table id='p1'>
					<tr>
						<td colspan='2'>
							<span id='error-msg'></span>
						</td>
					</tr>
					<tr>
						<td colspan="2">
						<b>1. Erişilecek kişi:</b>
						</td>
					</tr>
					<tr>
						<td>Adı</td>
						<td><input type='text' name='name' data-validation='length' data-validation-length='1-25' maxlength='25' onkeypress='return isGoodKey(event)' value="<?PHP echo $name; ?>"></td>
					</tr><tr>
						<td>Soyadı</td>
						<td><input type='text' name='lastname' data-validation='length' data-validation-length='1-25' maxlength='25' onkeypress='return isGoodKey(event)' value="<?PHP echo $lastname; ?>"></td>
					</tr><tr>
						<td>Yakınlık Derecesi</td>
						<td><input type='text' name='relation' data-validation='length' data-validation-length='1-50' maxlength='25' onkeypress='return isGoodKey(event)' value="<?PHP echo $relation; ?>"></td>
					</tr><tr>
						<td>Adres</td>
						<td><input type='text' name='address' data-validation='length' data-validation-length='10-200' maxlength='200' onkeypress='return isGoodKey(event)' value="<?PHP echo $address; ?>"></td>
					</tr><tr>
						<td>Semt</td>
						<td><input type='text' name='semt' data-validation-optional='true' data-validation='length' data-validation-length='2-40' maxlength='40' onkeypress='return isGoodKey(event)' value="<?PHP echo $semt; ?>"></td>
					</tr><tr>
						<td>İl</td>
						<td>
							<select name='il' id='il' class='make-chosen' data-placeholder="İl seçiniz...">
								<option value=''></option>
								<option value='İstanbul'>İstanbul</option>
								<option value='Kocaeli'>Kocaeli</option>
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
						<td><input type='text' name='zipcode' data-validation='number length' data-validation-length='min5' maxlength='5' onkeypress='return isGoodKey(event)' value="<?PHP echo $zipcode; ?>"></td>
					</tr><tr>
						<td>Ev Telefonu</td>
						<td>0 (<input type='text' name='homePhoneArea' data-validation-optional='true' data-validation='number length' data-validation-length='min3' size='4' maxlength='3' onkeypress='return isGoodKey(event)' value="<?PHP echo $homePhoneArea; ?>">)
									<input type='text' name='homePhone' data-validation-optional='true' data-validation='number length' data-validation-length='min7' size='8' maxlength='7' onkeypress='return isGoodKey(event)' value="<?PHP echo $homePhoneNo; ?>"></td>
					</tr><tr>
						<td>Cep Telefonu</td>
						<td>0 (<input type='text' name='cellProvider' data-validation-optional='true' data-validation='number length' data-validation-length='min3' data-validation-allowing='range[500;599]' size='4' maxlength='3' onkeypress='return isGoodKey(event)' value="<?PHP echo $cellProvider; ?>">)
									<input type='text' name='cellPhone' data-validation-optional='true' data-validation='number length' data-validation-length='min7' size='8' maxlength='7' onkeypress='return isGoodKey(event)' value="<?PHP echo $cellPhoneNo; ?>"></td>
					</tr><tr>
						<td>İş Telefonu</td>
						<td>0 (<input type='text' name='workPhoneArea' data-validation-optional='true' data-validation='number length' data-validation-length='min3' size='4' maxlength='3' onkeypress='return isGoodKey(event)' value="<?PHP echo $workPhoneArea; ?>">)
								<input type='text' name='workPhone' data-validation-optional='true' data-validation='number length' data-validation-length='min7' size='8' maxlength='7' onkeypress='return isGoodKey(event)' value="<?PHP echo $workPhoneNo; ?>"></td>
					</tr><tr>
						<td>Fax</td>
						<td>0 (<input type='text' name='faxArea' data-validation-optional='true' data-validation='number length' data-validation-length='min3' size='4' maxlength='3' onkeypress='return isGoodKey(event)' value="<?PHP echo $faxArea; ?>">)
								<input type='text' name='fax' data-validation-optional='true' data-validation='number length' data-validation-length='min7' size='8' maxlength='7' onkeypress='return isGoodKey(event)' value="<?PHP echo $faxNo; ?>"></td>
					</tr><tr>
						<td>email</td>
						<td><input type='email' name='email' data-validation-optional='true' data-validation='email' maxlength='100' onkeypress='return isGoodKey(event)' value="<?PHP echo $email; ?>"></td>
					</tr><tr>
						<td>Mesleği</td>
						<td><input type='text' name='profession' data-validation='length' data-validation-length='2-25' maxlength='25' onkeypress='return isGoodKey(event)' value="<?PHP echo $profession; ?>"></td>
					</tr>
			</table><br>
				<input type='submit' name='submit' value='Devam' style='width:120px; height: 40px; font-size:18pt;'>
				<input type='submit' name='later' value='Kaydet ve Sonra Devam Et' style='width:175px; height: 40px; font-size:10pt;'>
				<br>
			</form><br><br>

		</div><br><br>
		<div class="copyright">© INÇNET</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
		<script src="../profileBuilder/form-validator/jquery.form-validator.js"></script>
  	<script src="chosen.jquery.js" type="text/javascript"></script>
		<script>	
			$(document).ready(function(){
				errorSpan = $("#error-msg");
				$.validate({errorMessagePosition : errorSpan});
				$('.make-chosen').chosen({width:"100%", no_results_text:"Sanırım yanlış yazdınız", allow_single_deselect:true, disable_search_threshold:12});
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
			});
		</script>
	</body>
</html>

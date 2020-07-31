<?PHP
	
	error_reporting(0);
	
	//Connect to DB
	include ("../db_connect.php");
	$con;
	if (!$con){
		die('Hata: ' . mysql_error());
	}

	session_start();
	if (isset($_SESSION['registerid'])){
		$registerId = $_SESSION['registerid'];;
	}else{
		$page = "index.php";
	}
	
	$date = date("Y-m-d");
	$registered = false;
	$regedStmt = "SELECT deviceId FROM incnet.profilesdevicestemp WHERE registerId = '$registerId'";
	$regedQuery = mysql_query($regedStmt);
	while ($regedRow = mysql_fetch_array($regedQuery))
	{
		$registered = true;
	}
			
	
	if (((isset($_POST['submit']))||(isset($_POST['later'])))&&(($_POST['deviceType1'])!='')){
		
		$end = 0;
	
		$i=1;
		while($end==0){
	
			$typetext = "deviceType" . $i;
			$maketext = "deviceInfo" . $i;
			$idtext = "deviceId" . $i;

				
			$typetext = $_POST["$typetext"];
			$maketext = $_POST["$maketext"];
			$idtext = $_POST["$idtext"];

			if ($registered)
			{
				$stmt = "DELETE FROM incnet.profilesdevicestemp WHERE registerId = '$registerId'";
				mysql_query($stmt);
			}
						
			if ($typetext==""){
					$end = 1;
			} else {

				$query = "INSERT into incnet.profilesdevicestemp (registerId, registerDate, type, make, identifier) VALUES ('$registerId','$date','$typetext','$maketext','$idtext')";
				mysql_query($query);

			}
			
			$i++;
		}
		if (isset($_POST['later']))
		{
			$page = "continueLater.php";
		}
		else
		{
			$page = "summerCamps.php";
		}
	}
	else if ($registered)
	{
		//Continue
		$devNo = 1;
		$newDevHTML = "";
		$dev1jQuery = "";
		$variableName1 = "";
		$variableName2 = "";
		$variableName3 = "";
		$contStudent_stmt = "SELECT * FROM profilesdevicestemp WHERE registerId = $registerId ORDER BY deviceId ASC";
		$contStudent_query = mysql_query($contStudent_stmt);
		while ($contStudent_row = mysql_fetch_array($contStudent_query))
		{
			$variableName1 = "devType$devNo";
			$variableName2 = "devInfo$devNo";
			$variableName3 = "devId$devNo";
			$$variableName1 = $contStudent_row["type"];
			$$variableName2 = $contStudent_row["make"];
			$$variableName3 = $contStudent_row["identifier"];
			
			if ($devNo == 1)
			{
				$dev1jQuery = "
				$(\"#devType1.make-chosen option[value='$devType1']\").prop(\"selected\", true);
				$(\"#devType1.make-chosen\").trigger(\"chosen:updated\");";
			}
			else if ($devNo > 1)
			{
				$newDevHTML .= "
				<tr>
					<td>$devNo</td>
					<td>
						<select name='deviceType$devNo' class='make-chosen' data-placeholder='Seçiniz...'>
							<option value=''></option>
							<option value='telefon'";
				if ($$variableName1 == "telefon") {$newDevHTML .= "selected";}
				$newDevHTML .= ">Cep telefonu/Akıllı telefon</option>
							<option value='laptop/netbook'";
				if ($$variableName1 == "laptop/netbook") {$newDevHTML .= "selected";}
				$newDevHTML .= ">Laptop/Netbook</option>
							<option value='tablet'";
				if ($$variableName1 == "tablet") {$newDevHTML .= "selected";}
				$newDevHTML .= ">Tablet/E-reader</option>
							<option value='kamera'";
				if ($$variableName1 == "kamera") {$newDevHTML .= "selected";}
				$newDevHTML .= ">Fotoğraf makinesi/Kamera</option>
							<option value='mp3'";
				if ($$variableName1 == "mp3") {$newDevHTML .= "selected";}
				$newDevHTML .= ">mp3/mp4 player</option>
							<option value='other'";
				if ($$variableName1 == "other") {$newDevHTML .= "selected";}
				$newDevHTML .= ">diğer</option>
						</select>
					</td>
					<td><input type='text' name='deviceInfo$devNo' maxlength='60' onkeypress='return isGoodKey(event)' value='$$variableName2'></td>
					<td><input type='text' name='deviceId$devNo' maxlength='60' onkeypress='return isGoodKey(event)' value='$$variableName3'></td>
				</tr>";
			}
			$devNo++;
		}
	}
	else if (isset($_SESSION["regid"]))
	{
		//Old Students
		$regID = $_SESSION['regid'];
		//echo "here it is:" . $regID;
		$devNo = 1;
		$oldStudent_stmt = "SELECT * FROM incnet.profilesdevices WHERE registerId = $regID ORDER BY deviceId ASC";
		$oldStudent_query = mysql_query($oldStudent_stmt);
		while ($oldStudent_row = mysql_fetch_array($oldStudent_query))
		{
			//echo "results";
			$variableName1 = "devType$devNo";
			$variableName2 = "devInfo$devNo";
			$variableName3 = "devId$devNo";
			$$variableName1 = $oldStudent_row["type"];
			$$variableName2 = $oldStudent_row["make"];
			$$variableName3 = $oldStudent_row["identifier"];
			//echo $$variableName2;
			if ($devNo == 1)
			{
				$dev1jQuery = "
				$(\"#devType1.make-chosen option[value='$devType1']\").prop(\"selected\", true);
				$(\"#devType1.make-chosen\").trigger(\"chosen:updated\");";
			}
			else if ($devNo > 1)
			{
				echo $devNo;
				$newDevHTML .= "
				<tr>
					<td>$devNo</td>
					<td>
						<select name='deviceType$devNo' class='make-chosen' data-placeholder='Seçiniz...'>
							<option value=''></option>
							<option value='telefon'";
				if ($$variableName1 == "telefon") {$newDevHTML .= "selected";}
				$newDevHTML .= ">Cep telefonu/Akıllı telefon</option>
							<option value='laptop/netbook'";
				if ($$variableName1 == "laptop/netbook") {$newDevHTML .= "selected";}
				$newDevHTML .= ">Laptop/Netbook</option>
							<option value='tablet'";
				if ($$variableName1 == "tablet") {$newDevHTML .= "selected";}
				$newDevHTML .= ">Tablet/E-reader</option>
							<option value='kamera'";
				if ($$variableName1 == "kamera") {$newDevHTML .= "selected";}
				$newDevHTML .= ">Fotoğraf makinesi/Kamera</option>
							<option value='mp3'";
				if ($$variableName1 == "mp3") {$newDevHTML .= "selected";}
				$newDevHTML .= ">mp3/mp4 player</option>
							<option value='other'";
				if ($$variableName1 == "other") {$newDevHTML .= "selected";}
				$newDevHTML .= ">diğer</option>
						</select>
					</td>
					<td><input type='text' name='deviceInfo$devNo' maxlength='60' onkeypress='return isGoodKey(event)' value='" . $$variableName2 . "'></td>
					<td><input type='text' name='deviceId$devNo' maxlength='60' onkeypress='return isGoodKey(event)' value='" . $$variableName3 . "'></td>
				</tr>";
			}
			$devNo++;
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
				
		<script type="text/javascript">
		
		function init(){
			<?PHP
				if ((isset($_POST['submit']))&&(($_POST['deviceType1'])=='')){
					echo "disp_confirm()";
				}
			?>
			;
			document.devices.deviceType1.focus();
		}
			var num=1;
			function displayResult(){
				num=num+1
				var table=document.getElementById("myTable");
				var row=table.insertRow(-1);
				var cell1=row.insertCell(0);
				var cell2=row.insertCell(1);
				var cell3=row.insertCell(2);
				var cell4=row.insertCell(3);
				
				cell1.innerHTML= num;						
				cell2.innerHTML="<select name=deviceType"+num+" class='make-chosen' data-placeholder='Seçiniz...'><option value=''></option><option value='telefon'>Cep telefonu/Akıllı telefon</option><option value='laptop/netbook'>laptop/netbook</option><option value='tablet'>Tablet/E-reader</option><option value='kamera'>Fotoğraf makinesi/Kamera</option><option value='mp3'>mp3/mp4 player</option><option value='other'>diğer</option></select>";
				cell3.innerHTML="<input type=text name=deviceInfo"+num+" maxlength=60 onkeypress='return isGoodKey(event)'>";
				cell4.innerHTML="<input type=text name=deviceId" +num+" maxlength=60 onkeypress='return isGoodKey(event)'>";
				$('.make-chosen').chosen({no_results_text:"Sanırım yanlış yazdınız", allow_single_deselect:true, disable_search_threshold:12});
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

			function disp_confirm(){
				var r=confirm("Cihaz kaydı yapmadınız! Kaydedilecek bir cihazınız olmadığına emin misiniz?")
					if (r==true){
						window.location.assign("summerCamps.php");
					}
					else{
					}
			}

		</script>
		<link rel="stylesheet" href="chosen.css">
	</head>
	

	<body>
		<div class='container'>
			<div class='titleDiv'>
				5. Elektronik Eşyalar
			</div><hr>
			<form method='post' name='devices'>
			<table id='myTable'>
				<tr>
					<td></td>
					<td> Cihaz türü </td>
					<td> Marka/Model </td>
					<td> Tanıtıcı Bilgi* </td>
				</tr>
				<tr>
					<td>1</td>
					<td>
						<select name='deviceType1' id='devType1' class='make-chosen' data-placeholder='Seçiniz...'>
							<option value=''></option>
							<option value='telefon'>Cep telefonu/Akıllı telefon</option>
							<option value='laptop/netbook'>laptop/netbook</option>
							<option value='tablet'>Tablet/E-reader</option>
							<option value='kamera'>Fotoğraf makinesi/Kamera</option>
							<option value='mp3'>mp3/mp4 player</option>
							<option value='other'>diğer</option>
						</select>
					</td>
					<td><input type='text' name='deviceInfo1' value="<?php echo $devInfo1; ?>" maxlength='60' onkeypress='return isGoodKey(event)'></td>
					<td><input type='text' name='deviceId1' value="<?php echo $devId1; ?>" maxlength='60' onkeypress='return isGoodKey(event)'></td>
				</tr><?php echo $newDevHTML; ?>
			</table><br>
			<button type="button" onclick="displayResult()">Yeni Cihaz Ekle</button><br>
			<p style='font-size:8pt;'>*Tanıtıcı bilgi, cihazın seri numarası veya MAC adresidir ve opsiyoneldir. Okul ağından faydalanacak cihazların MAC adresi yazılmalıdır. INÇNET, MAC adresi yazılan cihazların internete girmesi garantisi vermez.</p>
				<input type='submit' name='submit' value='Devam' style='width:120px; height: 40px; font-size:18pt;'>
				<input type='submit' name='later' value='Kaydet ve Sonra Devam Et' style='width:175px; height: 40px; font-size:10pt;'>
			</form><br><br>
		</div><br><br>
		</div><div class="copyright">© INÇNET</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
  	<script src="chosen.jquery.js" type="text/javascript"></script>
		<script>	
			$(document).ready(function(){
				$('.make-chosen').chosen({no_results_text:"Sanırım yanlış yazdınız", allow_single_deselect:true, disable_search_threshold:12});<?php echo $dev1jQuery; ?>
			});
		</script>
	</body>
</html>

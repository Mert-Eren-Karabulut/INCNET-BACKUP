<?PHP
	
	//Connect to DB
	include ("../db_connect.php");
	$con;
	if (!$con){
		die('Hata: ' . mysql_error());
	}

	error_reporting(0);

	session_start();
	if (isset($_SESSION['regid'])){
		$registerId = $_SESSION['regid'];;
	}else{
		$page = "index.php";
	}
	
	$date = date("Y-m-d");

	
	if ((isset($_POST['submit']))&&(($_POST['deviceInfo1'])!='')){
		
		$end = 0;
	
		$i=1;
		while($end==0){
	
			$typetext = "deviceType" . $i;
			$maketext = "deviceInfo" . $i;
			$idtext = "deviceId" . $i;

				
			$typetext = $_POST["$typetext"];
			$maketext = $_POST["$maketext"];
			$idtext = $_POST["$idtext"];


						
			if ($typetext==""){
					$end = 1;
			} else {

				$query = "INSERT into incnet.profilesDevicesTemp (registerId, registerDate, type, make, identifier) VALUES ('$registerId','$date','$typetext','$maketext','$idtext')";
				mysql_query($query);

			}
			
			$i++;
		}
		$page = "summerCamps.php";

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
				if ((isset($_POST['submit']))&&(($_POST['deviceInfo1'])=='')){
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
				cell2.innerHTML="<select name=deviceType"+num+"><option value=''>Seçiniz...</option><option value='telefon'>Cep telefonu/Akıllı telefon</option><option value='laptop/netbook'>laptop/netbook</option><option value='tablet'>Tablet/E-reader</option><option value='kamera'>Fotoğraf makinesi/Kamera</option><option value='mp3'>mp3/mp4 player</option><option value='other'>diğer</option></select>";
				cell3.innerHTML="<input type=text name=deviceInfo"+num+" maxlength=60 onkeypress='return isGoodKey(event)'>";
				cell4.innerHTML="<input type=text name=deviceId" +num+" maxlength=60 onkeypress='return isGoodKey(event)'>";

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
						<select name='deviceType1'>
							<option value=''>Seçiniz...</option>
							<option value='telefon'>Cep telefonu/Akıllı telefon</option>
							<option value='laptop/netbook'>laptop/netbook</option>
							<option value='tablet'>Tablet/E-reader</option>
							<option value='kamera'>Fotoğraf makinesi/Kamera</option>
							<option value='mp3'>mp3/mp4 player</option>
							<option value='other'>diğer</option>
						</select>
					</td>
					<td><input type='text' name='deviceInfo1' maxlength='60' onkeypress='return isGoodKey(event)'></td>
					<td><input type='text' name='deviceId1' maxlength='60' onkeypress='return isGoodKey(event)'></td>
				</tr>
			</table><br>
			<button type="button" onclick="displayResult()">Yeni Cihaz Ekle</button><br>
			<p style='font-size:8pt;'>*Tanıtıcı bilgi, cihazın seri numarası veya MAC adresidir ve opsiyoneldir. Okul ağından faydalanacak cihazların MAC adresi yazılmalıdır. INÇNET, MAC adresi yazılan cihazların internete girmesi garantisi vermez.</p>
				<input type='submit' name='submit' value='Devam' style='width:120px; height: 40px; font-size:18pt;'>
			</form><br><br>
		</div><br><br>
		</div><div class="copyright">© INÇNET</div>
	</body>
</html>
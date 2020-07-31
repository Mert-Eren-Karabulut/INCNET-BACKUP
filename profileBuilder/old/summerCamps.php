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
		header("location:index.php");	
		$newPage = "index.php";
	}
	
//	echo "regId: " . $registerId;
	
	if (isset($_POST['submit'])){
		
		$join = $_POST['join'];
		$institution = $_POST['institution'];
		$program = $_POST['program'];
		$country = $_POST['country'];
		$city = $_POST['city'];
		$date = date("Y-m-d");

		
		if ($join=='noJoin'){
			$newPage = "saving.php";
			echo "you're free!";
		}else if (($institution=='')||($program=='')||($country=='')||($city=='')){//not enough info
			$error = "Lütfen eksik veya hatalı bilgi olmadığından emin olunuz.";
		} else {
			$query = "INSERT into incnet.profilesSummerCampsTemp VALUES ('NULL', '$registerId', '$institution', '$program', '$country', '$city', '$date')";
			//echo $query . "<br>";
			mysql_query($query);
			$newPage = "saving.php";
		}
		
	}
?>
<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="../incnet/favicon.ico" >
		<meta charset="utf-8">
		<body OnLoad="document.summerCamps.institution.focus();">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<?PHP
			if ($newPage!=''){
				echo "<meta http-equiv='refresh' content='0; url=saving.php'>";
			}
		?>
		
		<script>
			function showHide(){
				ele = document.getElementById("p1");
				if (ele.style.display=="none"){
					ele.style.display="inline";
					document.summerCamps.institution.focus();
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
				6. Yaz Programı ve Staj Bilgileri
			</div><hr>
			<form name="summerCamps" method='POST' autocomplete='off'>
				<div style='color: #c1272d; font-size:12pt'><?PHP echo $error; ?></div>
				<input type="checkbox" name="join" value="noJoin" onclick="showHide()">Yaz programına katılmadım.<br>
				<table id='p1'>
					<tr>
						<td>Üniversite/Kurum</td>
						<td><input type='text' name='institution' maxlength='150' onkeypress='return isGoodKey(event)' value="<?PHP echo $institution; ?>"></td>
					</tr><tr>
						<td>Program</td>
						<td><input type='text' name='program' maxlength='150' onkeypress='return isGoodKey(event)' value="<?PHP echo $program; ?>"></td>
					</tr><tr>
						<td>Ülke</td>
						<td><input type='text' name='country' maxlength='40' onkeypress='return isGoodKey(event)' value="<?PHP echo $country; ?>"></td>
					</tr><tr>
						<td>Şehir</td>
						<td><input type='text' name='city' maxlength='100' onkeypress='return isGoodKey(event)' value="<?PHP echo $city; ?>"></td>
					</tr>
				</table><br>
				<input type='submit' name='submit' value='Devam' style='width:120px; height: 40px; font-size:18pt;'>
				<br>*Lütfen tüm alanları doldurunuz.

			</form><br><br>
		</div><div class="copyright">© INÇNET</div>

	</body>
</html>
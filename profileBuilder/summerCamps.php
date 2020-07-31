<?PHP

	//Connect to DB
	include ("../db_connect.php");
	$con;
	if (!$con){
		die('Hata: ' . mysql_error());
	}

	error_reporting(0);

	session_start();
	if (isset($_SESSION['registerid'])){
		$registerId = $_SESSION['registerid'];;
	}else{
		header("location:index.php");	
		$newPage = "index.php";
	}
	
//	echo "regId: " . $registerId;
	$camp_count = 1;
	
	/*if (isset($_SESSION["user_id"]))
	{
		//Old Students
		$oldStudent_stmt = "SELECT * FROM profilessummercamps WHERE registerId = $registerId ORDER BY campId ASC";
		$oldStudent_query = mysql_query($oldStudent_stmt);
		while ($oldStudent_row = mysql_fetch_array($oldStudent_query))
		{
			$camp_count = $oldStudent_row["COUNT(*)"];
			$institution[] = $oldStudent_row["institution"];
			$program[] = $oldStudent_row["program"];
			$country[] = $oldStudent_row["country"];
			$city[] = $oldStudent_row["city"];
		}
	}
	*/
	if (isset($_POST['submit'])){
		
		$join = $_POST['join'];
		$institution = $_POST['institution'];
		$program = $_POST['program'];
		$country = $_POST['country'];
		$city = $_POST['city'];
		$date = date("Y-m-d");
		$camp_count = $_POST["camp_count"];
		
		if ($join=='noJoin'){
			$newPage = "saving.php";
			echo "you're free!";
		} else if ((in_array("", $institution))||(in_array("", $program))||(in_array("", $country))||(in_array("", $city))){//not enough info
			$error = "Lütfen eksik veya hatalı bilgi olmadığından emin olunuz.";
		} else {
			foreach ($institution as $count => $inst)
			{
				$query = "INSERT into incnet.profilesSummerCampsTemp VALUES ('NULL', '$registerId', '$inst', '$program[$count]', '$country[$count]', '$city[$count]', '$date[$count]')";
				//echo $query . "<br>";
				mysql_query($query);
			}
				$newPage = "saving.php";
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
			if ($newPage!=''){
				echo "<meta http-equiv='refresh' content='0; url=saving.php'>";
			}
		?>
		<style>
		.p1
		{
			display:inline-block;
		}
		</style>
	</head>
	

	<body OnLoad="document.summerCamps.institution.focus();">
		<div class='container'>
			<div class='titleDiv'>
				6. Yaz Programı ve Staj Bilgileri
			</div><hr>
			<form name="summerCamps" method='POST' autocomplete='off'>
				<input type='hidden' name='camp_count' id='campCount' value='<?php echo $camp_count; ?>'>
				<div style='color: #c1272d; font-size:12pt'><?PHP echo $error; ?></div>
				<input type="checkbox" name="join" value="noJoin" onclick="showHide()">Yaz programına katılmadım.<br>
				<div id='camps'>
				<?php
				
				for ($loop_count=0; $camp_count>$loop_count; $loop_count++)
				{

						$val1 = $institution[$loop_count];
						$val2 = $program[$loop_count];
						$val3 = $country[$loop_count];
						$val4 = $city[$loop_count];
					
					
					echo "
				<table class='p1'>
					<tr>
						<td>Üniversite/Kurum</td>
						<td><input type='text' name='institution[]' maxlength='150' onkeypress='return isGoodKey(event)' value='" . $val1 . /*echo $institution;*/ "'></td>
					</tr><tr>
						<td>Program</td>
						<td><input type='text' name='program[]' maxlength='150' onkeypress='return isGoodKey(event)' value='" . $val2 .  /* echo $program; */"'></td>
					</tr><tr>
						<td>Ülke</td>
						<td><input type='text' name='country[]' maxlength='40' onkeypress='return isGoodKey(event)' value='" . $val3 . /* echo $country; */"'></td>
					</tr><tr>
						<td>Şehir</td>
						<td><input type='text' name='city[]' maxlength='100' onkeypress='return isGoodKey(event)' value='" . $val4 . /* echo $city; */"'></td>
					</tr>
				</table>";
				}
				
				?>
				</div>
				<input type='submit' name='submit' value='Bitir' style='width:120px; height: 40px; font-size:18pt;'>
				<button type='button' id='addCamp' style='width:165px; height: 40px; font-size:12pt; position:relative; bottom:2px;'>Başka Kamp Ekle</button>
				<br>*Lütfen tüm alanları doldurunuz.

			</form><br><br>
		</div><div class="copyright">© INÇNET</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
		<script>
			$(document).ready(function(){
				$("#addCamp").click(function(){
					campCount = $("#campCount").val();
					campCount++;
					$("#campCount").val(campCount);
					newCamp = "<table class='p1'><tr><td>Üniversite/Kurum</td><td><input type='text' name='institution[]' maxlength='150' onkeypress='return isGoodKey(event)'></td></tr><tr><td>Program</td><td><input type='text' name='program[]' maxlength='150' onkeypress='return isGoodKey(event)'></td></tr><tr><td>Ülke</td><td><input type='text' name='country[]' maxlength='40' onkeypress='return isGoodKey(event)'></td></tr><tr><td>Şehir</td><td><input type='text' name='city[]' maxlength='100' onkeypress='return isGoodKey(event)'></td></tr></table>";
					$('#camps').append(newCamp);
				});
			});
			
			function showHide(){
				if ($(".p1").is(":hidden")==true){
					$(".p1").css("display", "inline-block");
					document.summerCamps.institution.focus();
				} else {
					$(".p1").hide();
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
	</body>
</html>

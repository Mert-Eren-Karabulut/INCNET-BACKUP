<?PHP
	error_reporting(0);

	if (isset($_POST['startPrep'])){
		header("location:student_info.php");
	}
	
	if (isset($_POST['startOthers'])){
		header("location:incnetHelp.php");
	}

	
?>

<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="../incnet/favicon.ico" >
		<meta charset="utf-8">
		<body OnLoad="document.studentInfo.name.focus();">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	</head>

	<body>
		<div class='container'>
			<div class='titleDiv'>
				2013 Bilgilendirme Formu
			</div><hr>
			
			Bu form sene içinde ihtiyaç duyulabilecek bilgileri toplamak için hazırlanmıştır.<br>
			Lütfen bilgileri eksiksiz doldurun. Formu doldurmayı bitirmeden tarayıcınızı kapatmayın.
			<b>Dikkat!</b><br>
			Hazırlığa başlayacak öğrenciler ve diğer öğrencilerin dolduracağı formlar farklıdır.<br><br>
			<form method='POST'>
				<table border='0' style='width:100%'>
					<tr>
						<td style='text-align:center'>
							<input type='submit' value='Hazırlık Sınıfları için' name='startPrep' style='width:200px; height: 40px; font-size:14pt;'>
						</td>
						<td style='text-align:center'>
							<input type='submit' value='Diğer Sınıflar için' name='startOthers' style='width:200px; height: 40px; font-size:14pt;'>
						</td>
					</tr>
				</table><br><br>
			</form>

		</div>
			<div class="copyright">© INÇNET</div>
	</body>


</html>
<?PHP
	error_reporting(0);

	if (isset($_POST['startPrep'])){
		header("location:student_info.php");
	}
	
	if (isset($_POST['startOthers'])){
		header("location:incnetHelp.php");
	}

	if (isset($_POST['continueForm'])){
		header("Location:continueForm.php");
	}
?>

<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	</head>

	<body>
		<div class='container'>
			<div class='titleDiv'>
				2014 Bilgilendirme Formu
			</div><hr>
			
			Bu form sene içinde ihtiyaç duyulabilecek bilgileri toplamak için hazırlanmıştır.<br>
			Lütfen bilgileri eksiksiz doldurun. <del>Formu doldurmayı bitirmeden tarayıcınızı kapatmayın.</del><br>
			Bu sene form doldurmaya ara verebilirsiniz. Ara vermeden önce "Kaydet ve Sonra Devam Et" butonuna tıklamayı unutmayın!<br>
			Devam etmek için e aşağıdaki butona tıklamanız yeterli.
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
					<tr>
						<td colspan='2' style='padding-top:10px; text-align:center;'>
							<input type='submit' value='Form Doldurmaya Devam Et' name='continueForm' style='width:250px; height: 40px; font-size:14pt;'>
						</td>
				</table><br><br>
			</form>

		</div>
			<div class="copyright">© INÇNET</div>
	</body>


</html>

<?php

error_reporting(0);

require ("../db_connect.php");
if(!$con)
{
	die('Could not connect: ' . mysql_error());
}

if (isset($_POST['submit']))
{
	//echo "here!";
	$tckn = $_POST['tckn'];
	$contCode = $_POST['contCode'];
	
	$contStmt = "SELECT registerId FROM profilesmaintemp WHERE tckn = $tckn";
	$contQuery = mysql_query($contStmt);
	while($contRow = mysql_fetch_array($contQuery))
	{
		$registerId = $contRow['registerId'];
	}
	$codeRemake = substr(md5($registerId), 0, 6);
	
	if ($codeRemake == $contCode)
	{
		session_start();
		$_SESSION['registerid'] = $registerId;
		header("Location:student_info.php");
	}
	else
	{
		$error = "Hatalı kimlik numarası ve/veya devam kodu. Lütfen bilgilerinizi tekrar girin veya forma baştan başlayın.";
	}
}

?>
<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<style>
			.first {
				width: 150px;
			}
			.one {
				padding-top: 10px;
				padding-right: 10px;
				text-align: right;
			}
		</style>
	</head>
	<body>
		<div class='container'>
			<div class='titleDiv'>
				2014 Bilgilendirme Formu - Devam
			</div><hr>
			<form method='POST'>
				<table>
					<tr>
						<td rowspan='6' style='width:10px;'></td>
						<td colspan='2'></td>
						<td rowspan='6' style='width:175px;'></td>
						<td rowspan='6'><img src='admin/tevitol.png' alt='Tevitöl Logo' height='150px' style='float:right;'></td>
					</tr>
					<tr>
						<td colspan='2' style='margin-bottom:20px;'>Devam etmek için gerekli bilgileri lütfen aşağıya giriniz.</td>
					</tr>
					<tr>
						<td colspan='2'>
							<span id='error-msg'><?php echo $error; ?></span>
						</td>
					</tr>
					<tr>
						<td class='first'>TC Kimlik No:</td>
						<td><input type='text' name='tckn' size='17' data-validation='tckn' maxlength='11'></td>
					</tr>
					<tr>
						<td class='first'>Devam Kodu:</td>
						<td><input type='text' name='contCode' size='17' data-validation='length' data-validation-length='min6'></td>
					</tr>
					<tr>
						<td colspan='2' class='one'>
							<input type='submit' name='submit' value='Continue' style='width:120px; height: 40px; font-size:18pt;'>
						</td>
					</tr>
				</table>		
			</form>
		</div>
		<script src="../profileBuilder/form-validator/jquery.form-validator.js"></script>
		<script>
			$(document).ready(function(){
				errorSpan = $("#error-msg");
				$.validate({errorMessagePosition : errorSpan});
			)};
		</script>
	</body>
</html>

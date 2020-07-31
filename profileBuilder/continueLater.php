<?php

error_reporting(0);

session_start();
$registerId = $_SESSION['registerId'];

$contCode = substr(md5($registerId), 0, 6);
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
				Daha sonra devam et
			</div><hr>
			<p style='font-size:11pt;'>
				<img src='admin/tevitol.png' alt='Tevitöl Logo' height='150px' style='float:right;'>
				<br>
				Formu doldurmaya devam etmek için TC Kimlik Numaranıza ve Devam Koduna ihtiyacınız olacak. Devam kodunuz aşağıda, lütfen bir yere not edin.<br><br>
				<span style='font-size:20pt; color:#c1272d;'>Devam Kodu: <?php echo $contCode; ?></span>
			</p>
		</div>
	</body>
</html>

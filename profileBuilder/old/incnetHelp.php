<?PHP
	error_reporting(0);
	
	session_start();
	session_destroy();
?>

<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="../incnet/favicon.ico" >
		<meta charset="utf-8">
		<body OnLoad="document.studentInfo.name.focus();">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">

		<style>
			a:link {
				text-decoration: none;
			}
			
			a:visited {
				text-decoration: none;
			}
			
			a:hover {
				text-decoration: underline;
			}
			
			a:active {
				text-decoration: none
			}
		</style>

	</head>

	<body>
		<div class='container'><br>
			<div class='titleDiv'>
				Özlemişiz...
			</div><hr>
				Formu doldurarak profilinizi tamamlamak için INÇNET'e giriş yapmanız gerekmektedir.<br>
				
				<a href='../incnet' style='color:#c1272d'>Buradan</a> giriş yaptıktan sonra <c style='color:#c1272d'>"Complete your profile"</c> linkinden forma ulaşabilirsiniz.
				<br><br>
				<center>
				<img src="incnetHelp.png" height='260px'><br><br>
				<a href='../incnet' style='color:#c1272d; font-size:14pt;'>Tamam, anladım.</a>
				</center>
				
	</body>

		<div class="copyright">© INÇNET</div>
</html>
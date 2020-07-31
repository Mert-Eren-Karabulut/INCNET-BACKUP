<? 
	if(isset($_POST['submit']))
	{
	
	

		if(($_POST['uname']=='guvenlik')&&($_POST['password']=="guvenliksifre321"))
	

		{
	

			$_SESSION['checked'] = true;
			echo '<meta http-equiv="refresh" content="0; URL=\'http://incnet.tevitol.org/gcenter/guvenlik.php\'" />';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gebze Center</title>
	<meta charset="UTF-8">
</head>
<style type="text/css">
	input {
		width: 100%;
	}
	h1 {
		text-align: center;
	}
</style>
<body>
	<h1>GEBZE CENTER</h1>
	<h1>GÜVENLİK GİRİŞİ</h1>
<form method="POST">
	<table align="center">
		<tr>
			<td>Kullanıcı Adı:</td>
			<td><input type="text" name="uname"></td>
		</tr>
		<tr>
			<td>Şifre:</td>
			<td><input type="password" name="password"></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="submit" value="Giris Yap"></td>
		</tr>
	</table>
</form>
</body>
</html>
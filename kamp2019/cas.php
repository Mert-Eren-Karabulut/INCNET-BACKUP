<?php
	$host = "94.73.150.252";
	$user = "incnetRoot";
	$passwd = "6eI40i59n22M7f9LIqH9";
	$dbname = "incnet";
	
	$err = false;
?>

<html>
	<head>
		<title>Kayıt 2019|CAS Mülakatı</title>
		<meta charset=UTF-8 />
	</head>
	<body>
	<h2>Cas Mülakatı</h2>
        <script>
			setTimeout(function(){document.getElementsByTagName("textarea")[0].style.color = "grey";}, 5000);
		</script>
		<form method=POST >
			<label for=tckn>TCKN </label> <input id=tckn type=number name=tckn autofocus /><br/>
			<input type=submit name=go value=Gönder />
		</form>
		<textarea rows=30 cols=100>
<?php
			if(isset($_POST['go'])){
				echo("TCKN: $_POST[tckn].\n");
				echo("Güncellemeye başlanıyor.\n");
				echo("Veritabanına bağlanılıyor.\n");
				$conn = mysqli_connect($host, $user, $passwd, $dbname) or die("Veritabanına bağlanılamadı!<br/>\n".mysqli_connect_error());
				echo("Bağlantı başarılı.\n");
				echo("Yazma işlemine başlanıyor.\n");
				$res = mysqli_query($conn, "UPDATE `kamp2019takip` SET cas=NOW() WHERE tckn=".mysqli_real_escape_string($conn, $_POST['tckn']));
				if($res){
					echo("Yazma başarılı.\n");
				}else{
					echo("Yazma başarısız.\n");
					$err = true;
				}
				echo("Sağlama işlemine başlanıyor\n");
				$res = mysqli_query($conn, "SELECT * FROM `kamp2019takip` WHERE tckn=".mysqli_real_escape_string($conn, $_POST['tckn']));
				$row = mysqli_fetch_assoc($res);
				if($row === null || $row['cas'] === null){
					echo("Sağlama başarısız.\n");
					$err = true;
				}else{
					echo("Sağlama başarılı.\n");
				}
				
				if($err){
					echo("*****GÜNCELLEME BAŞARISIZ*****\n");
				}else{
					echo("*****GÜNCELLEME BAŞARILI*****\n");
				}
			}
		?>
		</textarea>
	</body>
</html>
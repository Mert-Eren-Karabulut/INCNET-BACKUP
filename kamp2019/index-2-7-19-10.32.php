<!DOCTYPE html>
<?php
	$host = "94.73.150.252";
	$user = "incnetRoot";
	$passwd = "6eI40i59n22M7f9LIqH9";
	$dbname = "incnet";
	
	$err = false;
?>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Kayıt 2019</title>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <link rel="stylesheet" href="./style.css">

  
</head>

<body>

  <section class="strips">
  <article class="strips__strip">
    <div class="strip__content">
      <h1 class="strip__title" data-name="Lorem">Kayıt Masası</h1>
      <div class="strip__inner-text">
        <h2>Kayıt Masası</h2>
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
				$res = mysqli_query($conn, "UPDATE `kamp2019takip` SET geldi=NOW() WHERE tckn=".mysqli_real_escape_string($conn, $_POST['tckn']));
				if($res){
					echo("Yazma başarılı.\n");
				}else{
					echo("Yazma başarısız.\n");
					$err = true;
				}
				echo("Sağlama işlemine başlanıyor\n");
				$res = mysqli_query($conn, "SELECT * FROM `kamp2019takip` WHERE tckn=".mysqli_real_escape_string($conn, $_POST['tckn']));
				$row = mysqli_fetch_assoc($res);
				if($row === null || $row['geldi'] === null){
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
     
        
      </div>
      
    </div>
  </article>
  <article class="strips__strip">
    <div class="strip__content">
      <h1 class="strip__title" data-name="Ipsum">Cas Mülakatı</h1>
      <div class="strip__inner-text">
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
      </div>
    </div>
  </article>
  <article class="strips__strip">
    <div class="strip__content">
      <h1 class="strip__title" data-name="Dolor">Öğretmen Mülakatı</h1>
      <div class="strip__inner-text">
        <h2>Öğretmen Mülakatı</h2>
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
				$res = mysqli_query($conn, "UPDATE `kamp2019takip` SET mulakat=NOW() WHERE tckn=".mysqli_real_escape_string($conn, $_POST['tckn']));
				if($res){
					echo("Yazma başarılı.\n");
				}else{
					echo("Yazma başarısız.\n");
					$err = true;
				}
				echo("Sağlama işlemine başlanıyor\n");
				$res = mysqli_query($conn, "SELECT * FROM `kamp2019takip` WHERE tckn=".mysqli_real_escape_string($conn, $_POST['tckn']));
				$row = mysqli_fetch_assoc($res);
				if($row === null || $row['mulakat'] === null){
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
      </div>
    </div>
  </article>
  <article class="strips__strip">
    <div class="strip__content">
      <h1 class="strip__title" data-name="Sit">İngilizce Sınavı</h1>
      <div class="strip__inner-text">
        <h2>İngilizce Sınavı</h2>
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
				$res = mysqli_query($conn, "UPDATE `kamp2019takip` SET ingilizce=NOW() WHERE tckn=".mysqli_real_escape_string($conn, $_POST['tckn']));
				if($res){
					echo("Yazma başarılı.\n");
				}else{
					echo("Yazma başarısız.\n");
					$err = true;
				}
				echo("Sağlama işlemine başlanıyor\n");
				$res = mysqli_query($conn, "SELECT * FROM `kamp2019takip` WHERE tckn=".mysqli_real_escape_string($conn, $_POST['tckn']));
				$row = mysqli_fetch_assoc($res);
				if($row === null || $row['ingilizce'] === null){
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
      </div>
    </div>
  </article>
  <article class="strips__strip">
    <div class="strip__content">
      <h1 class="strip__title" data-name="Amet">Aday Takip</h1>
      <div class="strip__inner-text">
	  <h2>
        <a href="takip.php" style="color: inherit; text-decoration: none">Tıklayınız</a>
		</h2>
      </div>
    </div>
  </article>
  <i class="fa fa-close strip__close"></i>
</section>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

  

    <script  src="./script.js"></script>




</body>

</html>

<?PHP
	error_reporting(0);
	
	//connect to mysql server
	include ("../../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
  
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:login.php");
	}
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$lang = $_SESSION['lang'];
	
	//permissions  
	$page_id = "901";
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:../../incnet/login.php");
	}
	$user_id = $_SESSION['user_id'];
	
	$permit_query = mysql_query("SELECT * FROM incnet.corepermits WHERE user_id='$user_id' AND page_id='$page_id'");
	while($permit_row = mysql_fetch_array($permit_query)){
		$allowance = "1";
	}
	if ($allowance != "1"){
		header ("location:../../incnet/login.php");
	}

	if (isset($_POST['delete'])){
		$delStudent = $_POST['deleteStudent'];
		mysql_query("DELETE FROM incnet.profilesmain WHERE registerId = $delStudent");
		mysql_query("DELETE FROM incnet.profilesmotherinfo WHERE registerId = $delStudent");
		mysql_query("DELETE FROM incnet.profilesfatherinfo WHERE registerId = $delStudent");
		mysql_query("DELETE FROM incnet.profilesrelatives WHERE registerId = $delStudent");
		mysql_query("DELETE FROM incnet.profilessummerCamps WHERE registerId = $delStudent");
		mysql_query("DELETE FROM incnet.profilesdevices WHERE registerId = $delStudent");
		header("location:fullProfile.php");

	}
?>

<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="../../incnet/favicon.ico" >
		<meta charset="utf-8">
		<body OnLoad="init();">
		<link rel="stylesheet" href="../style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	</head>
	<body>
		<div class='container'>
			<div class='titleDiv'>
				Dikkat! / Warning!
			</div><hr>
				Bu işlem seçtiğiniz öğrencinin tüm kayıtlarını yok edecektir.<br>
				Devam edilsin mi?<br><br>
				<i>This operation will destroy all records for the selected student.<br>
				Proceed?</i><br><br>
				<form method='POST'>
					<input type='submit' name='delete' Value='Evet'>
					<input type='hidden' name='deleteStudent' value="<?PHP echo $_GET['delStudent']; ?>">
					<input type='button' onClick="history.go(-1)" value='Hayır'>
				</form>
		</div><br><br>
		</div><div class="copyright">© INÇNET</div>
	</body>
</html>

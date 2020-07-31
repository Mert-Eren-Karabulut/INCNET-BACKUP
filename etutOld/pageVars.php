<?PHP
	error_reporting(0);
	
	
	//connect to mysql server
	include ("../db_connect.php");
	include ("functions.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
  
	session_start();
	if (!(isset($_SESSION['user_id']))){
		$newPage = "<meta http-equiv='refresh' content='0; url=../incnet/login.php'>";
	}
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$lang = $_SESSION['lang'];
	
	if (isset($_POST['logoff'])){
		session_destroy();
		$newPage = "<meta http-equiv='refresh' content='0; url=../incnet/index.php'>";
	}
	
	mysql_select_db("incnet");
	
	if (checkAdmin($user_id)==0){
		$newPage = "<meta http-equiv='refresh' content='0; url=index.php'>";
	}

	if (isset($_POST['submit'])){
		$startDate = $_POST['startDate'];
		$endDate = $_POST['endDate'];
		
		mysql_query("UPDATE etutvars SET value='$startDate' WHERE name='startDate'");
		mysql_query("UPDATE etutvars SET value='$endDate' WHERE name='endDate'");
	}
	
		
	$sql = mysql_query("SELECT value FROM etutvars WHERE var_id=1");
	while ($row=mysql_fetch_array($sql)){
		$startDate = $row[0];
	}
	
	$sql = mysql_query("SELECT value FROM etutvars WHERE var_id=2");
	while ($row=mysql_fetch_array($sql)){
		$endDate = $row[0];
	}
	


?>

<!doctype html>
<HTML>
	<head>
		<?PHP
			if ($newPage!=''){
				echo $newPage;
			}
		?>
		<link rel="shortcut icon" href="../../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	</head>
	
	<body>
		<div class="header">
			<?PHP echo $fullname; ?>
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='index.php'><img style='position: relative; top:20px;' src='../../incnet/incnet.png' width='140px'></a>
				</td>
				<div style='position:absolute; bottom:30px; z-index:2;' >
					<form name="logoff" method="POST">
						<input type ="submit" name="logoff" value="Log Off">
					</form>
				</div>

				<td valign='top'>
				<br><br>
				<div class='titleDiv'><br>Page Variables<br></div><br>
				These values do not affect when the period is reset. It should still be reset manually.<br><br>
				<form method='POST'>
					Period starts:<br>
					<input onClick='this.select();' type='text' name='startDate' value='<? echo $startDate; ?>' autofocus><br><br>
					Period ends:<br>
					<input onClick='this.select();' type='text' name='endDate' value='<? echo $endDate; ?>' ><br>
					<input type='submit' name='submit' value='Save'>
				</form>
				
				</td>

			</tr>
		</table>
		
		<div class="copyright">&nbsp © INCNET</div>
	</body>
</HTML>









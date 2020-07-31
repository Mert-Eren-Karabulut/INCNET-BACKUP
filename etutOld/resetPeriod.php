<?PHP

	if (isset($_POST['cancel'])){
		header("location:index.php");
	}	


	error_reporting(0);

	
	//connect to mysql server
	include ("../db_connect.php");
	include ("functions.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
  
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:../incnet/");
	}
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$lang = $_SESSION['lang'];
	
	mysql_select_db("incnet");
	
	if (checkAdmin($user_id)==0){
		$newPage = "<meta http-equiv='refresh' content='0; url=index.php'>";
	}


	if (isset($_POST['reset'])){
		//echo "resetting period";
		mysql_query("INSERT INTO incnet.etut_pastPeriods SELECT * FROM incnet.etut_thisPeriod");
		mysql_query("DELETE FROM incnet.etut_thisPeriod");
		$msg = "Reset successful.<br>";
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
	
	<body OnLoad="document.reservations.seat.focus();">
		<div class="header">
			<?PHP echo $fullname; ?>
		</div>
		<div style='width:600px; position:absolute; margin-left:-300px; top:120px; left:50%; background-color:white;'>
			<div style='font-size:24pt; width:600px; background-color:#c1272d; color:white; text-align:center'>Warning!</div>
			<div style='font-size:16pt; width:500px; position:relative; left:50px'>
				<br>This operation can't be reversed. Are you sure you want to continue?<br><br>
				<form method='POST'>
					<table style='width:100%'>
						<tr>
							<td style='text-align:center'>
								<input type='submit' name='reset' value='Reset' style='color:#c1272d; font-size:20pt; font-weight:bold; width:140px'>
							</td>
							<td style='text-align:center'>
								<input type='submit' name='cancel' value='Cancel' style='color:green; font-size:20pt; font-weight:bold; width:140px'>
							</td>
						</tr>
					</table>
				</form>
				<center><br><br>
					<?PHP echo $msg; ?>
					<a href='index.php' style='color: #c1272d'><--Back</a>
				</center>
				
			</div>
		</div>
		
		<div class="copyright">&nbsp © INCNET</div>
	</body>
</HTML>









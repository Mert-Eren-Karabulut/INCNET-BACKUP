<?PHP
	error_reporting(0);
	
	//connect to mysql server
	include ("../db_connect.php");
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
	$page_id = "150";
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:../incnet/login.php");
	}
	$user_id = $_SESSION['user_id'];
	
	$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='$page_id'");
	while($permit_row = mysql_fetch_array($permit_query)){
		$allowance = "1";
	}
	if ($allowance != "1"){
		header ("location:../incnet/login.php");
	}


?>

<!doctype html>
<HTML>
	<head>
		<link rel="shortcut icon" href="../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<link rel="stylesheet" href="chosen.css">
		
		<script type="text/javascript" src="webcam.js"></script>
		<script language="JavaScript">
		//webcam.configure( 'camera' );
		webcam.set_api_url( 'save.php' );
		webcam.set_quality( 100 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( false ); // don't play shutter click sound
		</script>


	</head>
	
	<body>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='../incnet'><img src='../incnet/incnet.png' width='140px' border='none'></a>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<script language="JavaScript">
	      	  document.write( webcam.get_html(480, 360) );
					</script>
						<form>
							<input type=button value="Configure..." onClick="webcam.configure()">
						</form>
						<form action='take.php'>
							<input type='submit' value='<-- Back'>
						</form>
				</td>
			</tr>
			<tr>
				<td style='height:40px'>
				</td>
			</tr>
		</table>
		<div class="copyright">&nbsp © INÇNET</div>
	</body>
</HTML>


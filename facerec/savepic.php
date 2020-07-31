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
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:../incnet/login.php");
	}
	$user_id = $_SESSION['user_id'];
		
	if (isset($_POST['save'])){
		
		$query = mysql_query("SELECT name, lastname FROM incnet.coreusers WHERE user_id='$user_id'");
		//echo $query;
		while($row = mysql_fetch_array($query)){
			$photoUser = $row[0] . " " . $row[1];
		}

		$oldname = "uploads/" . $user_id . "-upload.jpg";
		$newname = "uploads/" . $photoUser . ".jpg";
		rename("$oldname", "$newname");
		
		$original = imagecreatefromjpeg("$newname") or die("$newname Error Opening original");
		$tempImg = imagecreatetruecolor(600, 400) or die("Cant create temp image");
		imagecopy($tempImg, $original, 0, 0, 0, 0, 600, 400) or die("Cant resize copy");

		// Save the image.
		imagejpeg($tempImg, "$newname", 100) or die("Cant save image");
		$realFile = "uploads/" . $photoUser . ".jpg";
		$copyFile = "uploadsBackup/" . $photoUser . ".jpg";
		copy ($realFile,$copyFile);
		// Clean up.
		imagedestroy($original);
		imagedestroy($tempImg);


	}
	

?>

<!doctype html>
<HTML>
	<head>
		<link rel="shortcut icon" href="../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		
		<script type="text/javascript" src="webcam.js"></script>
			<script language="JavaScript">
			//webcam.configure( 'camera' );
			webcam.set_api_url( 'save.php' );
			webcam.set_quality( 100 ); // JPEG quality (1 - 100)
			webcam.set_shutter_sound( false ); // don't play shutter click sound
		</script>
		
		<script>

			function superSnap(){
					elm = document.getElementById("savebutton");
					elm.style.display="inline";
					ele = document.getElementById("tryAgain");
					ele.style.display="inline";
					webcam.snap();
					
				}
				
		</script>
	</head>
	
	<body>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='../incnet'><img src='icon.png' width='140px' border='none'></a>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<b>This page is best viewed with Firefox. It doesn't work with other browsers.</b>
					<div style='position:absolute; left:790px; width:500px; top:60px; z-index:2'>
						<form method='POST'>
							<input type=button value="Take Photo" onClick="superSnap()">
							<input type=button value="Try again" id="tryAgain" style='display:none' onClick="location.reload();"><br><br>
							<input type='submit' name='save' value='save' id='savebutton' style='display:none'>
						</form><br><br>

					</div>
					<div style='position:absolute; top:60px; width:480px; left:180px; height:360px; z-index:1'>
						<script language="JavaScript">
		      	  document.write( webcam.get_html( 600, 400) );
						</script>
						<!--<img src='oval.png' style='position:absolute; z-index:2; width:160px; left:260px; top:30px'>
						-->
					</div>
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


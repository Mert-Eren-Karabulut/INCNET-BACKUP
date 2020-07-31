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

	
	if (isset($_POST['save'])){
		$photoUser = $_POST['photoUser'];
		
		$query = mysql_query("SELECT name, lastname, class FROM incnet.coreUsers WHERE user_id='$photoUser'");
		//echo $query;
		while($row = mysql_fetch_array($query)){
			$photoUser = $row[0] . " " . $row[1];
			$class = $row[2];
		}

		$oldname = "uploads/" . $user_id . "-upload.jpg";
		$newname = "uploads/$class/" . $photoUser . ".jpg";
		rename("$oldname", "$newname");
		
		$original = imagecreatefromjpeg("$newname") or die("Error Opening original");
		$tempImg = imagecreatetruecolor(240, 360) or die("Cant create temp image");
		imagecopy($tempImg, $original, 0, 0, 0, 0, 240, 360) or die("Cant resize copy");

		// Save the image.
		imagejpeg($tempImg, "$newname", 100) or die("Cant save image");
		$realFile = "uploads/$class/" . $photoUser . ".jpg";
		$copyFile = "uploadsBackup/$class/" . $photoUser . ".jpg";
		copy ($realFile,$copyFile);
		// Clean up.
		imagedestroy($original);
		imagedestroy($tempImg);


	}
	
	
	$query = mysql_query("SELECT user_id, name, lastname, class FROM incnet.coreUsers WHERE type='student'");
	//echo $query;
	while($row = mysql_fetch_array($query)){
		$user = $row[0];
		$name = $row[1];
		$lastname = $row[2];
		$class = $row[3];
		$studentRow = $studentRow . "
								<option value='$user' style='color:green'>$name $lastname (class: $class) </option>";
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
		
		<script>
			function show(){
					ele = document.getElementById("savebutton");
					ele.style.display="inline";
				}
			function superSnap(){
					ele = document.getElementById("tryAgain");
					ele.style.display="inline";
					ele = document.getElementById("selector");
					ele.style.visibility='visible';
					webcam.snap();
				}
			
			function showHelp(){
					ele = document.getElementById("pic");
					if (ele.style.display=="inline"){
						ele.style.display="none";
					}else{
						ele.style.display="inline";
					}
				}
		</script>
	</head>
	
	<body>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='../incnet'><img src='../incnet/incnet.png' width='140px' border='none'></a>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<b>This page is best viewed with Firefox. It doesn't work with other browsers.</b>
					<div style='position:absolute; left:460px; width:500px; top:60px; z-index:2'>
						<form method='POST'>
							<input type=button value="Take Photo" onClick="superSnap()">
							<input type=button value="Try again" id="tryAgain" style='display:none' onClick="location.reload();"><br><br>
							<div id='selector' style='visibility:hidden'>
								<select name='photoUser' data-placeholder="Select student..." class="chosen-select" style="width:350px;" tabindex="2" onChange="show()">
									<option value=""></option><?PHP echo $studentRow; ?>
								</select>
							</div>
							
							<input type='submit' name='save' value='save' id='savebutton' style='display:none'>
						</form><br><br>
						<form action='settings.php'>
							<input type='submit' value='settings...'>&nbsp&nbsp
							<input type='button' value='Help!' onClick='showHelp();'><br>
							<img src="guide.png" style='border:1px solid black; display:none;' width='600px' id='pic'>
						</form>
					</div>
					<div style='position:absolute; top:60px; width:480px; left:180px; height:360px; z-index:1'>
						<script language="JavaScript">
		      	  document.write( webcam.get_html( 480, 360) );
						</script>
						<img src='oval.png' style='position:absolute; z-index:2; width:160px; left:40px; top:30px'>
						<div style='position:absolute; top:0px; width:240px; right:0px; height:360px; z-index:2; background-color:white;'>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td style='height:40px'>
				</td>
			</tr>
		</table>
			<script src="jquery_min.js" type="text/javascript"></script>
		  <script src="chosen.jquery.js" type="text/javascript"></script>
		  <script type="text/javascript">
		    var config = {
		      '.chosen-select'           : {},
		      '.chosen-select-no-single' : {disable_search_threshold:10},
		      '.chosen-select-no-results': {no_results_text:'No records found!'},
		      '.chosen-select-width'     : {width:"95%"}
		    }
		    for (var selector in config) {
		      $(selector).chosen(config[selector]);
		    }
		  </script>
		<div class="copyright">&nbsp © INÇNET</div>
	</body>
</HTML>


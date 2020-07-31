<?PHP
	error_reporting(0);
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
					webcam.snap();
					alert("April Fool's Day!");
					window.location = "../incnet/login.php?rec=1";
				}
				
		</script>
	</head>
	
	<body style="background-color:#c1272d; font-family:lucida grande,tahoma,verdana,arial,sans-serif; font-size: 14px;">
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; padding:7px; padding-top:15px;' valign='top'>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<div style='position:absolute; left:200%; width:600px'><a href='../incnet'><img src='incnet.png' width='140px' border='none'></a>
					<br><b>This page is best viewed with Firefox. It doesn't work with other browsers.</b></div>
					<div style='position:absolute; left:350%; width:500px; top:86%; z-index:2'>
						<form method='POST'>
							<input type=button value="Log in" onClick="superSnap()">
						</form><br><br>

					</div>
					<div style='position:absolute; top:25%; width:480px; left:200%; height:360px; z-index:1'>
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


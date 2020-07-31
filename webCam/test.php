<!doctyle html>
<HTML>
	<script type="text/javascript" src="webcam.js"></script>
	
	<script language="JavaScript">
		//webcam.configure( 'camera' );
		webcam.set_api_url( 'save.php' );
		webcam.set_quality( 100 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( false ); // don't play shutter click sound
	</script>
	
	
	<script language="JavaScript">
        document.write( webcam.get_html(480, 360) );
	</script>
	
	<form method='POST'>
		<input type=button value="Configure..." onClick="webcam.configure()">
		<input type=button value="Take Snapshot" onClick="webcam.snap()">
	</form>
</HTML>
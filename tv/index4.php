<?

//$bgcolor="#ADDFFF";

include ("db.php");
$sql1 = mysql_query("SELECT background FROM incnet.tv");
while($row1 = mysql_fetch_array($sql1)){
	$background_url = $row1['value'];
}

?>




<html>
<head>
<title>INÇNET | TV</title>
<meta charset="utf-8">
<meta http-equiv="refresh" content="900" >
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
<link rel="shortcut icon" href="favicon.ico" /> 

</head>	
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"  scrolling="no" style = "overflow:hidden;">
<a href="http://www.accuweather.com/en/tr/gebze/318720/weather-forecast/318720" class="aw-widget-legal">
</a><div id="awcc1402299472194" class="aw-widget-current"  data-locationkey="318720" data-unit="c" data-language="en-us" data-useip="false" data-uid="awcc1402299472194"></div><script type="text/javascript" src="http://oap.accuweather.com/launch.js"></script>


</body>
</html>

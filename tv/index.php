<?

//$bgcolor="#ADDFFF";

$redir = "";

if(isset($redir))
	if($redir != "")
		header("Location: $redir");

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
<style>
		  body { 
        background: url( background.jpg );
	background-size: 1605px 1029px;
	background-repeat:no-repeat;
	}

		table { 
	z-index:-1;
	}

/*	content browser {
 	margin-right: -14px !important;
 	overflow-y: scroll;
	overflow-x: hidden;
	}
*/
</style>
</head>	
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"  scrolling="no" style = "overflow:hidden;">

<!-- Snow effect-->
<!--<script type="text/javascript" src="snowstorm.js"></script>
<script>

    	snowStorm.flakesMaxActive = 500;    // show more…
		
</script> -->
<!-- Snow effect - end-->

<table id="Table_01" width="1601" height="1025" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="15">
			<img src="1.png" width="1600" height="33" alt=""></td>
		<td>
			<img src="1.png" width="1" height="33" alt=""></td>
	</tr>
	<tr>
		<td rowspan="14">
			<img src="1.png" width="20" height="991" alt=""></td>
		<td rowspan="6">


<!--Haberturk-->
<iframe frameborder="0" scrolling="no" width="352" height="653" src="haberturk.php"></iframe>
<!--Haberturk-end-->

		</td>
		<td rowspan="14">
			<img src="1.png" width="20" height="991" alt=""></td>
		<td colspan="4" rowspan="3">

<!--BBC-Turkish-->
<iframe frameborder="0" scrolling=no width="330" height="440" src="bbc-cep.php"></iframe>
<!--BBC-Turkish-end-->

		</td>
		<td colspan="2" rowspan="2">
			<img src="1.png" width="54" height="211" alt=""></td>
		<td>
			

<!--Calender-->
<object type="application/x-shockwave-flash" height="187" width="187" data="http://en.enter-media.org/flash/calendar2.swf">
 <param name="movie" value="http://en.enter-media.org/flash/calendar2.swf" />
 <param name="wmode" value="transparent" />
 </object>
<!--Calender-end-->

		</td>
		<td rowspan="2">
			<img src="1.png" width="42" height="211" alt=""></td>
		<td colspan="3">
			

<!--Clock-->
<script src="http://www.clocklink.com/embed.js"></script><script type="text/javascript" language="JavaScript">obj=new Object;obj.clockfile="5012-black.swf";obj.TimeZone="Turkey_Istanbul";obj.width=568;obj.height=187;obj.wmode="transparent";showClock(obj);</script>
<!--Clock-end-->

		</td>
		<td rowspan="14">
			<img src="1.png" width="27" height="991" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="189" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="1.png" width="187" height="22" alt=""></td>
		<td colspan="3">
			<img src="1.png" width="568" height="22" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="22" alt=""></td>
	</tr>
	<tr>
		<td rowspan="3">
			<img src="1.png" width="19" height="253" alt=""></td>
		<td colspan="6" rowspan="2">

<!--History-->
<div div style="background-color:rgba(255,255,255,0.6); border-radius:10px;">
	<iframe frameborder="0" scrolling=no width="100%" height="233" src="history.php">
    </iframe>
</div>
<!--History-end-->


		</td>	
		<td>
			<img src="images/spacer.gif" width="1" height="229" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" rowspan="2">
			<img src="1.png" width="330" height="24" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="4" alt=""></td>
	</tr>
	<tr>
		<td colspan="6">
			<img src="1.png" width="832" height="20" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="20" alt=""></td>
	</tr>
	<tr>
		<td rowspan="3">

<!--Events-->
<div div style="background-color:rgba(255,255,255,0.6); border-radius:10px;  word-wrap: break-word;" width="300" height="230">
<iframe frameborder="0" width="300" height="230" scrolling=no src="checkin_connect.php"></iframe>
</div>
<!--Events-end-->


		</td>
		<td rowspan="9">
			<img src="1.png" width="13" height="527" alt=""></td>
		<td colspan="7" rowspan="6">
		</td>
		<td rowspan="7">
			<img src="1.png" width="14" height="403" alt=""></td>
		<td rowspan="5">

<!--Admin2--> 
<div style="background-color:rgba(255,255,255,0.6); border-radius:10px;  word-wrap: break-word;">
<iframe frameborder="0" width="343" height="381" scrolling="no" src="admin2.php"></iframe>
</div>
<!--Admin2-end-->


		</td>
		<td>
			<img src="images/spacer.gif" width="1" height="190" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="1.png" width="352" height="13" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="13" alt=""></td>
	</tr>
	<tr>
		<td rowspan="6">

<!--CNN-->
<iframe frameborder="0" width="352" height="293" scrolling="no"  src="cnn.php"></iframe>
<!--CNN-end-->

		</td>
		<td>
			<img src="images/spacer.gif" width="1" height="27" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="1.png" width="300" height="16" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="16" alt=""></td>
	</tr>
	<tr>
		<td rowspan="4">

<!--Weather-->
<iframe frameborder="0" scrolling="no" width="300" height="250" src="weather.php"></iframe>
<!--Weather-end-->

		</td>
		<td>
			<img src="images/spacer.gif" width="1" height="135" alt=""></td>
	</tr>
	<tr>
		<td rowspan="2">
			<img src="1.png" width="344" height="22" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="6" alt=""></td>
	</tr>
	<tr>
		<td colspan="7">
			<img src="1.png" width="510" height="16" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="1" height="16" alt=""></td>
	</tr>
	<tr>
		<td rowspan="2">
			<img src="1.png" width="3" height="124" alt=""></td>
		<td colspan="8">

<!--Stocks-->
<iframe frameborder="0" scrolling="no" width="863" height="69" src="stocks.php"></iframe>
<!--Stocks-end-->

			</td>
		<td>
			<img src="images/spacer.gif" width="1" height="93" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="1.png" width="352" height="31" alt=""></td>
		<td>
			<img src="1.png" width="300" height="31" alt=""></td>
		<td colspan="8">
			<img src="1.png" width="865" height="31" alt=""></td>
		<td>
			<img src="1.png" width="1" height="31" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/spacer.gif" width="20" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="352" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="20" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="300" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="13" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="3" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="14" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="19" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="35" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="187" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="42" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="210" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="14" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="344" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="27" height="1" alt=""></td>
		<td></td>
	</tr>
</table>
</body>
</html>

<?

//$bgcolor="#ADDFFF";

/*include ("db.php");
$sql1 = mysql_query("SELECT background FROM incnet.tv");
while($row1 = mysql_fetch_array($sql1)){
	$background_url = $row1['value'];
}
*/
?>




<html>
<head>
<title>INCNET | Screen Saver</title>
<meta charset="utf-8">
<meta http-equiv="refresh" content="900" >
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
<link rel="shortcut icon" href="favicon.ico" /> 

<script type="text/javascript">
theimage = new Array();


// The dimensions of ALL the images should be the same or some of them may look stretched or reduced in Netscape 4.
// Format: theimage[...]=[image URL, link URL, name/description]
theimage[0]=["../upload/img0.jpg", "", ""];
theimage[1]=["../upload/img1.jpg", "", ""];
theimage[2]=["../upload/img2.jpg", "", ""];
theimage[3]=["../upload/img3.jpg", "", ""];
theimage[4]=["../upload/img4.jpg", "", ""];
theimage[5]=["../upload/img5.jpg", "", ""];
//theimage[6]=["img6.jpg", "", ""];
//theimage[7]=["img7.jpg", "", ""];
//theimage[8]=["img8.jpg", "", ""];
//theimage[9]=["img9.jpg", "", ""];
//theimage[10]=["img10.jpg", "", ""];
//theimage[11]=["img11.jpg", "", ""];
//theimage[12]=["img12.jpg", "", ""];


///// Plugin variables

playspeed=10000;// The playspeed determines the delay for the "Play" button in ms
//#####
//key that holds where in the array currently are
i=0;


//###########################################
window.onload=function(){

	//preload images into browser
	preloadSlide();

	//set the first slide
	SetSlide(0);

	//autoplay
	PlaySlide();
}

//###########################################
function SetSlide(num) {
	//too big
	i=num%theimage.length;
	//too small
	if(i<0)i=theimage.length-1;

	//switch the image
	document.images.imgslide.src=theimage[i][0];

}


//###########################################
function PlaySlide() {
	if (!window.playing) {
		PlayingSlide(i+1);
		if(document.slideshow.play){
			document.slideshow.play.value="   Stop   ";
		}
	}
	else {
		playing=clearTimeout(playing);
		if(document.slideshow.play){
			document.slideshow.play.value="   Play   ";
		}
	}
	// if you have to change the image for the "playing" slide
	if(document.images.imgPlay){
		setTimeout('document.images.imgPlay.src="'+imgStop+'"',1);
		imgStop=document.images.imgPlay.src
	}
}


//###########################################
function PlayingSlide(num) {
	playing=setTimeout('PlayingSlide(i+1);SetSlide(i+1);', playspeed);
}


//###########################################
function preloadSlide() {
	for(k=0;k<theimage.length;k++) {
		theimage[k][0]=new Image().src=theimage[k][0];
	}
}


</script>

<style>
		  body { 
        background: url( background.jpg );
	background-size: 1155px 867px;
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

<table id="Table_01" width="1152" height="865" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="10">
			<img src="1.png" width="1152" height="7" alt=""></td>
	</tr>
	<tr>
		<td rowspan="6">
			<img src="1.png" width="15" height="857" alt=""></td>
		<td rowspan="3">
        
<!--Haberturk-->
<iframe frameborder="0" scrolling="no" width="352" height="589" src="http://www.haberturk.com/siteneekle/haber/manset/1#light,1"></iframe>
<!--Haberturk-end-->

        </td>
		<td rowspan="6">
			<img src="1.png" width="10" height="857" alt=""></td>
		<td colspan="2">
        
<!--Calender-->
<object type="application/x-shockwave-flash" height="187" width="187" data="http://en.enter-media.org/flash/calendar2.swf">
<param name="movie" value="http://en.enter-media.org/flash/calendar2.swf" />
<param name="wmode" value="transparent" />
</object>
<!--Calender-end-->
		
        </td>
		<td rowspan="2">
			<img src="1.png" width="7" height="202" alt=""></td>
		<td colspan="3">
        
<!--Clock-->
<script src="http://www.clocklink.com/embed.js"></script><script type="text/javascript" language="JavaScript">obj=new Object;obj.clockfile="5012-black.swf";obj.TimeZone="Turkey_Istanbul";obj.width=568;obj.height=187;obj.wmode="transparent";showClock(obj);</script>
<!--Clock-end-->

		</td>
		<td rowspan="6">
			<img src="1.png" width="13" height="857" alt=""></td>
	</tr>
	<tr>
		<td colspan="2">
			<img src="1.png" width="187" height="15" alt=""></td>
		<td colspan="3">
			<img src="1.png" width="568" height="15" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
        
<!--Admin2--> 
<div style="background-color:rgba(255,255,255,0.6); border-radius:10px;  word-wrap: break-word;">
<iframe frameborder="0" width="240" height="368" scrolling="no" src="admin2.php"></iframe>
</div>
<!--Admin2-end-->

		</td>
		<td rowspan="2">
			<img src="1.png" width="12" height="397" alt=""></td>
		<td>
        
<!--Bulten-->
<form name="slideshow" width="510" height="387" scrolling="no">

<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td align="center">
	<a href="#" onMouseOver="this.href=theimage[i][1];return false">
	<script type="text/javascript">
		document.write('<img name="imgslide" id="imgslide" src="'+theimage[0][0]+'" border="0">')
	</script>
	</a>
	</td>
</tr>
</table>

</form>
<!--Bulten-end-->
		
        </td>
	</tr>
	<tr>
		<td>
			<img src="1.png" width="352" height="10" alt=""></td>
		<td colspan="4">
			<img src="1.png" width="240" height="10" alt=""></td>
		<td>
			<img src="1.png" width="510" height="10" alt=""></td>
	</tr>
	<tr>
		<td>
        
<!--Events-->
<div div style="background-color:rgba(255,255,255,0.6); border-radius:10px;  word-wrap: break-word;" width="300" height="230">
<iframe frameborder="0" width="352" height="250" scrolling=no src="checkin_connect.php"></iframe>
</div>
<!--Events-end-->

		</td>
		<td rowspan="2">
			<img src="1.png" width="2" height="258" alt=""></td>
		<td colspan="5">
        
<!--History-->
<div div style="background-color:rgba(255,255,255,0.6); border-radius:10px; ">
	<iframe frameborder="0" scrolling=no width="100%" height="250" src="history.php">
    </iframe>
</div>
<!--History-end-->

	</td>
	</tr>
	<tr>
		<td>
			<img src="1.png" width="352" height="8" alt=""></td>
		<td colspan="5">
			<img src="1.png" width="760" height="8" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/spacer.gif" width="15" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="352" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="10" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="2" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="185" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="7" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="46" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="12" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="510" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="13" height="1" alt=""></td>
	</tr>
</table>
</body>
</html>
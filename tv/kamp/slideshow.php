					<!-- configurable script -->
<script type="text/javascript">
theimage = new Array();


// The dimensions of ALL the images should be the same or some of them may look stretched or reduced in Netscape 4.
// Format: theimage[...]=[image URL, link URL, name/description]
theimage[0]=["okul1.png", "", ""];
theimage[1]=["okul2.png", "", ""];
/*theimage[2]=["upload/Slide3.JPG", "", ""];
theimage[3]=["upload/Slide4.JPG", "", ""];
theimage[4]=["upload/Slide5.JPG", "", ""];
theimage[5]=["upload/Slide6.JPG", "", ""];
theimage[6]=["upload/Slide7.JPG", "", ""];
theimage[7]=["upload/Slide8.JPG", "", ""];
theimage[8]=["upload/Slide9.JPG", "", ""];
theimage[9]=["upload/Slide10.JPG", "", ""];
theimage[10]=["upload/Slide11.JPG", "", ""];
theimage[11]=["upload/Slide12.JPG", "", ""];
theimage[12]=["upload/Slide13.JPG", "", ""];
theimage[13]=["upload/Slide14.JPG", "", ""];
theimage[14]=["upload/Slide15.JPG", "", ""];
theimage[15]=["upload/Slide16.JPG", "", ""];
theimage[16]=["upload/Slide17.JPG", "", ""]; 
theimage[10]=["upload/Slide18.JPG", "", ""];
theimage[11]=["upload/Slide19.JPG", "", ""];
theimage[12]=["upload/Slide20.JPG", "", ""];
theimage[13]=["upload/Slide21.JPG", "", ""];
theimage[21]=["upload/Slide22.JPG", "", ""];
theimage[22]=["upload/Slide23.JPG", "", ""];*/



///// Plugin variables

playspeed=5000;// The playspeed determines the delay for the "Play" button in ms
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


<!-- slide show HTML -->
<form name="slideshow">

<table border="0" cellpadding="2" cellspacing="0">
<tr>
	<td align="center">
	<a href="#" onmouseover="this.href=theimage[i][1];return false">
	<script type="text/javascript">
		document.write('<img name="imgslide" id="imgslide" src="'+theimage[0][0]+'" border="0">')
	</script>
	</a>
	</td>
</tr>
</table>

</form>
<!-- end of slide show HTML -->

	</div>
	

					<!-- configurable script -->
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


<!-- slide show HTML -->
<form name="slideshow">

<table border="0" cellpadding="0" cellspacing="0">
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
	

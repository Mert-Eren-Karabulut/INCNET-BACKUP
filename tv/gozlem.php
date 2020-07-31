﻿<!DOCTYPE html>
<html>
<head>
	<title>INÇNET TV|Gözlem Kampı Sıpeşıl</title>
	<script type="text/javascript" src=suncalc-master/suncalc.js></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<style type="text/css">
		@font-face{
			font-family: digital-7;
			src: url('digital-7.ttf');
		}

		body{
			color:black;
			text-align: center;
			background-color: rgb(221, 127, 55);
			color: rgb(225, 177, 105);
		}
		
		.column{
			float: left;
			width: 48%;
		}
	</style>
</head>
<body>
	<h1 style="font-size:60pt;">Gözlem Kampı 2017 - Hoşgeldiniz</h1>
	
	<h1 id=clock style="font-family: digital-7; font-size:50pt;"></h1>
	
	<div class=column>
		<h1><label for=program style="text-align: center;">Günlük Program</label></h1><br/>
		<div style="width: 100%; float:left; text-align: center;" id=program>Lorem ipsum dolor sit amet</div>
	</div>
	<div class=column>
		<h1><label for=harita style="text-align: center;">Okul Haritası</label></h1><br/>
		<div style="width: 100%; float:left; text-align: center;" id=harita><img src=images/harita.png></div><br/>
	</div>
	
	<script type="text/javascript">
		var colours = [
			"red",
			"green",
			"blue",
			"purple",
			"yellow",
			"magenta",
			"black",
			"white",
			"orange",
			"pink",
			"grey",
			"brown",
			"red",
			"green",
			"blue",
			"purple",
			"yellow",
			"magenta",
			"black",
			"white",
			"orange",
			"pink",
			"grey",
			"brown"
		];
		var h1 = document.getElementById('clock');
		setInterval(function() {
			var d = new Date();
			var day = d.getDate();
			var month = d.getMonth() + 1;
			var year = d.getFullYear();
			var hour = (d.getHours().toString().length == 2) ? d.getHours() : "0" + d.getHours();
			var min = (d.getMinutes().toString().length == 2) ? d.getMinutes() : "0" + d.getMinutes();
			var second = (d.getSeconds().toString().length == 2) ? d.getSeconds() : "0" + d.getSeconds();
			h1.innerHTML = (day + "/" + month + "/" + year + "&nbsp;&nbsp;<span id=hour>" + hour + "</span>:<span id=minute>" + min + "</span>:<span id=second>" + second + "</span>");
			//$('#hour').css("color", colours[hour]);
			//if(((min%5) == 0) && (second == 00) && (d.getMilliseconds() < 10)) $('body').css("background-color", "rgb(" + Math.round(Math.random()*255) + ", " + + Math.round(Math.random()*255) + ", " + + Math.round(Math.random()*255) + ")");
			//if(((min%2) == 0) && (second == 00) && (d.getMilliseconds() < 10)) $('#minute').css("color", "black");
			//else if((second == 00) && (d.getMilliseconds() < 10)) $('body').css("color", "green");

			//if((min == 0) && (second == 00) && (d.getMilliseconds() < 10)) $('#hour').css("color", colours[(hour-1)]);
			
		}, 10);
	</script>
</body>
</html>
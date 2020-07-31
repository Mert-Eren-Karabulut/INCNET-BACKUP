var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari"
		},
		{
			prop: window.opera,
			identity: "Opera"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
BrowserDetect.init();
// alert(BrowserDetect.browser + ", " + BrowserDetect.version + ", " + BrowserDetect.OS);



// Browser Window Size and Position
// copyright Stephen Chapman, 3rd Jan 2005, 8th Dec 2005
// you may copy these functions but please keep the copyright notice as well

function pageWidth()
{
	return window.innerWidth != null? window.innerWidth : document.documentElement && document.documentElement.clientWidth ?       document.documentElement.clientWidth : document.body != null ? document.body.clientWidth : null;
}

function pageHeight() 
{
	return  window.innerHeight != null? window.innerHeight : document.documentElement && document.documentElement.clientHeight ?  document.documentElement.clientHeight : document.body != null? document.body.clientHeight : null;
}

function posLeft()
{
	return typeof window.pageXOffset != 'undefined' ? window.pageXOffset :document.documentElement && document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ? document.body.scrollLeft : 0;
}

function posTop()
{
	return typeof window.pageYOffset != 'undefined' ?  window.pageYOffset : document.documentElement && document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ? document.body.scrollTop : 0;
}

function posRight()
{
	return posLeft()+pageWidth();} function posBottom() {return posTop()+pageHeight();
}


var indefini;

var nd_dest = ( nd_dest == indefini ? "" : nd_dest ) ;
var nd_control = ( nd_control == indefini ? "" : nd_control ) ;
var nd_sound = ( nd_sound == indefini ? "" : nd_sound ) ;
var nd_vAlign = ( nd_vAlign == indefini ? "" : nd_vAlign ) ;
var nd_hAlign = ( nd_hAlign == indefini ? "" : nd_hAlign ) ;
var nd_hMargin = ( nd_hMargin == indefini ? "" : nd_hMargin ) ;
var nd_vMargin = ( nd_vMargin == indefini ? "" : nd_vMargin ) ;
var nd_target = ( nd_target == indefini ? "" : nd_target ) ;

nd_laVersion = "8" ;
var nd_movie = nd_mode ;

switch ( nd_mode )
{
	case "bomb":
		nd_movie = "meteor";
		break;
	case "blood":
	case "paint":
		nd_movie = "gun" ;
}

if ( (window.location+"").indexOf("file") == 0 )
{
	// tests offline
	// alert("Test offline nd_movie : " + nd_movie);
	var nd_myfla = '../fla/mynd.swf?mode=' + nd_mode + '&movie=' + nd_movie + '&destruction=' + nd_dest + '&control=' + nd_control + '&son=' + nd_sound + '&vAlign=' + nd_vAlign + '&hAlign=' + nd_hAlign +  '&hMargin=' + nd_hMargin + '&vMargin=' + nd_vMargin + '&linkTarget=' + nd_target + '&acces=../fla/' ;
}
else
{
	// version online
	var nd_myfla = 'http://www.netdisaster.com/fla/mynd.swf?mode=' + nd_mode + '&movie=' + nd_movie + '&destruction=' + nd_dest + '&control=' + nd_control + '&son=' + nd_sound + '&vAlign=' + nd_vAlign + '&hAlign=' + nd_hAlign +  '&hMargin=' + nd_hMargin + '&vMargin=' + nd_vMargin + '&linkTarget=' + nd_target + '&acces=http://www.netdisaster.com/fla/' ;
}
// alert(nd_myfla);

var nd_anim = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version='+nd_laVersion+'" width="100%" height="100%" id="mySwf">'
+ '<param name="movie" value="' + nd_myfla + '">'
+ '<param name="menu" value="false"><param name="allowScriptAccess" value="always">'
+ '<param name="quality" value="high"><param name="wmode" value="transparent">'
+ '<embed src="' + nd_myfla +'" quality=high wmode=transparent allowScriptAccess=always pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="100%" height="100%" id="mySwf" menu="false">'
+ '</embed></object>' ;

function screen()
{
	document.getElementById("nd_myAnim").style.top = posTop();
}

// alert(BrowserDetect.browser);
// if ( ( BrowserDetect.browser == "Explorer" || BrowserDetect.browser == "Mozilla" ) && BrowserDetect.OS != "Linux" )
//{
//	document.write(nd_anim); // insertion ancienne façon
	myBody = document.getElementsByTagName("body")[0] ;
	myBody.onload = mkAnim() ;
//}

function mkAnim()
{
	// alert("mkAnim");
	div = document.createElement("DIV");
	div.setAttribute("id", "nd_myAnim");
	myBody.appendChild(div);

	div.style.position = "absolute" ;
	div.style.top = "0px" ;
	div.style.left = "0px" ;
	div.style.height = "100%" ;
	div.style.width = "100%" ;
	div.style.zIndex = "100" ;
	div.innerHTML = nd_anim ;
//	div.style.border = "solid green 10px" ;

	window.onscroll = screen ;
}

function nd_removeDisaster()
{
	document.getElementById("nd_myAnim").style.display = "none" ;
}

// document.getElementById("nd_myAnim").style.border = "solid green 10px" ;

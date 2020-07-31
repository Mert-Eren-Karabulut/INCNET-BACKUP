<?PHP
	error_reporting(0);

require_once '../mobile_detect/Mobile_Detect.php';
$detect = new Mobile_Detect;
if (!($detect->isMobile())){
	header("location:../../incnet/bulletin.php");
} 

session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:login.php");
}
$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];


include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}

?>

<HTML>
<head>
<title>INCNET Mobile | Bulletin</title>
<link rel="shortcut icon" href="favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="incnet.css" type="text/css" media="screen" title="no title" charset="utf-8">
</head>
<style>
body {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	font-size: 14px;
}


form { margin: 0; }  




input {
	-webkit-appearance: none;
	color:white;
	background:#c1272d ;
	width:94%;
	left:3%;
	height:140px; 
	font-size: 35pt;
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	text-shadow:5px 5px 7px black;
	box-shadow:6px 6px 5px black;
	border:1;
	position:relative;
	margin-top:15px;
	margin-bottom:15px;
}
.mobileimage{
	position:relative;
	display:block;
	margin-left: auto;
	margin-right: auto;
	margin-top:130px;
	height:500px;
}

.header {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	z-index:1;
	font-size:38pt;
	position: fixed;
	width: 100%;
	padding-bottom:14px;
	padding-top:14px;
	color: white;
	left: 0px;
	background-color: #c1272d;
	top: 0px;
	text-align:right;
	text-decoration:none;
}




.mobilepart{
	width:100%;height:90%
}

#bottomButton{
	top:220px;
	margin-bottom:100px;
	color:white;
}


.taplogoff{
	color:white;
	opacity:0.5;
	text-align:left;
	position:absolute;
}

.horiz-line{
	width: 100%;
	height: 0px;
	border: 1pt solid grey;
}
</style>	
<body>
		<a href='logoff.php'>
			<div class="header"><div class='taplogoff'>&nbsp; Tap to log off</div>
				<? echo $fullname; ?> 	&nbsp;	
			</div>	
		</a>
	<a href='index.php'> <img src='../../incnet/incnet.png' class='mobileimage' > </a>
	<iframe src="../incnet/bulletin/1.pdf" width="1000" height="2400" frameborder="0" scrolling="yes" class='mobileimage'></iframe>				


</div>

</body>
</HTML>










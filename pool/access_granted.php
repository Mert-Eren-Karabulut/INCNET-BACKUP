<?PHP
	error_reporting(0);

session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}

?>
<HTML>
<head>
<!--<title>In?net | Pool Reservations<title>-->
<link rel="shortcut icon" href="favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="incnet.css" type="text/css" media="screen" title="no title" charset="utf-8">
<body OnLoad="document.barcode_form.barcode.select();">
<meta http-equiv="REFRESH" content="2;url=realtime_tracker.php">
</head>
<body style='background-color:green; color:white'>
<center>

<div style='font-size:40'><br><br><b>Access Granted!</b></div><br>
<h1>Welcome to the pool!</h1>

</center>
</body>

</HTML>

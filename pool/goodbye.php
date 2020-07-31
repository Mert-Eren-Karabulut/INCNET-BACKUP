<?PHP
	error_reporting(0);

session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}
$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];

if (isset($_POST['logoff'])){
	session_destroy();
	header("location:../incnet/login.php");	
}

include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}

$permit_query = mysql_query("SELECT * FROM core.poolPermits WHERE user_id='$user_id' AND page_id='602'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}

if ($allowance != "1"){
	header ("location:../../incnet/login.php");
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
<body style='background-color:1B91E0; color:white'>
<center>

<div style='font-size:40'><br><br><b>Goodbye!</b></div><br>
<h1>Thank you for using Incnet.</h1>

</center>
</body>

</HTML>

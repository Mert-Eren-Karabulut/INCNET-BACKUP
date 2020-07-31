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

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='602'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}

if ($allowance != "1"){
	header ("location:../../incnet/login.php");
}

//get the currrent date&&time
$today=date(N);
$current_hour=date("H");
$current_minute=date("i");
$current_time = date("H:i");
$current_time = $current_time . ":00";
$date = date("Y-m-d");

//echo $today;
//echo $current_time;
//Get info about upcoming slots
$sql2 = mysql_query("SELECT * FROM incnet.coreSlots WHERE day='$today' ORDER BY time_start");
while($row2 = mysql_fetch_array($sql2)){
	$slot_id = $row2['slot_id'];
}


if (isset($_POST['submit'])){
	$student_no = $_POST['barcode'];
$access="0";//0-no reservation.    1-reservation, coming in.    2-reservation, leaving
	//Get user id using school number
	$sql1 = mysql_query("SELECT * FROM incnet.coreUsers WHERE student_id='$student_no'");
	while($row1 = mysql_fetch_array($sql1)){
		$this_user_id = $row1['user_id'];
	}
	//		echo $this_user_id;
	$sql3 = mysql_query("SELECT * FROM incnet.poolRecords WHERE slot_id='$slot_id' AND user_id='$this_user_id'");
	while($row3 = mysql_fetch_array($sql3)){
		$access="1";
		$sql4 = mysql_query("SELECT * FROM incnet.poolRealtime WHERE user_id='$this_user_id'");
		while($row4 = mysql_fetch_array($sql4)){
			$access="2";
		}
	}

	if($access=="1"){//coming
		mysql_query("INSERT INTO incnet.poolRealtime (user_id, slot_id, date, time) VALUES ('$this_user_id','$slot_id','$date','$current_time')");
		mysql_query("INSERT INTO incnet.poolLog (user_id, slot_id, date, time, direction) VALUES ('$this_user_id','$slot_id','$date','$current_time', 'in')");
		header("location:access_granted.php");
	}else if ($access=="2") {//leaving
		mysql_query("DELETE FROM incnet.poolRealtime WHERE user_id='$this_user_id'");
		mysql_query("INSERT INTO incnet.poolLog (user_id, slot_id, date, time, direction) VALUES ('$this_user_id','$slot_id','$date','$current_time', 'out')");
		header("location:goodbye.php");
	}else{//access denied
		header("location:access_denied.php");
	}

}

?>

<HTML>
<head>
<!--<title>In?net | Pool Reservations<title>-->
<link rel="shortcut icon" href="favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="incnet.css" type="text/css" media="screen" title="no title" charset="utf-8">
<meta http-equiv="REFRESH" content="600;url=realtime_tracker.php">
</head>
<body>
<body OnLoad="document.barcode_form.barcode.select();">
	<div class="top_menubar">
	</div>
<br><br><br>
	<div style="margin-left: auto; margin-right: auto; width: 500;">
	<center>
	<br>
		<div class='largetext_red'>
			Lütfen Kartınızı Okutun
		</div>
		<div class='largetext'>
			Please Scan Your Card
		</div><br>
		<form name='barcode_form' method='POST' autocomplete='off'>
			<input type='text' size='3' name='barcode' style='font-size:30'><input type='submit' name='submit' value='Go' style='font-size:30; color:green; font-weight:bold'>
		</form>
	</center>
	</div>
	
	<div class="logoff_button">
	<form name="logoff" method="POST">
	<input type ="submit" name="logoff" value="Log Off">
	</form>
	</div>


<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2012 Levent Erol</a>
</div>
</body>
</HTML>

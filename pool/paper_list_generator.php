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






?>
<HTML>
<head>
<!--<title>In?net | Pool Reservations<title>-->
	<link rel="shortcut icon" href="favicon.ico" >
	<meta charset="UTF-8">
	<link rel="stylesheet" href="incnet.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<body OnLoad="document.slot_select.list_slot.focus();">

</head>
	<div class="top_menubar">
	<?PHP echo $fullname; ?>
	</div>
<br>
<br>
<br>
<a style='color:c1272d; font-weight: bold; text-decoration:none; font-size:12' href='index.php'> [Back] </a>
<h3>Please select a slot:<br></h3>
<form method='POST' name='slot_select' action='paper_list.php'>

<select name='list_slot'>

<?PHP

$sql1 = mysql_query("SELECT * FROM incnet.poolSlots ORDER BY day,time_start");
while($row1 = mysql_fetch_array($sql1)){
	$slot_id = $row1['slot_id'];
	$time_start = $row1['time_start'];
	$time_end = $row1['time_end'];
	$target = $row1['target'];
	$day = $row1['day'];
	if($day == "1"){
		$day="Monday";
	}else if($day == "2"){
		$day="Tuesday";
	}else if($day == "3"){
		$day="Wednesday";
	}else if($day == "4"){
		$day="Thursday";
	}else if($day == "5"){
		$day="Friday";
	}else if($day == "6"){
		$day="Saturday";
	}else if($day == "7"){
		$day="Sunday";
	}

	echo "<option value='" . $slot_id . "'>" . $day . ": " . $time_start . "-" . $time_end . " for " . $target . "</option>";
}

?>

	</select>
	<input type='submit' name='submit' value='Go'>
	</form>
</HTML>

<?PHP
	error_reporting(0);

$lang = "EN";

session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:login.php");
}
$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];

if (isset($_POST['logoff'])){
	session_destroy();
	header("location:login.php");	
}

include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}

//permissions  
session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:login.php");
}
$user_id = $_SESSION['user_id'];

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='601'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}

if ($allowance != "1"){
	header ("location:../../incnet/login.php");
}


if (isset($_POST['remove_slot'])){
	echo "hello";
	$removeslot = $_POST['removeslot'];
	$sql_query = "DELETE FROM incnet.poolSlots WHERE slot_id = '$removeslot'";
//	echo  $sql_query;
	mysql_query($sql_query);
//	header("location:index.php");
}
?>

<HTML>
<head>
<!--<title>In?net | Pool Reservations<title>-->
<link rel="shortcut icon" href="../../incnet/favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="incnet.css" type="text/css" media="screen" title="no title" charset="utf-8">
</head>
	<div class="top_menubar">
	<?PHP echo $fullname; ?>
	</div>
<br><br>
<div class="page_logo_container">
<table><tr>
<td><a href="index.php"><img src="../../incnet/incnet.png" width="120" border=0/></a><br>


</td>
<td width="3"></td>
<td bgcolor="black" width=0.1px>
<td width="3"></td>
<td valign="middle">
<br>
<b>Delete Slot</b>
<form method="POST">
			Select slot to remove:
			<select name='removeslot'>
			<?PHP

			$sql1 = mysql_query("SELECT * FROM incnet.poolSlots ORDER BY day");
			while($row1 = mysql_fetch_array($sql1)){
				$slot_id = $row1['slot_id'];
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
				
				$time_start = $row1['time_start'];
				$time_end = $row1['time_end'];
				$target = $row1['target']; 
				if($target == "swimmers"){
					$target="Swimmers";
				}else if($target == "nonswimmers"){
					$target="Non-Swimmers";
				}
				echo "<option value='" . $slot_id . "'>" . $day . " (" . $time_start . "-" . $time_end . ") for " . $target . "</option>";
			}

			?>		
			</select>
			<input type="submit" name="remove_slot" value="Remove Slot">
</form>
<br><br>
</td>
</tr></table>
<div>
<br><br><br>
<div class="logoff_button">
<form name="logoff" method="POST">
<?PHP if ($lang == "EN") {$logoff_string="Log Off";} else if ($lang == "TR") {$logoff_string="Çıkış Yap"; } ?>
<input type ="submit" name="logoff" value="<? echo $logoff_string; ?>">
</form>
</div>


<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2012 Levent Erol</a>
</div>
</HTML>

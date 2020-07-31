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

$today=date(N);




?>
<HTML>
<head>
<!--<title>In?net | Pool Reservations<title>-->
<link rel="shortcut icon" href="favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="incnet.css" type="text/css" media="screen" title="no title" charset="utf-8">
</head>
	<div class="top_menubar">
	<?PHP echo $fullname; ?>
	</div>
<br><br>
<?PHP

	$this_slot_id = $_POST['list_slot'];
	
	//echo "here" . $this_slot_id;
	
$sql1 = mysql_query("SELECT * FROM incnet.poolSlots WHERE slot_id='$this_slot_id' ORDER BY day,time_start");
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
}	
echo "<div style='margin-left: auto; margin-right: auto; width: 500; border-left:1px solid black; border-right:1px solid black;' style= 'font-size:11'>";
	echo "<b>Day:</b> " . $day . " <b>Starts:</b> " . $time_start . " <b>Ends:</b>" . $time_end . " <b>For:</b>" . $target;
	$sql2 = mysql_query("SELECT user_id FROM incnet.poolRecords WHERE slot_id='$this_slot_id' ORDER BY record_id");//get all users of that slot
	while($row2 = mysql_fetch_array($sql2)){
		$this_user_id = $row2['user_id'];

		$sql3 = mysql_query("SELECT name,lastname,username FROM incnet.coreUsers WHERE user_id='$this_user_id'");//get info of  
		while($row3 = mysql_fetch_array($sql3)){
			$users_fullnames[] = $row3['name'] . " " . $row3['lastname'];
			$users_usernames[] = $row3['username'];
			//echo $this_user_fullname . "-" . $this_user_username . "<br>";
		}


	}
echo "
<table width=500 border=0>
<tr>
<td><a style='color:c1272d; font-weight: bold; text-decoration:none; font-size:12' href='paper_list_generator.php'> [Back] </a></td>
<td style='text-align: right;'><a style='color:c1272d; font-weight: bold; font-size:12; text-decoration:none' href='javascript:window.print()'>[Print this Page]</A></td>

</tr>
</table>
";
		echo "<table border='0' style= 'font-size:12'>";
		$swimmers_count = count($users_usernames);
		//echo $swimmers_count;
		$i = 0;
		while($i<$swimmers_count){
			echo "<tr>";
				echo "<td><center>";
					echo "<img src='../student_photos/" . $users_usernames[$i] . ".jpg' alt='' width=110><br>";
					echo $users_fullnames[$i];
				echo "<br></center></td>";
				$i++;
				echo "<td><center>";
					echo "<img src='../student_photos/" . $users_usernames[$i] . ".jpg' alt='' width=110><br>";
					echo $users_fullnames[$i];
				echo "<br></center></td>";
				$i++;
				echo "<td><center>";
					echo "<img src='../student_photos/" . $users_usernames[$i] . ".jpg' alt='' width=110><br>";
					echo $users_fullnames[$i];
				echo "<br></center></td>";
				$i++;
				echo "<td><center>";
					echo "<img src='../student_photos/" . $users_usernames[$i] . ".jpg' alt='' width=110><br>";
					echo $users_fullnames[$i];
				echo "<br></center></td>";
				$i++;

				echo "</tr>";
		}
		
		echo "</table>";	



echo "</div>";

?>

</HTML>

<?PHP

	
error_reporting(0);



require_once '../mobile_detect/Mobile_Detect.php';
$detect = new Mobile_Detect;
if ( $detect->isMobile() ) {
  echo	"<meta http-equiv='refresh' content='0; url=../mobile/pool.php'>"; 
}

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

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}

if (isset($_POST['join_slot'])){
	$joinslot_id = $_POST['slot_id'];
	$date = date('Y-m-d');
	$sql3 = "INSERT into incnet.poolRecords (user_id, slot_id, date) VALUES ('$user_id','$joinslot_id','$date')";
	mysql_query($sql3);
}

if (isset($_POST['leave_slot'])){
	$dropslot_id = $_POST['slot_id'];
	$sql3 = "DELETE from incnet.poolRecords WHERE user_id='$user_id' AND slot_id='$dropslot_id'";
	mysql_query($sql3);
}

$sql2 = mysql_query("SELECT * FROM incnet.poolRecords WHERE user_id='$user_id'");
while($row2 = mysql_fetch_array($sql2)){
	$user_reservations[] = $row2['slot_id'];
}


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
<div class="page_logo_container">
<table><tr>
<td valign='top'><a href="../incnet"><img src="../img/pool.png" width="120" border=0/></a><br>


</td>
<td width="3"></td>
<td bgcolor="black" width=0.1px>
<td width="3"></td>
<td valign="middle">
<h3>Pool Reservations Page</h3>


<?PHP

//get the max# of slots per person
$sql4 = mysql_query("SELECT * FROM incnet.poolVars");
while($row4 = mysql_fetch_array($sql4)){
	$vars[] = $row4['value'];
}
$maxquota = $vars[0];
$maxperweek = $vars[1];
$teacher_maxperweek = $vars[5];
$openclose_state = $vars[4];
if (in_array("601", $allowed_pages)) {
echo "<a style='color:black' href='add_slot.php'>Add Slot</a><br>";
echo "<a style='color:black' href='remove_slot.php'>Remove Slot</a><br>";
echo "<a style='color:black' href='studentlist.php'>Edit Student Information</a><br>";
echo "<a style='color:black' href='settings.php'>Universal Settings</a><br>";
}
if (in_array("602", $allowed_pages)) {
echo "<a style='color:black' href='paper_list_generator.php'>Printable lists</a><br>";
}
echo "<br>";

echo "<b>Please reserve before using the pool:</b>";

//get the currrent date&&time
$today=date(N);
$current_hour=date("H");
$current_minute=date("i");

//echo $current_hour;
//echo "today is: " . $today;


//time before list is closed
$sql6 = mysql_query("SELECT * FROM incnet.poolVars WHERE var_id='3'");
while($row6 = mysql_fetch_array($sql6)){
	$hrs_to_res = $row6['value'];
}



echo "<form method='POST'>";

//is this user a swimmer?
$sql5 = mysql_query("SELECT * FROM incnet.poolNon_swimmers WHERE user_id='$user_id'");
while($row5 = mysql_fetch_array($sql5)){
	$swimfact = $row5['user_id'];
}

//is this user banned
$sql8 = mysql_query("SELECT * FROM incnet.poolBanned WHERE user_id='$user_id'");
while($row8 = mysql_fetch_array($sql8)){
	$user_ban = "1"; //user not allowed to use the pool
}


$type_query = mysql_query("SELECT student_id, type FROM incnet.coreUsers WHERE user_id='$user_id'");
while($type_row = mysql_fetch_array($type_query)){
	$student_id = $type_row['student_id'];
	$user_type = $type_row['type'];
}


if ($user_ban=="1"){
	echo "<div class='largetext_red'>You're not allowed to use the pool.<br>Please contact a teacher.</div>";
} else if($openclose_state=="closed"){
	echo "<div class='largetext_red'>The pool is currently closed.<br>Please contact the administration.</div>";
}else{

	//determine if student, personnel, teacher, etc
	if ($user_type=='student'){

		if ($swimfact==$user_id){//not a swimmer
			$sql1 = mysql_query("SELECT * FROM incnet.poolSlots WHERE target='nonswimmers' ORDER BY day, time_start");
		}else{//swimmer
			$sql1 = mysql_query("SELECT * FROM incnet.poolSlots WHERE target='swimmers' ORDER BY day, time_start");
		}

	}else if ($user_type=='teacher'){
		$sql1 = mysql_query("SELECT * FROM incnet.poolSlots WHERE target='teacher' ORDER BY day, time_start");
		$maxperweek = $teacher_maxperweek;
	}else if ($user_type=='personnel'){
		$sql1 = mysql_query("SELECT * FROM incnet.poolSlots WHERE target='personnel' ORDER BY day, time_start");
		$maxperweek = $teacher_maxperweek;
	}else{
		die("Fatal error. Please contact an administrator.<br>user_type_error #19980504");
	}


while($row1 = mysql_fetch_array($sql1)){
	$slot_id = $row1['slot_id'];
	$day = $row1['day'];
	$daynum = $day;
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
	
	
	//checking for the last time to reserve
	$start_time = explode(":", $time_start);
	$start_minute = $start_time[1];
	$start_hour = $start_time[0];

	$lastres_hour = $start_hour-$hrs_to_res;
//	echo $lastres_hour;
//	echo $start_hour;

$joinsum = count($user_reservations);

//	Check slot fill
$sql7 = mysql_query("SELECT COUNT(*) FROM incnet.poolRecords WHERE slot_id='$slot_id'");
while($row7 = mysql_fetch_array($sql7)){
	$slot_fill = $row7['COUNT(*)'];
}
//echo $slot_fill;
//echo $slot_id;

$button_value= $day . '
(' . $time_start . "-" . $time_end . ")";
//echo "joinsum" . $joinsum . "<br>";
//echo "maxperweek" . $maxperweek;
//echo $daynum;
	if($slot_fill<$maxquota){//hasn't reached the limit, enabled
		if(($daynum<$today)||(($daynum==$today)&&(($lastres_hour<$current_hour)||(($lastres_hour==$current_hour)&&($start_minute<$current_minute))))){//can't reserve, because the day has passed
		//echo "res day has passed";
			if($joinsum<=($maxperweek-1)){//not registered for the max. # of slots
				if (in_array($slot_id, $user_reservations)){//Student registered for this slot, leave button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input disabled='disabled' style='color: green' type='submit' style='white-space:pre' name='leave_slot' value='" . $button_value . "'></form>";		
				}else{//student not registered for this slot, join button
						echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input disabled='disabled' style='color:black' type='submit' style='white-space:pre' name='join_slot' value='" . $button_value . "'></form>";
				}
			}else{//registered for the max. # of slots
				if (in_array($slot_id, $user_reservations)){//Student registered for this slot, leave button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input disabled='disabled' style='color: green' type='submit' style='white-space:pre' name='leave_slot' value='" . $button_value . "'></form>";		
				}else{ //student not registered for this slot, disabled join button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input disabled='disabled' style='color:red' type='submit' style='white-space:pre' name='join_slot' value='" . $button_value . "'></form>";
				}
			}
	
			}else if(($daynum==$today)&&(($lastres_hour>$current_hour)||(($lastres_hour==$current_hour)&&($start_minute<$current_minute)))){//today is the last day of res
			//echo "today is the last day of res";
				if($joinsum<=($maxperweek-1)){//not registered for the max. # of slots
				if (in_array($slot_id, $user_reservations)){//Student registered for this slot, leave button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input style='color: green' type='submit' style='white-space:pre' name='leave_slot' value='" . $button_value . "'></form>";		
				}else{//student not registered for this slot, join button
						echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input style='color:black' type='submit' style='white-space:pre' name='join_slot' value='" . $button_value . "'></form>";
				}
			}else{//registered for the max. # of slots
				if (in_array($slot_id, $user_reservations)){//Student registered for this slot, leave button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input style='color: green' type='submit' style='white-space:pre' name='leave_slot' value='" . $button_value . "'></form>";		
				}else{ //student not registered for this slot, disabled join button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input disabled='disabled' style='color:red' type='submit' style='white-space:pre' name='join_slot' value='" . $button_value . "'></form>";
				}
			}

			}else{//many days before res
			//echo "many days before res";
					if($joinsum<=($maxperweek-1)){//not registered for the max. # of slots
				if (in_array($slot_id, $user_reservations)){//Student registered for this slot, leave button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input style='color: green' type='submit' style='white-space:pre' name='leave_slot' value='" . $button_value . "'></form>";		
				}else{//student not registered for this slot, join button
						echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input style='color:black' type='submit' style='white-space:pre' name='join_slot' value='" . $button_value . "'></form>";
				}
			}else{//registered for the max. # of slots
				if (in_array($slot_id, $user_reservations)){//Student registered for this slot, leave button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input style='color: green' type='submit' style='white-space:pre' name='leave_slot' value='" . $button_value . "'></form>";		
				}else{ //student not registered for this slot, disabled join button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input disabled='disabled' style='color:red' type='submit' style='white-space:pre' name='join_slot' value='" . $button_value . "'></form>";
				}
			}
		}
	}else{//reached the limit, disabled
		if(($daynum<$today)||(($daynum==$today)&&(($lastres_hour<$current_hour)||(($lastres_hour==$current_hour)&&($start_minute<$current_minute))))){//can't reserve, because the day has passed
		//echo "res day has passed";
			if($joinsum<=($maxperweek-1)){//not registered for the max. # of slots
				if (in_array($slot_id, $user_reservations)){//Student registered for this slot, leave button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input disabled='disabled' style='color: green' type='submit' style='white-space:pre' name='leave_slot' value='" . $button_value . "'></form>";		
				}else{//student not registered for this slot, join button
						echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input disabled='disabled' style='color:black' type='submit' style='white-space:pre' name='join_slot' value='" . $button_value . "'></form>";
				}
			}else{//registered for the max. # of slots
				if (in_array($slot_id, $user_reservations)){//Student registered for this slot, leave button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input style='color: green' type='submit' style='white-space:pre' name='leave_slot' value='" . $button_value . "'></form>";		
				}else{ //student not registered for this slot, disabled join button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input disabled='disabled' style='color:red' type='submit' style='white-space:pre' name='join_slot' value='" . $button_value . "'></form>";
				}
			}
	
			}else if(($daynum==$today)&&(($lastres_hour>$current_hour)||(($lastres_hour==$current_hour)&&($start_minute<$current_minute)))){//today is the last day of res
			//echo "today is the last day of res";
				if($joinsum<=($maxperweek-1)){//not registered for the max. # of slots
				if (in_array($slot_id, $user_reservations)){//Student registered for this slot, leave button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input style='color: green' type='submit' style='white-space:pre' name='leave_slot' value='" . $button_value . "'></form>";		
				}else{//student not registered for this slot, join button
						echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input disabled='disabled' style='color:black' type='submit' style='white-space:pre' name='join_slot' value='" . $button_value . "'></form>";
				}
			}else{//registered for the max. # of slots
				if (in_array($slot_id, $user_reservations)){//Student registered for this slot, leave button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input style='color: green' type='submit' style='white-space:pre' name='leave_slot' value='" . $button_value . "'></form>";		
				}else{ //student not registered for this slot, disabled join button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input disabled='disabled' style='color:red' type='submit' style='white-space:pre' name='join_slot' value='" . $button_value . "'></form>";
				}
			}

			}else{//many days before res
			//echo "many days before res";
					if($joinsum<=($maxperweek-1)){//not registered for the max. # of slots
				if (in_array($slot_id, $user_reservations)){//Student registered for this slot, leave button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input style='color: green' type='submit' style='white-space:pre' name='leave_slot' value='" . $button_value . "'></form>";		
				}else{//student not registered for this slot, join button
						echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input disabled='disabled' style='color:black' type='submit' style='white-space:pre' name='join_slot' value='" . $button_value . "'></form>";
				}
			}else{//registered for the max. # of slots
				if (in_array($slot_id, $user_reservations)){//Student registered for this slot, leave button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input style='color: green' type='submit' style='white-space:pre' name='leave_slot' value='" . $button_value . "'></form>";		
				}else{ //student not registered for this slot, disabled join button
					echo "<form method='post'><input type='hidden' name='slot_id' value='" . $slot_id . "'><input disabled='disabled' style='color:red' type='submit' style='white-space:pre' name='join_slot' value='" . $button_value . "'></form>";
				}
			}
		}
	}

}
}

echo "</form>";
?>


<br><br>
</td>
</tr></table>
<div>
<br><br><br>
<div class="logoff_button">
<form name="logoff" method="POST">
<input type ="submit" name="logoff" value="Log Off">
</form>
</div>


<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© INÇNET</a>
</div>
</HTML>

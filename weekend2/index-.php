<?PHP
function array_count_values_of($value, $array) {
    $counts = array_count_values($array);
    return $counts[$value];
}






require_once '../mobile_detect/Mobile_Detect.php';
$detect = new Mobile_Detect;
if ( $detect->isMobile() ) {
  echo	"<meta http-equiv='refresh' content='0; url=../mobile/weekend.php'>"; 
}


session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}

$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
if (isset($_POST['logoff'])){
	session_destroy();
	setcookie("remember", "", time()-3600);
	header("location:../incnet/login.php");	
}

include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("incnet");

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}

$teacher_query = mysql_query("SELECT student_id FROM incnet.coreUsers WHERE user_id='$user_id'");
while($teacher_row = mysql_fetch_array($teacher_query)){
	$student_id = $teacher_row['student_id'];
}


//current date
$week_name = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
$dnwh = date('H-i');
$dnoweek = date(w);
if ($dnoweek==0) {$dnoweek=7;}
$dnwh = array($dnoweek, $dnwh);
$dnwh = implode("-", $dnwh);
$pdnfmon = 1-$dnoweek;
$pdnff = 5-$dnoweek;
$pdnfsat = 6-$dnoweek;
$pdnfsun = 7-$dnoweek;
$monday = date('d-m-F-Y', strtotime("+" . $pdnfmon . " days"));
$monday = explode("-", $monday);
$friday = date('d-m-F-Y', strtotime("+" . $pdnff . " days"));
$friday = explode("-", $friday);
$saturday = date('d-m-F-Y', strtotime("+" . $pdnfsat . " days"));
$saturday = explode("-", $saturday);
$sunday = date('d-m-F-Y', strtotime("+" . $pdnfsun . " days"));
$sunday = explode("-", $sunday);
$mondayoty = $monday[3] . "-" . $monday[1] . "-" . $monday[0];
$fridayoty = $friday[3] . "-" . $friday[1] . "-" . $friday[0];
$saturdayoty = $saturday[3] . "-" . $saturday[1] . "-" . $saturday[0];
$sundayoty = $sunday[3] . "-" . $sunday[1] . "-" . $sunday[0];
$dep_arr_days = array($fridayoty, $saturdayoty, $sundayoty);


$days = explode(",","Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday"); //IK weeks don't begin with sundays but the idiot who wrote the date() function thinks they do...

if(isset($_POST['saveDeparture'])){
	$temp = explode(";", mysql_real_escape_string($_POST['leave'])); //$_POST['leave'] = "<leave_id>;<bus_id>"
	$sql = "SELECT * FROM weekend2bans WHERE user_id=$user_id AND (leave_ids LIKE '%,".$temp[0]."%' OR leave_ids LIKE '%".$temp[0].",%' OR leave_ids LIKE '".$temp[0]."')";
	$res = mysql_query($sql) or die(mysql_error()."<br/>$sql");
	if(isset($_GET['debug'])) die("<pre>$sql</pre>");
	if($row = mysql_fetch_array($res))
		if($row['user_id'] == $user_id)
			$err = "I'm sorry Dave. I'm afraid I can't let you do that. (Neither do your parents)";
	
	if($_POST['leave'] == "Home" && !isset($_POST['homedetail'])){
		$home = true;
	}
			
	
	//<Check if the user is occupied for the day(s)>
	$occupied = array(false, false, false, false);//Fri, Sat, Sun(, Monday -> 23 April) (no need to check monday since no departure other than home exists for monday)
	
	$sql = "SELECT * FROM weekend2departures WHERE weekend2departures.user_id=$user_id AND weekend2departures.active=1";
	$res = mysql_query($sql) or die(mysql_error()."<br/>$sql");
	
	while($row = mysql_fetch_assoc($res)){
		$sql2 = "SELECT * FROM weekend2leaves WHERE leave_id=$row[leave_id]";
		$res2 = mysql_query($sql2);
		$row2 = mysql_fetch_assoc($res2);
		$groups[] = $row2['group'];
		//echo "row:";
		//var_dump($row);
		//IK this is slow but it's 5AM atm so can't be bothered to find an efficient algorithm
		if($row['leave_id'] == 5){//Home
			if(strtotime($row['dep_date']) <= strtotime("friday this week") && strtotime($row['arr_date']) >= strtotime("friday this week")) $occupied[0] = true;
			if(strtotime($row['dep_date']) <= strtotime("saturday this week") && strtotime($row['arr_date']) >= strtotime("saturday this week")) $occupied[1] = true;
			if(strtotime($row['dep_date']) <= strtotime("sunday this week") && strtotime($row['arr_date']) >= strtotime("sunday this week")) $occupied[2] = true;
		}else{
			$daysql = "SELECT day, allowsameday FROM weekend2leaves WHERE leave_id=$row[leave_id]";
			$res2 = mysql_query($daysql) or die(mysql_error()." <br/>$daysql");
			$row2 = mysql_fetch_assoc($res2);
			if($row2['allowsameday'] == 1) continue;
			switch($row2['day']){
				case 0:
					$occupied[2] = true;
					break;
				case 5:
					$occupied[0] = true;
					break;
				case 6:
					$occupied[1] = true;
					break;
				//23 April
				case 1:
					$occupied[3] = true;
					break;
			}
		}
	}
	//</Check if the user is occupied for the day(s)>
	
	//<Check group>
	$temp = explode(";", mysql_real_escape_string($_POST['leave'])); //$_POST['leave'] = "<leave_id>;<bus_id>"
	$sql = "SELECT * FROM weekend2leaves WHERE leave_id=".$temp[0];
	$res = mysql_query($sql); //Throws an error when homedetail is included but doesn't matter since we don't display errors and this portion is not used when homedetail is included.
	$row = mysql_fetch_assoc($res);
	//die("cyka");
	$sqla = "SELECT value FROM weekend2vars WHERE `key` LIKE 'max_weekly_leave'";
	$resa = mysql_query($sqla) or die(mysql_error()."<br/>$sql");
	$rowa = mysql_fetch_assoc($resa);
	if(array_count_values_of($row['group'], $groups) >= intval($rowa['value']))
		$err = "I'm sorry Dave, I'm afraid I can't let you do that.";
	unset($temp);
	//</Check group>
	
	if(isset($_POST['homedetail'])){
		if($_POST['depDate'] == $_POST['arrDate'])
			$err = "I'm sorry Dave. I'm afraid I cannot let you do that. Neither does the administration. (You can't return on the same day)";
		else{
			$dep_bus = mysql_real_escape_string($_POST['depBus']);
			$arr_bus = mysql_real_escape_string($_POST['arrBus']);
			$leave_id = 5;
			$dep_date = mysql_real_escape_string($_POST['depDate']);
			$arr_date = mysql_real_escape_string($_POST['arrDate']);
			$sql = "DELETE FROM weekend2departures WHERE user_id=$user_id AND leave_id=5";
			mysql_query($sql);
			
			if(((strtotime($dep_date) <= strtotime("friday this week") && strtotime("friday this week") <= strtotime($arr_date)) && $occupied[0]) || ((strtotime($dep_date) <= strtotime("saturday this week") && strtotime("saturday this week") <= strtotime($arr_date)) && $occupied[1]) || ((strtotime($dep_date) <= strtotime("sunday this week") && strtotime("sunday this week") <= strtotime($arr_date) && $occupied[2])))
				$err = "You can't save your departure because one of your other departures overlaps with this one.";
		}
	}else if(!$home){
		$temp = explode(";", mysql_real_escape_string($_POST['leave'])); //$_POST['leave'] = "<leave_id>;<bus_id>"
		$dep_bus = $temp[1];
		$arr_bus = $dep_bus;
		$leave_id = $temp[0];
		$leave_day_sql = "SELECT `day` FROM weekend2leaves WHERE `leave_id`=$leave_id";
		//echo $leave_day_sql;
		$leave_day_res = mysql_query($leave_day_sql);
		$leave_day_row = mysql_fetch_assoc($leave_day_res);
		$dep_date = date("Y-m-d", ($leave_day_row['day'] == 5 ? strtotime("friday this week") : ($leave_day_row['day'] == 6 ? strtotime("saturday this week") : (/*23 April*/$leave_day_row["day"] == 1 ? strtotime("23 April 2018") : strtotime("sunday this week")))));
		$arr_date = $dep_date;
		unset($temp);
		
		//var_dump($occupied);
		//var_dump($dep_date);
		
		if(((strtotime($dep_date) == strtotime("friday this week")) && $occupied[0]) || ((strtotime($dep_date) == strtotime("saturday this week")) && $occupied[1]) || ((strtotime($dep_date) == strtotime("sunday this week")) && $occupied[2])) $err = "You can't save your departure because one of your other departures overlaps with this one.";
	}
	if(!isset($err) && !$home){
		$sql = "INSERT INTO weekend2departures VALUES (0, '$user_id', '$dep_bus', '$arr_bus', '$leave_id', '$dep_date', '$arr_date', 1)";
		mysql_query($sql) or die("ggwp lol: ".mysql_error()."<br/>\n$sql");
	}
}
if(isset($_POST['removeDeparture'])){
	$sql = "DELETE FROM weekend2departures WHERE user_id=$user_id AND departure_id=".mysql_real_escape_string($_POST['removeId']);
	mysql_query($sql) or die(mysql_error()."<br/>$sql");
}
?>
<!DOCTYPE html>
<HTML>
<head>
<title>Inçnet | Weekend Departures</title>
<link rel="shortcut icon" href="favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
<style>
	button.link {
		background:none!important;
		color:inherit;
		border:none; 
		padding:0!important;
		font: inherit;
		cursor: pointer;
	}
	button.link:hover{
		border-bottom:1px solid #444; 
	}
</style>
</head>
<body>
	<?php 
		if(isset($err)) echo("<script>alert('".str_replace("'", "\'",$err)."');</script>");
	?>
	<div class="top_menubar">
	<?PHP echo $fullname; ?>
	</div>
<br><br>
<div class="page_logo_container">
<table><tr>
<td><a href="../incnet/index.php"><img src="../img/weekend.png" width="120px" border=0 /></a><br>
</td>
<td width="5px"></td>
<td bgcolor="black" width=0.1px>
<td width="3px"></td>
<td valign="middle">
<h3>Weekend Departures Page</h3>
<?PHP

//admin links
if (in_array("702",$allowed_pages)) {
echo "<a style='color:black' href='editstudentpermissions.php'>Add/Remove Student Permissions</a><br>";
}

if (in_array("701", $allowed_pages)) {
echo "
<a style='color:black' href='addleave.php'>Add Leave</a><br>";
echo "
<a style='color:black' href='editleaves.php'>Edit Leaves</a><br>";
echo "
<a style='color: black' href='addbus.php'>Add Bus</a><br/>";
echo "
<a style='color:black' href='editbuses.php'>Edit Buses</a><br>";
echo "
<a style='color:black' href='adddeparture.php'>Add Departure</a><br>";
echo "
<a style='color:black' href='editlists.php'>Edit Departure Lists</a><br>";
echo "
<a style='color:black' href='list.php'>Print List</a><br>";
echo "
<a style='color:black' href='editarrivals.php'>Edit Arrival Lists</a><br>";
echo "
<a style='color:black' href='reportlist.php'>Reports</a><br>";
echo "
<a style='color:black' href='editvars.php'>Edit Global Settings</a><br>";
}

//vars from db

$sql8 = mysql_query("SELECT * FROM incnet.weekend2vars");
while ($row8 = mysql_fetch_array($sql8)){
	$var_value[$row8['key']] = $row8['value'];
}

$state = $var_value['enabled'];
$deadline = $var_value['deadline'];


if($state == '1'){
	if($home)
		include("homedetail.php");
	else if ($dnwh < $deadline){
	
		//Leaves dropdown from database
		echo "
		<br>
		<b>Please select where you would like to go:</b><br><br>
		<form action=# method=POST>
			<select name=leave>
				<option value=Home>Home</option>";
		$sql = "SELECT * FROM weekend2leaves ORDER BY leave_id ASC";
		$res = mysql_query($sql);
		while($row = mysql_fetch_assoc($res)){
			if($row['leave_name'] == "Home") continue;
			foreach(explode(",", $row['assoc_busses']) as $bus){
				if($bus == "") break;
				$sql2 = "SELECT * FROM weekend2busses WHERE bus_id=$bus";
				$res2 = mysql_query($sql2) or die(mysql_error()."<br/>".$sql2);
				$row2 = mysql_fetch_assoc($res2);
				echo "
				<option value='$row[leave_id];$row2[bus_id]'>$row[leave_name] with $row2[bus_name]</option>";
			}
		}	
		echo("
			</select>
			<br/><br/>
			<input type=Submit name=saveDeparture value=Save />
		</form>");
	}
	else {
		$disabled = "true";
		echo "
		<br>
		Too late! You can't fill the form.<br><br>";
	}
	
	//Display current departures
	$sql = "SELECT * FROM weekend2departures WHERE user_id=$user_id";
	$res = mysql_query($sql);
	
	while($row = mysql_fetch_assoc($res)){
		$goingPlaces = true;
		$places[] = $row;
	}
	
	if($goingPlaces){
		unset($dep_bus, $arr_bus);
		echo("<br/>This week, you are going to:<br/>");
		foreach($places as $place){
			if($place['leave_id'] == 5){//Home
				$dep_bus = mysql_fetch_array(mysql_query("SELECT bus_name FROM weekend2busses WHERE bus_id=$place[dep_bus_id]"));
				$arr_bus = mysql_fetch_array(mysql_query("SELECT bus_name FROM weekend2busses WHERE bus_id=$place[arr_bus_id]"));
				echo("<b>Home</b> (Leaving on <b>$place[dep_date]</b> by <b>$dep_bus[0]</b> and returning on <b>$place[arr_date]</b> by <b>$arr_bus[0]</b>.) <form style=\"display: inline;\"method=POST action=#><input type=hidden name=removeId value=$place[departure_id]>(<button type=submit name=removeDeparture class=link>Remove</button>)</form><br/>");
			}else{
				$row = mysql_fetch_array(mysql_query("SELECT leave_name FROM weekend2leaves WHERE leave_id=$place[leave_id]"));
				$dep_bus = mysql_fetch_array(mysql_query("SELECT bus_name FROM weekend2busses WHERE bus_id=$place[dep_bus_id]"));
				echo("<b>".$row[0]."</b> by <b>$dep_bus[0]</b> <form style=\"display: inline;\"method=POST action=#><input type=hidden name=removeId value=$place[departure_id]>(<button type=submit name=removeDeparture class=link>Remove</button>)</form><br/>");
			}
		}
	}
	
	
} else {
	echo "<p style='font-size:20px;color:#c1272d;'>The system is disabled. Please consult the Administration.</p>";
}
?>
<br>
</td>
</tr></table>
</div>
<br><br><br>
<div class="logoff_button">
<form name="logoff" method="POST">
<input type ="submit" name="logoff" value="Log Off">
</form></div>
<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2018 INCNET</a>
</div>
</body>
</HTML>

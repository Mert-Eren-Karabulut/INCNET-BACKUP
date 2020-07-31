<?PHP
function array_count_values_of($value, $array) {
    $counts = array_count_values($array);
    return $counts[$value];
}






require_once '../mobile_detect/Mobile_Detect.php';
$detect = new Mobile_Detect;
if ( !$detect->isMobile() ) {
  echo	"<meta http-equiv='refresh' content='0; url=../weekend2'>"; 
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
	if(mysql_fetch_array($res)) $err = "I'm sorry Dave. I'm afraid I can't let you do that. (Neither do your parents)";
	
	if($_POST['leave'] == "Home" && !isset($_POST['homedetail'])){
		$home = true;
	}
			
	
	//<Check if the user is occupied for the day(s)>
	$occupied = array(false, false, false);//Fri, Sat, Sun (no need to check monday since no departure other than home exists for monday)
	
	$sql = "SELECT * FROM weekend2departures WHERE user_id=$user_id AND active=1";
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
			$daysql = "SELECT day FROM weekend2leaves WHERE leave_id=$row[leave_id]";
			$res2 = mysql_query($daysql) or die(mysql_error());
			$row2 = mysql_fetch_assoc($res2);
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
		if(strtotime($_POST['depDate']) < strtotime($_POST['arrDate'])){
			//stuf
		}
		if($_POST['depDate'] == $_POST['arrDate']){
			$err = "I'm sorry Dave. I'm afraid I cannot let you do that. Neither does the administration. (You canot return the same day.)";
		}else{
			$dep_bus = mysql_real_escape_string($_POST['depBus']);
			$arr_bus = mysql_real_escape_string($_POST['arrBus']);
			$leave_id = 5;
			$dep_date = mysql_real_escape_string($_POST['depDate']);
			$arr_date = mysql_real_escape_string($_POST['arrDate']);
			$sql = "DELETE FROM weekend2departures WHERE user_id=$user_id AND leave_id=5";
			mysql_query($sql);
		}
		
		if(((strtotime($dep_date) <= strtotime("friday this week") && strtotime("friday this week") <= strtotime($arr_date)) && $occupied[0]) || ((strtotime($dep_date) <= strtotime("saturday this week") && strtotime("saturday this week") <= strtotime($arr_date)) && $occupied[1]) || ((strtotime($dep_date) <= strtotime("sunday this week") && strtotime("sunday this week") <= strtotime($arr_date) && $occupied[2])))
			$err = "You can't save your departure because one of your other departures overlaps with this one.";
		
	}else if(!$home){
		$temp = explode(";", mysql_real_escape_string($_POST['leave'])); //$_POST['leave'] = "<leave_id>;<bus_id>"
		$dep_bus = $temp[1];
		$arr_bus = $dep_bus;
		$leave_id = $temp[0];
		$leave_day_sql = "SELECT `day` FROM weekend2leaves WHERE `leave_id`=$leave_id";
		//echo $leave_day_sql;
		$leave_day_res = mysql_query($leave_day_sql);
		$leave_day_row = mysql_fetch_assoc($leave_day_res);
		$dep_date = date("Y-m-d", ($leave_day_row['day'] == 5 ? strtotime("friday this week") : ($leave_day_row['day'] == 6 ? strtotime("saturday this week") : strtotime("sunday this week"))));
		$arr_date = $dep_date;
		unset($temp);
		
		//var_dump($occupied);
		//var_dump($dep_date);
		
		if(((strtotime($dep_date) == strtotime("friday this week")) && $occupied[0]) || ((strtotime($dep_date) == strtotime("saturday this week")) && $occupied[1]) || ((strtotime($dep_date) == strtotime("sunday this week")) && $occupied[2])) $err = "You can't save your departure because one of your other departures overlaps with this one.";
	}
	if(!isset($err) && !$home){
		$sql = "INSERT INTO weekend2departures VALUES (0, '$user_id', '$dep_bus', '$arr_bus', '$leave_id', '$dep_date', '$arr_date', 1)";
		mysql_query($sql);
	}
}
if(isset($_POST['removeDeparture'])){
	$sql = "DELETE FROM weekend2departures WHERE user_id=$user_id AND departure_id=".mysql_real_escape_string($_POST['removeId']);
	mysql_query($sql) or die(mysql_error()."<br/>$sql");
}
?>
<!doctype html>
<html>
<head>
				<title>Inçnet</title>
		<link rel='shortcut icon' href='favicon.ico' >
		<meta charset='UTF-8'>
		<link rel='stylesheet' href='style.css' type='text/css' media='screen'  title='no title' charset='utf-8'>
<style>
body {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	font-size: 14px;
}


form { margin: 0; }  



.default_font{
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	font-size: 12pt;
}

a {
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	color: white;
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
}



.mobilebutton {
	color:white;
	background:#c1272d ;
	width:94%;
	left:3%;
	height:100px; 
	font-size: 35pt;
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	text-shadow:5px 5px 7px black;
	box-shadow:6px 6px 5px black;
	border:1;
	position:relative; 
	-webkit-appearance: none;
}

.mobilepart{
	width:100%;height:90%
}

#bottomButton{
	top:220px;
	margin-bottom:100px;
	color:white;
}
.etut{
	font-size:35pt;
	width:90%;
	display:block;
	margin-left:auto;
	margin-right:auto;
	color:#c1272d;
}
.etutButton{

	color:white;
	background:#c1272d ;
	width:30%;
	float:right;
	height:100px; 
	font-size: 35pt;
	font-family:lucida grande,tahoma,verdana,arial,sans-serif;
	text-shadow:5px 5px 7px black;
	border-radius:7px;
	box-shadow:6px 6px 5px black;
	border:1;
	position:relative;
	margin-top:20px;
	margin-bottom:70px;
}
.etutSelect{
	color:#c1272d;
	background:white;
	font-weight:bold;
	width:65%;
	float:left;
	height:100px;
	font-size:35pt;
	border-radius:7px;
	box-shadow:6px 6px 5px black;
	border:1;
	margin-top:20px;
	margin-bottom:70px;

}
.taplogoff{
	color:white;
	opacity:0.5;
	text-align:left;
	position:absolute;
}
button.link {
	background:none!important;
	color:inherit;
	border:none; 
	padding:0!important;
	font: inherit;
	cursor: pointer;
}
button.link:hover{
	border-bottom:1px solid #c1272d; 
}
</style>	
</head>
<body>
		<a href='logoff.php'>
			<div class="header"><div class='taplogoff'>&nbsp; Tap to log off</div>
				<? echo $fullname; ?> 	&nbsp;	
			</div>	
		</a>
	<a href='index.php'><img src='../../incnet/incnet.png' class='mobileimage'></a>
	<div class='etut'>
	<?php 
		if(isset($err)) echo("<script>alert('".str_replace("'", "\'",$err)."');</script>");
	?>
<h3>Weekend Departures Page</h3>
<?PHP
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
			<select class=etutSelect name=leave>
				<option value=Home>Home</option>";
		$sql = "SELECT * FROM weekend2leaves ORDER BY leave_id ASC";
		$res = mysql_query($sql) or die(mysql_error()."<br/>".$sql);
		while($row = mysql_fetch_assoc($res)){
			if($row['leave_name'] == "Home") continue;
			foreach(explode(",", $row['assoc_busses']) as $bus){
				if($bus == "") break;
				$sql2 = "SELECT * FROM weekend2busses WHERE bus_id=$bus";
				$res2 = mysql_query($sql2) or die(mysql_error()."<br/>".$sql);
				$row2 = mysql_fetch_assoc($res2);
				echo "
				<option value='$row[leave_id];$row2[bus_id]'>$row[leave_name] with $row2[bus_name]</option>";
			}
		}	
		echo("
			</select>
			<input class=etutButton type=Submit name=saveDeparture value=Save />
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
</div>
</body>
</HTML>

<?PHP

session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}

$user_id = $_SESSION['user_id'];

//connect to mysql server
include ("db_connect.php");
$con;
if (!$con){
 die('Could not connect: ' . mysql_error());
}
  
$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='701'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}

if ($allowance != "1"){
	header ("location:index.php");
}

//Get values
$sql_changed = $_GET['query'];
$to_be_changed = "#";
$to_change = "'";
$sql = str_replace($to_be_changed, $to_change, $sql_changed);
$sql = mysql_query($sql);
$info_leave_name = $_GET['headerinfo_name'];
$info_leave_date = $_GET['headerinfo_date'];
$info_bus_name = $_GET['headerinfo_bus'];
$info_list_type = $_GET['headerinfo_type'];

if (isset($info_list_type)){
	$back = "editarrivals.php";
} else {
	$back = "editlists.php";
}

//current time
$dnoweek = date(w);
if ($dnoweek==0) {$dnoweek=7;}
$pdnff = 5-$dnoweek;
$pdnfsat = 6-$dnoweek;
$pdnfsun = 7-$dnoweek;
$friday = date('d-m-F-Y', strtotime("+" . $pdnff . " days"));
$friday = explode("-", $friday);
$saturday = date('d-m-F-Y', strtotime("+" . $pdnfsat . " days"));
$saturday = explode("-", $saturday);
$sunday = date('d-m-F-Y', strtotime("+" . $pdnfsun . " days"));
$sunday = explode("-", $sunday);
$fridayoty = $friday[3] . "-" . $friday[1] . "-" . $friday[0];
$saturdayoty = $saturday[3] . "-" . $saturday[1] . "-" . $saturday[0];
$sundayoty = $sunday[3] . "-" . $sunday[1] . "-" . $sunday[0];
$infofri = $friday[0] . " " . $friday[2] . " " . $friday[3] . " Friday";
$infosat = $saturday[0] . " " . $saturday[2] . " " . $saturday[3] . " Saturday";
$infosun = $sunday[0] . " " . $sunday[2] . " " . $sunday[3] . " Sunday"; 
$dep_arr_days = array($fridayoty, $saturdayoty, $sundayoty, "", $infofri, $infosat, $infosun);
?>
<!DOCTYPE html>
<HTML>
<head>
<title>Inçnet | Weekend Departures</title>
	<link rel="shortcut icon" href="favicon.ico" >
	<link rel="stylesheet" href="style_printable.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<meta charset="UTF-8">
</head>
<body>
<div style='margin-left: auto; margin-right: auto; width: 600px;'>
<table width=600px border=0 />
<tr>
<td><a style='color:#c1272d; font-weight: bold; text-decoration:none' href='<? echo $back; ?>'> [Back] </a></td>
<td style='text-align: right;'><a style='color:#c1272d; font-weight: bold; text-decoration:none' href="javascript:window.print()">[Print this Page]</A></td>

</tr>
</table>
<hr>
<?PHP
$order = 1;
//header info query and variables
echo "
$info_list_type<b>" . $info_leave_name . "</b> on <b>" . $info_leave_date . $info_bus_name . "</b><br>	
<table style= 'border: 1px solid black;'><tr style= 'height: 20px'><td></td>
<td><b>Student ID</b></td>
<td><b>Student Name</b></td>
<td><b>Departure Bus</b></td>
<td><b>Departure Date</b></td>
<td><b>Arrival Bus</b></td>
<td><b>Arrival Date</b></td>
<td></td><td></td></tr>";

//variables for list
while ($row = mysql_fetch_array($sql)){
	$list_user_id = $row['user_id'];
	$sql0 = mysql_query("SELECT * FROM incnet.coreUsers WHERE user_id=$list_user_id");
	while ($row0 = mysql_fetch_array($sql0)){
		$list_student_name = $row0['name'] . " " . $row0['lastname'];
		$list_student_id = $row0['student_id'];}
	$list_depbus_id = $row['dep_bus_id'];
	$sql1 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE bus_id=$list_depbus_id");
	while ($row1 = mysql_fetch_array($sql1)){
		$list_depbus_name = $row1['bus_name'];}
	$list_dep_date = $row['dep_date'];
	$list_arrbus_id = $row['arr_bus_id'];
	$sql2 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE bus_id=$list_arrbus_id");
	while ($row2 = mysql_fetch_array($sql2)){
		$list_arrbus_name = $row2['bus_name'];}
	$list_arr_date = $row['arr_date'];
	$list_leave_group = $row['leave_group'];
	$list_dep_id = $row['departure_id'];
	
	//html code of rows of list
	echo "
	<tr><td><b>$order.</b></td><td>$list_student_id</td>
	<td>$list_student_name</td><td>$list_depbus_name</td>
	<td>$list_dep_date</td><td>$list_arrbus_name</td>
	<td>$list_arr_date</td></tr>";
	$order++;
}
?>
</table>
</div>
</body>
</HTML>

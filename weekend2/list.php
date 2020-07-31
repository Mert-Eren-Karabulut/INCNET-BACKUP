<?PHP
error_reporting(E_ALL);
session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}

$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];

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
mysql_set_charset("utf8");

$permit_query = mysql_query("SELECT * FROM incnet.corepermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}

$teacher_query = mysql_query("SELECT student_id FROM incnet.coreusers WHERE user_id='$user_id'");
while($teacher_row = mysql_fetch_array($teacher_query)){
	$student_id = $teacher_row['student_id'];
}

if (!(in_array("701", $allowed_pages))){
	header("location:index.php");
}


$down = "&#8964;";
$up = "&#8963;";
?>
<!DOCTYPE html>
<HTML>
<head>
	<title>Inçnet | Weekend Departures</title>
	<link rel="shortcut icon" href="favicon.ico" >
	<link rel="stylesheet" href="./jquery-ui-1.12.1.custom/jquery-ui.css" >
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="./jquery-ui-1.12.1.custom/jquery-ui.js"></script>
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<style>
		td
		{
			border: 1px solid black;
			border-collapse: collapse;
			padding: 3px;
			text-align: left;
		}
		tr
		{
			border-collapse: collapse;
		}
		table
		{
			border-collapse: collapse;   
		}
    .print_img
    {
      max-height: 110px;
      float:right;
    }
    .print
    {
      float: right;
      position: relative;
    }
    .main
    {
    	font-weight: bold;
    	font-size: 2em;
    	width: 100%;
    	text-align: center;
    }
    #print
    {
    	float: right;
    	padding: 5px;
    	font-size: 1.2em;
    	position: relative;
    	top: -50px;
    }
    #sortAndSelect
    {
    	text-align: left;
    }
	a{
		color: initial;
	}
	input.resizable{
		min-width: 100%;
	}
	</style>
	
	
	<script src="js/tabletoexcel.js"></script>
	<script>
		function printWindow(){
			document.getElementById("print").style.display = "none";
			window.print();
			document.getElementById("print").style.display = "block";
		}
	</script>
	<script type="text/javascript">
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()

$(function(){
	$(".resizable").change(function(){this.parentElement.parentElement.children[this.parentElement.parentElement.children.length-1].children[0].value="true";})
	$(".resizable").autocomplete({source:["lol", "lel", "abc", "def", "abcde", "abcab"]});
});
</script>
</head>
<?php
	
	function startsWith($haystack, $needle){
		 $length = strlen($needle);
		 return (substr($haystack, 0, $length) === $needle);
	}

	function endsWith($haystack, $needle){
		$length = strlen($needle);
		if ($length == 0) {
			return true;
		}
    return (substr($haystack, -$length) === $needle);
	}
	
	if(isset($_POST['update'])){
		foreach($_POST as $key){
			if(endsWith($key, "_changed")){
				if($_POST[$key] == "true"){
					echo("<script>alert('lel');</script>");
				}
			}
		}
	}
	
	
	switch($_GET['sort']){
		case "no":
			$orderBy = "student_id";
			$no_arrow = ($_GET['order'] == "DESC") ? $down : $up;
			break;
		case "name":
			$orderBy = "name";
			$name_arrow = ($_GET['order'] == "DESC") ? $down : $up;
			break;
		case "dorm":
			$orderBy = "dormroom";
			$dorm_arrow = ($_GET['order'] == "DESC") ? $down : $up;
			break;
		case "class":
			$orderBy = "class";
			$class_arrow = ($_GET['order'] == "DESC") ? $down : $up;
			break;
		case "dep":
			$departures = true;
			$orderBy = "dep_bus_id";
			$dep_arrow = ($_GET['order'] == "DESC") ? $down : $up;
			$sortDep = true;
			break;
		case "arr":
			$departures = true;
			$orderBy = "arr_bus_id";
			$arr_arrow = ($_GET['order'] == "DESC") ? $down : $up;
			$sortArr = true;
			break;
		default:
			$orderBy = "student_id";
	}
	$asc = $_GET['order'] == "ASC";
	$orderBy.=" ".mysql_real_escape_string(str_replace(";", "", $_GET['order']));
?>
<body>
	<table id=weekendListTable style='border: 0px solid black;'>
		<tr style="border:0px solid purple;">
			<td colspan='15' style="border:0px solid purple; text-align: center;">
				<span class='main'>TEV İnanç Türkeş Özel Lisesi</span>
				<br>
				<button id='print' onclick='printWindow()'>Print</button>
				<button id='print' onclick='fnExcelReport()'>Export as XLSX</button>
			</td>
			<td colspan='2' style="border:0px solid purple;">
			   <img src="../img/incnetWhite.png" class="print_img">		
			</td>
		</tr>
		<tr style='height:20px'>
			<td><b><a href="?sort=no&order=<?=($asc ? "DESC" : "ASC") ?>">No<?php echo(" $no_arrow"); ?></a></b></td>
			<td><b><a href="?sort=name&order=<?=($asc ? "DESC" : "ASC") ?>">Name<?php echo(" $name_arrow"); ?></a></b></td>
			<td><b><a href="?sort=dorm&order=<?=($asc ? "DESC" : "ASC") ?>">Dormroom<?php echo(" $dorm_arrow"); ?></a></b></td>
			<td><b><a href="?sort=class&order=<?=($asc ? "DESC" : "ASC") ?>">Class<?php echo(" $class_arrow"); ?></a></b></td>
			<td><b>Etut</b></td>
			<td><b>Friday</b></td>
			<td><b>Saturday</b></td>
			<td><b>Sunday</b></td>
			<!--<td><b>Monday</b></td>--><!-- For 23 April -->
			<td><b>Departure Date</b></td>
			<td><b><a href="?sort=dep&order=<?=($asc ? "DESC" : "ASC") ?>">Departure Bus<?php echo(" $dep_arrow"); ?></a></b></td>
			<td><b>Arrival Date</b></td>
			<td><b><a href="?sort=arr&order=<?=($asc ? "DESC" : "ASC") ?>">Arrival Bus<?php echo(" $arr_arrow"); ?></a>	</b></td>
			<td><b>Fri. Dorm</b></td>
			<td><b>Sat. Dorm</b></td>
			<td><b>Sun. Dorm</b></td>
			<td><b>Sat. Etut</b></td>
			<td><b>Sun. Etut</b></td>
		</tr>
		<?php
			$current = "(class LIKE 'Hz' OR class LIKE '9' OR class LIKE '10' OR class LIKE '11IB' OR class LIKE '11MEB' OR class LIKE '12IB' OR class LIKE '12MEB') AND (type NOT LIKE 'grad' AND type NOT LIKE 'old') AND type LIKE 'student'";
			//$sql = "(SELECT * FROM coreusers LEFT JOIN weekend2departures ON coreusers.user_id=weekend2departures.user_id WHERE $current) UNION (SELECT * FROM coreusers RIGHT JOIN weekend2departures ON coreusers.user_id=weekend2departures.user_id WHERE $current)"; //Warning! Trap for young players: This could only be used if we knew for sure everyone has only one departure max (which isn't true)
			if($departures){//If sorting by departures,
				$sql = "SELECT * FROM coreusers AS c JOIN weekend2departures AS w ON c.user_id = w.user_id WHERE ($current) OR type LIKE 'teacher' ORDER BY w.$orderBy";
			}else{
				$sql = "SELECT * FROM coreusers WHERE ($current) OR type LIKE 'teacher' AND type LIKE 'student' ORDER BY $orderBy";
			}
			$res = mysql_query($sql) or die(mysql_errno().": ".mysql_error()."<br/>$sql");
			while($row = mysql_fetch_assoc($res)){
				//var_dump($row['user_id']);
				$users[$row['user_id']] = $row; 
				$res2 = mysql_query("SELECT * FROM weekend2departures WHERE user_id=$row[user_id]") or die(mysql_error()."<br/>$sql");
				while($row2 = mysql_fetch_assoc($res2)){
					$departures[$row['user_id']][] = $row2;
				}
			}
			
			//var_dump($departures);
			
			$check = "&#10003;";
			$cross = "&#128473;";
			
			foreach($users as $user){
				$friDorm = $satDorm = $sunDorm = $satEtut = $sunEtut = $check;
				$id = $user['user_id'];
				$departure = $departures[$id];
				foreach($departure as $leave){
					$sql = "SELECT * FROM weekend2leaves WHERE leave_id=$leave[leave_id]";
					$res = mysql_query($sql) or die(mysql_error()."<br/>$sql");
					$row = mysql_fetch_assoc($res);
					if($leave['dep_date'] == $leave['arr_date']){
						switch($leave['dep_date']){
							case date("Y-m-d", strtotime("friday this week")):
								$friday = $row['leave_name'];
								break;
							case date("Y-m-d", strtotime("saturday this week")):
								$saturday = $row['leave_name'];
								break;
							case date("Y-m-d", strtotime("sunday this week")):
								$sunday = $row['leave_name'];
								break;
							//23 April Stuff
							case "2018-04-23":
								$monday = $row['leave_name'];
						}
					}else{
						$dep_date = $leave['dep_date'];
						$arr_date = $leave['arr_date'];
						
						$dep_sql = "SELECT * FROM weekend2busses WHERE bus_id=$leave[dep_bus_id]";
						$dep_res = mysql_query($dep_sql) or die(mysql_error()."<br/>$sql");
						$dep_row = mysql_fetch_assoc($dep_res);
						$arr_sql = "SELECT * FROM weekend2busses WHERE bus_id=$leave[arr_bus_id]";
						$arr_res = mysql_query($arr_sql) or die(mysql_error()."<br/>$sql");
						$arr_row = mysql_fetch_assoc($arr_res);
						
						$dep_bus = $dep_row['bus_name'];
						$arr_bus = $arr_row['bus_name'];
						
						//Assuming the student can't have more than one multi-day leave
						$friDorm = strtotime("friday this week") >= strtotime($leave['dep_date']) ? $cross : $check;
						$satDorm = strtotime("saturday this week") >= strtotime($leave['dep_date']) ? $cross : $check;
						$sunDorm = strtotime("sunday this week") >= strtotime($leave['dep_date']) && strtotime("sunday this week") < strtotime($leave['arr_date']) ? $cross : $check;
						
						$satEtut = $friDorm;
						$sunEtut = $sunDorm;
					}
				}
				$friday = str_replace(" Friday", "", $friday);
				$saturday = str_replace(" Saturday", "", $saturday);
				$sunday = str_replace(" Sunday", "", $sunday);
				$monday = str_replace(" Monday", "", $monday);
				$dep_date = $dep_date;
				$dep_bus = $dep_bus;
				$arr_date = $arr_date;
				$arr_bus = $arr_bus;
				$sql = "SELECT * FROM etut_defaultseats WHERE user_id=$user[user_id]";
				$res = mysql_query($sql) or die(mysql_error()."<br/>\n$sql");
				$row = mysql_fetch_assoc($res);
				echo("\t\t<tr class=data><td>$user[student_id]</td><td>$user[name] $user[lastname]</td><td>$user[dormroom]</td><td>$user[class]</td><td>$row[room] $row[seat]</td><td style=\"padding: 0;\">$friday</td><td>$saturday</td><td>$sunday</td><!--<td>$monday</td>--><td>$dep_date</td><td>$dep_bus</td><td>$arr_date</td><td>$arr_bus</td><td style=\"text-align: center;\">$friDorm</td><td style=\"text-align: center;\">$satDorm</td><td style=\"text-align: center;\">$sunDorm</td><td style=\"text-align: center;\">$satEtut</td><td style=\"text-align: center;\">$sunEtut</td></tr>\n");
				unset($friday, $saturday, $sunday, $dep_date, $arr_date, $arr_bus, $dep_bus, $friDorm, $satDorm, $sunDorm, $sunEtut, $satEtut, $monday /*$monday is for 23 April*/);
			}
		?>
	</table>
</body>




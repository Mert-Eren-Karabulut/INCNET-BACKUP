<?PHP

$con = mysql_connect("94.73.150.252","incnetRoot","newpass");
mysql_set_charset('utf8');
$con;

$sql = mysql_query("SELECT * FROM incnet.checkin2events WHERE approved!='' AND date>=current_date ORDER BY event_id ASC");
//echo $sql;

while($row = mysql_fetch_row($sql)){

	$event_id = $row[0];
	$event_title = $row[3];
	$event_date = $row[2];


	$event_date = explode("-", $event_date);
	$event_day = $event_date[2];
	$event_year = $event_date[0];
	$event_month = $event_date[1];
	switch ($event_month) {
		case "01":
			$event_month = "January";
			break;
		 case "02":
		 	$event_month = "February";
		 	break;
		 case "03":
		 	$event_month = "March";
		 	break;
		 case "04":
		 	$event_month = "April";
		 	break;
		 case "05":
		 	$event_month = "May";
		 	break;
		 case "06":
		 	$event_month = "June";
		 	break;
		 case "07":
		 	$event_month = "July";
		 	break;
		 case "08":
		 	$event_month = "August";
		 	break;
		 case "09":
		 	$event_month = "September";
		 	break;
		 case "10":
		 	$event_month = "October";
		 	break;
		 case "11":
		 	$event_month = "November";
		 	break;
		 case "12":
		 	$event_month = "December";
		 	break;
		 	}
	$event_date = $event_month . " " . $event_day;

}

echo"
<HTML>
<head>
		<meta http-equiv='refresh' content='5' >
</head>
<body>
";

if ($event_title!=''){
echo"


	
		
	<div style='color:c1272d; font-family:arial; font-size:35; font-weight:bold'>
	New event:
	<img style='position:absolute; top:0; right:0;' src='incnet.png' height='70px' border='0'/>	
	</div>

	<div style='font-size:30'>
		
	</div>

	<div style='color:black; font-family:arial; font-size:20;'>
		
		$event_title <br> $event_date
		
	</div>
	</body>
	


";
}

echo "</HTML>";
?>


<?

include ("db.php");
session_start();
echo "sadsad";
$sql="SELECT * FROM tv WHERE nobet = '1'";
	$result =mysql_query($sql) or die ("dead retrieving content");

	while($row = mysql_fetch_array($result)){
	

		$nobet = $row['nobet'];		
		 

	
	}
}
?>

<html>
<head>
<meta http-equiv="refresh" content="120" >
</head>
<body>
xdfghjmöçömnbvcx
<marquee align="middle" scrollamount="1" height="30" width="100%" direction="up"scrolldelay="1" style="word-wrap: break-word;">
<?PHP echo "$nobet"; ?>fd
</marquee> 
</body>
</html>


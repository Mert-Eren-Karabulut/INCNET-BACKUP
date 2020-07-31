<?php

error_reporting(0);

session_start();
$regID = $_SESSION['regid'];
require_once "../db_connect.php";
if (!$con)
{
	die("Could not connect: " . mysql_error());
} 

$init_stmt = "SELECT parent FROM incnet.profilesmaintemp WHERE registerId = $regID";
$init_query = mysql_query($init_stmt);
while ($init_row = mysql_fetch_array($init_query))
{
	$parent = $init_row["parent"];
}

if ($parent == "Anne")
{
	$stmt = "SELECT il FROM incnet.profilesmotherinfotemp WHERE registerId = $regID";
	$query = mysql_query($stmt);
	while ($row = mysql_fetch_array($query))
	{
		$province = $row["il"];
	}
}
else if ($parent == "Baba")
{
	$stmt = "SELECT il FROM incnet.profilesfatherinfotemp WHERE registerId = $regID";
	$query = mysql_query($stmt);
	while ($row = mysql_fetch_array($query))
	{
		$province = $row["il"];
	}
}
else if ($parent == "")
{
	$stmt = "SELECT il FROM incnet.profilesmaintemp WHERE registerId = $regID";
	$query = mysql_query($stmt);
	while ($row = mysql_fetch_array($query))
	{
		$province = $row["il"];
	}
}
else
{
	echo "An error occured: Wrong parent information. Please start again.
	<br><a href='student_info.php'>Start</a>";
}

if (($province == "İstanbul")||($province == "Kocaeli")||($province == "Yalova"))
{
	header("Location:devicesAlt.php");
}
else
{
	header("Location:relatives.php");
}
?>

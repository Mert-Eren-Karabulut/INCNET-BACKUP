<?PHP
	error_reporting(0);

/*
This page is used to reset some settings for the pool system
*/


//connect to mysql server
include ("db_connect.php");
if (!$con){
  die('Could not connect: ' . mysql_error());
  }


$con;


//reset pool settings for a new week
mysql_query("INSERT INTO incnet.weekendDepartures_old SELECT * FROM incnet.weekendDepartures");
mysql_query("DELETE FROM incnet.weekendDepartures");
echo(“Done.”);
?>

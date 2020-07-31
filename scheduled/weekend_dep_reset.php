<?PHP
	error_reporting(0);

/*
This page is used to reset some settings for the weekend departures system
*/


//connect to mysql server
include ("db_connect.php");
if (!$con){
  die('Could not connect: ' . mysql_error());
  }


$con;


//reset weekend departure settings for a new week
echo("Attempting insert...");
mysql_query("INSERT INTO incnet.weekend2pastdepartures SELECT * FROM incnet.weekend2departures");
echo("Done.\nAttempting delete...");
mysql_query("DELETE FROM incnet.weekend2departures");
echo("Done.");
?>

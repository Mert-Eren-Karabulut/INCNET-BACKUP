<?PHP
	error_reporting(0);

/*
* This page is used to reset some settings for the etut system
* It should be scheduled to run after Sundays, i.e. tuesdays.
*/


//connect to mysql server
include ("db_connect.php");
if (!$con){
  die('Could not connect: ' . mysql_error());
  }


$con;


//delete weekend table
mysql_query("DELETE FROM incnet.etut_weekend");

?>

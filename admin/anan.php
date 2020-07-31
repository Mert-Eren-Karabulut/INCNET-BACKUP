<?php
	die();
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
  mysql_select_db("incnet");
	$sql = "SELECT checkin2joins.user_id FROM checkin2joins WHERE event_id=1036";
	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		mysql_query("DELETE FROM etut_thisperiod WHERE user_id=".$row['user_id']." AND date='2017-04-18'");
		echo("a");
	}
?>
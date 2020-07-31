<?php
include("../db_connect.php");
mysql_select_db("incnet");
$ip_arr = explode(".", $_SERVER['REMOTE_ADDR']);
$ip_arr = array_slice($ip_arr, 0, 2);
$sql = "INSERT INTO read_receipt VALUES(0, DEFAULT, '".implode(".",$ip_arr).".???.???')";
mysql_query($sql);
$im = file_get_contents('./1px.png'); 
header('content-type: image/gif'); 
echo $im; 
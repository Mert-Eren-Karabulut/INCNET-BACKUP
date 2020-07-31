<?php

$dbname = "incnet";
$dbuser = "incnetRoot";
$dbpass = "6eI40i59n22M7f9LIqH9";

mysql_connect("94.73.150.252",$dbuser,$dbpass);
mysql_select_db($dbname) or die ("not found");
mysql_set_charset('utf8');


function login($username, $password){
	/*$sql = "SELECT * from users WHERE
	username = '$username'
	AND password = '$password'";
	$result = mysql_query($sql);
	$rows = mysql_num_rows($result);
	session_start();
	if ($rows > 0){
	*/

		
	}

function insert_content($baslik, $title, $metin, $text){

	$sql="INSERT into tv values (NULL, '$baslik', '$title', '$metin', '$text')";
	echo $sql;
	$result =mysql_query($sql) or die (mysql_error());

	
}


function retrieve_content(){

//	$sql="SELECT * FROM content";
	$sql="SELECT * FROM tv ORDER BY content_id ASC";
	$result =mysql_query($sql) or die ("dead retrieving content");

	while($row = mysql_fetch_array($result)){
	

		$baslik[] = $row[1];		
		$title[] = $row[2];
		$metin[] = $row[3];
		$text[] = $row[4];

	
	}
	

	
	session_start() ;

	
	$_SESSION['baslik'] = $baslik;	
	$_SESSION['title'] = $title;
	$_SESSION['metin'] = $metin;
	$_SESSION['text'] = $text;
	
}


	
	
?>

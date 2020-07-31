<?php
$servername = "94.73.170.253";
$username = "Tproject";
$password = "5ge353g5419L8fIEPv0E";
$dbname = "tproject";

$conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn -> exec("SET NAMES utf8;");

session_start();
$id = $_SESSION['user_id'];

$sec = true;
$termsql = $conn->prepare("SELECT * FROM tp WHERE user_id=:user");
$termsql -> execute(array(':user' => $id));
while($row = $termsql -> fetch()){
	$sec = false;
}
echo $sec;
if($sec){
$_SESSION['user_id'] = $id;
	header("Location: http://incnet.tevitol.org/termproject");
}else{
	header("Location: http://incnet.tevitol.org/incnet/indexterm.php");
}
?>
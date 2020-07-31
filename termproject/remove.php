<?
$id = $_POST['user_id'];


header("Content-type: text/html; charset=utf-8");
$servername = "94.73.170.253";
$username = "Tproject";
$password = "5ge353g5419L8fIEPv0E";
$dbname = "tproject";

$conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn -> exec("SET NAMES utf8;");


$sql = $conn->prepare("DELETE FROM tp WHERE user_id=:id");
$sql -> execute(array('id' => $id));

header("Location:index.php?return=1");
?>
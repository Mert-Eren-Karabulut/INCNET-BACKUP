<?
require_once "../class/init.class.php";
$init = new init;

$id = $_SESSION["user_id"];

$user = new user;
$user_info = $user -> user_info($id);
foreach ($user_info as $info)
{
	$name = $info['name'] . " " . $info['lastname'];
}
if(!isset($_SESSION["user_id"]))
	header("location: /");
function check_permission($id){
	$servername = "94.73.150.252";
	$username = "incnetRoot";
	$password = "6eI40i59n22M7f9LIqH9";
	$dbname = "incnet";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$result = $conn->query("SELECT * FROM corepermits WHERE user_id=".$_SESSION[user_id]." AND page_id=".$id);
	if(!($result->num_rows > 0))
		return false;
	else return true;
}

?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<title>Inçnet | Weekly Bulletin</title>
	</head>
	
	<body>
		<div class='header'>
						&nbsp;&nbsp;
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:180px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<br><div style="width. 100%; text-align: center;"><a href='../incnet'><img src='bulletin.png' width='135px'></a></div><br>
					<?php
						
						if(isset($_GET['p'])){
							echo ""; 							
							$content = 
								"
								<b style=\"font-size: 15pt;\">Weekly Bulletin</b>
								
								";
							if($_GET['p'] == "edit" && check_permission(11)){
								$content = "
									<b style=\"font-size: 15pt;\">Upload New Bulletin</b><br>
									<form action=\"uploadbulletin.php\" method=\"post\" enctype=\"multipart/form-data\">
    								Select PDF file to upload:
    								<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">
   								 	<input type=\"submit\" value=\"Upload PDF\" name=\"submit\">
									</form><br>
									<b>Önemli Uyarı:</b>Yüklediğiniz dosya türü <b>pdf</b> dosyası olmalıdır. 
									Lütfen PDFnin isminin <b>1.pdf</b> olmasına dikkat ediniz.<br><br>
									

									
								";
							} else if($_GET['p'] == "view" && check_permission(12)){
								$content = "
									<b style=\"font-size: 15pt;\">View Bulletin As User</b>
									<br>
								";
							}
						}
						
						if(check_permission(11))echo "<a href=\"?p=edit\" style=\"color: black;\">Upload New Bulletin</a><br/>";
						if(check_permission(12))echo "<a href=\"?p=view\" style=\"color: black;\">View Bulletin For User</a><br/>";
					?>
					<br>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<br>
						<?php
							echo $content;
							
							/*if(isset($_POST['editSchedule']) && check_permission(11)){
							$servername = "94.73.150.252";
							$username = "incnetRoot";
							$password = "6eI40i59n22M7f9LIqH9";
							$dbname = "incnet";
							
							// Create connection
							$conn = new mysqli($servername, $username, $password, $dbname);
							// Check connection
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
							}*/
							echo "Today is " . date("d.m.Y") . "<br>";
							echo json_decode($_POST['schedule']);
						//}
						?>
						
						<br>

<iframe src="bulletin/1.pdf" width="1000" height="2400" frameborder="0" scrolling="yes"></iframe>				

				<br><br>						
				</td>
			</tr>
		</table>
		<div class="copyright">&nbsp &copy; INÇNET</div>
	</body>
</HTML>


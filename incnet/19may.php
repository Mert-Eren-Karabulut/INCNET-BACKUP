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
		<title>Inçnet | 19 May Activities</title>
	</head>
	
	<body>
		<div class='header'>
						&nbsp;&nbsp;
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:180px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<br><div style="width. 100%; text-align: center;"><a href='../incnet'><img src='incnet14.png' width='135px'></a></div><br>
					<?php
						
						if(isset($_GET['p'])){
							echo ""; 							
							$content = 
								"
								
								
								";
							if($_GET['p'] == "edit" && check_permission(11)){
								$content = "
									
									

									
								";
							} else if($_GET['p'] == "view" && check_permission(12)){
								$content = "
									
									<br>
								";
							}
						}
						
					?>
					<br>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px; width:100%;'>
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
							echo json_decode($_POST['schedule']);
						//}
						?>
						
						<br>
<div style="width:100%; text-align: center;">
<h1 style="text-align:center;">19 May Activities Video</h1><br/><br/><br/>

<iframe width="640" height="360" src="https://www.youtube.com/embed/DejXS0pfnwI" frameborder="0" allowfullscreen></iframe>
</div>
<br> <br> <br> <br> <br> <br>

				</td>
			</tr>
		</table>
		<div class="copyright">&nbsp &copy; INÇNET</div>
	</body>
</HTML>


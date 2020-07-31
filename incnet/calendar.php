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
		<title>Inçnet | Timetable</title>
	</head>
	
	<body>
		<div class='header'>
						&nbsp;&nbsp;
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:180px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<br><div style="width. 100%; text-align: center;"><a href='../incnet'><img src='../img/incnet.png' width='135px'></a></div><br>
					<?php
						
						if(isset($_GET['p'])){
							echo "<a href=\"?\" style=\"color: black;\">Default</a><br/>"; 							
							$content = 
								"
								<b style=\"font-size: 15pt;\">Exam Schedule</b>
								
								";
							if($_GET['p'] == "edit" && check_permission(11)){
								$content = "
									<b style=\"font-size: 15pt;\">Edit Exam Schedule</b>
									<form action=# method=POST>
										<br/><label for=schedule>Enter New Schedule</label><br>
										<textarea rows=40 cols=150 name=schedule id=schedule></textarea><br/>
										<input type=Submit name=editSchedule value=Go>
									</form>
								";
							} else if($_GET['p'] == "view" && check_permission(12)){
								$content = "
									<b style=\"font-size: 15pt;\">View Exam Schedule As User</b>
								";
							}
						}
						
						if(check_permission(11))echo "<a href=\"?p=edit\" style=\"color: black;\">Edit Exam Schedule</a><br/>";
						if(check_permission(12))echo "<a href=\"?p=view\" style=\"color: black;\">View Exam Schedule For User</a><br/>";
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
							echo "";
							echo json_decode($_POST['schedule']);
						//}
						?>
						<h4>Timetable</h4>
						
						<iframe src=https://docs.google.com/spreadsheets/d/1cml8F8lmLdLzt-Gq2EH8ePnJmSrMUfSQ_E6rYHb09cE/edit#gid=0 width=1100 height=1200 scrolling=no>
</iframe>

					<br><br><br>
					
				</td>
			</tr>
		</table>
		


		<div class="copyright">&nbsp &copy; INÇNET</div>
	</body>
</HTML>

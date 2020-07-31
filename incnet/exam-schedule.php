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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		
		<style>
			.example{
				display:none;
				height: 350px;
				overflow-y:scroll;
				font-family: Monaco, Consolas, "Andale Mono", "DejaVu Sans Mono", monospace;
				font-size: 95%;
				line-height: 140%;
				background: #faf8f0;
			}
		</style>
		<script>
		var shown = false;
		
			function toggleShow(){
				if(shown){
					$('.example').hide();
					$('#showExample').text("Show example data format");
				} else{
					$('.example').show();
					$('#showExample').text("Hide example data format");
				}
				shown = !shown;
			}
		</script>
		<title>Inçnet | Exam Schedule</title>
	</head>
	
	<body>
		<div class='header'>
						&nbsp;&nbsp;
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:180px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<br><div style="width. 100%; text-align: center;"><a href='../incnet'><img src='/img/exam-schedule.png' width='135px'></a></div><br>
					<?php
	/*					
						if(isset($_GET['p'])){
							echo "<a href=\"?\" style=\"color: black;\">Default</a><br/>"; 		
							if($_GET['p'] == "edit" && check_permission(11)){
								if(isset($_POST['editSchedule'])){
									$rows = "10";
								} else{
									$rows = "40";
								}
								$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								$content = "
									<b style=\"font-size: 15pt;\">Edit Exam Schedule</b>
									<form action=# method=POST>".
									"<div class=example><br/>	
										[{<br/>
										$tab\"exams\": [{<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}]<br/>
										$tab}, {<br/>
										$tab\"exams\": [{<br/>
										$tab$tab\"exam\": \"English Exam\",<br/>
										$tab$tab\"location\": \"Etut Salonu\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Biology Exam\",<br/>
										$tab$tab\"location\": \"Etut Salonu\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Biology Exam\",<br/>
										$tab$tab\"location\": \"Etut Salonu\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Biology Exam\",<br/>
										$tab$tab\"location\": \"Etut Salonu\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Biology Exam\",<br/>
										$tab$tab\"location\": \"Etut Salonu\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}]<br/>
										$tab}, {<br/>
										$tab\"exams\": [{<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}]<br/>
										$tab}, {<br/>
										$tab\"exams\": [{<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}]<br/>
										$tab}, {<br/>
										$tab\"exams\": [{<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}, {<br/>
										$tab$tab\"exam\": \"Etüt\",<br/>
										$tab$tab\"location\": \"11 nolu sınıf\",<br/>
										$tab$tab\"time\": \"2017-04-03\"<br/>
										$tab}]<br/>
										}]
									</div><span id=findMe><a style=\"color: red;\"href=# id=showExample onclick=toggleShow()>Show example data format</a></span>" 
									."
										<br/><label for=schedule>Enter New Schedule</label><br>
										<textarea rows=$rows cols=150 name=schedule id=schedule>";
									if(isset($_POST['editSchedule']) && check_permission(11))
										$content.=$_POST['schedule'];
									$content.="</textarea><br/>
									<input type=Submit name=editSchedule value=Go>
								</form>";
							} else if($_GET['p'] == "view" && check_permission(12)){
								$content = "
									<b style=\"font-size: 15pt;\">View Exam Schedule As User</b>
								";
							}
						} else{
							include("db_connect.php");
							$content = 
								"
								<b style=\"font-size: 15pt;\">Exam Schedule</b>
								<table>
								<tr><th>Event</th><th>Location</th><th>Date</th><th>Time</th></tr>
								";
							
					
							$sql = "SELECT * FROM exams WHERE exams.class=10";
							$result = mysql_query($sql);
							while($row = mysql_fetch_assoc($result)){
								$content .= "<tr><td>".htmlspecialchars($result['name'])."</td><td>".htmlspecialchars($result['location'])."</td><td>".htmlspecialchars($result['date'])."</td><td>".htmlspecialchars($result['time'])."</td></tr>";
							}
							$content.="</table>";
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
							
							if(isset($_POST['editSchedule']) && check_permission(11)){
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
							$decodeda = json_decode($_POST['schedule'], true);
							$days = array(
								"Monday",
								"Tuesday",
								"Wednesday",
								"Thursday",
								"Friday",
								"Saturday",
								"Sunday"
							);
							
							$classes = array(
								"Prep",
								"9",
								"10",
								"11",
								"12"
							);
							
							$sql = "INSERT INTO exams(id, name, location, time, class) VALUES";
							$weeks = count($decodeda);
							for($weekCounter = 1; ($weekCounter - 1) < $weeks; $weekCounter++){
								$decoded = $decodeda[$weekCounter - 1]['week'];
								echo "<h1>Week $weekCounter</h1>";
								for($i = 0; $i < 5; $i++){
									echo "<h2>".$days[$i]."</h2>";
									for($in = 0; $in < 5; $in++){
										switch($in){
											case 0:
												$class = "Prep";
												break;
											case 1:
												$class = "9";
												break;
											case 2:
												$class = "10";
												break;
											case 3:
												$class = "11";
												break;
											case 4:
												$class = "12";
												break;
										}
										$sql.="(0, '".$decoded[$i]['exams'][$in]['exam']."', '".$decoded[$i]['exams'][$in]['location']."', '".$decoded[$i]['exams'][$in]['time']."', '".$class."')";
										if($i < 4 || $in < 4) $sql.=",";
										echo("<h3>".$classes[$in]."</h2>");
										echo("<b>Exam: </b>".$decoded[$i]['exams'][$in]['exam']."<br/>");
										echo("<b>Location: </b>".$decoded[$i]['exams'][$in]['location'])."<br/>";
										echo("<b>Time: </b>".$decoded[$i]['exams'][$in]['time']);
									}
								}
							}
							echo(
								"
									<form action=# method=POST>
										<br/><br/><br/>
										Is this ok? (Note that this will delete the old schedule permanentely)<br/>
										<button value=go name=ok>Yes, upload</button>
										<button name=cancel>No, delete</button>
										<input type=hidden name=sql value=\"$sql\">
									</form>
								"
							);
						}
						
						if(isset($_POST['ok'])  && check_permission(11) && isset($_POST['sql'])){
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
							
							$conn -> query("TRUNCATE TABLE exams");
							//$conn -> query($_POST['sql']); //WTF?! Don't do this!
						} */
						?>
						
					<br><br><br>
				</td>
				<td><?php header("location: https://docs.google.com/spreadsheets/d/1q0o1Vzdn_l_pHynKNQMi_b3bhJFLRbJvIBFA9lm_9VQ"); ?> If you are not redirected, click <a href=https://docs.google.com/spreadsheets/d/1q0o1Vzdn_l_pHynKNQMi_b3bhJFLRbJvIBFA9lm_9VQ/edit#gid=1121163015> here </a>.</td>
			</tr>
		</table>
		
		<div class="copyright">&nbsp &copy; INÇNET</div>
	</body>
</HTML>

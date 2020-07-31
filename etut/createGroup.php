<?PHP
	error_reporting(0);
	//connect to mysql server
	include ("../db_connect.php");
	include ("functions.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("incnet");
	
	$today = date("Y-m-d");
	
	require_once '../mobile_detect/Mobile_Detect.php';
	$detect = new Mobile_Detect;
	if ( $detect->isMobile() ) {
	  echo	"<meta http-equiv='refresh' content='0; url=../mobile/etut.php'>";
	}	
	session_start();
	if (!(isset($_SESSION['user_id']))){
		$newPage = "<meta http-equiv='refresh' content='0; url=../incnet/login.php'>";
	}
	if (isset($_POST['logoff'])){
		session_destroy();
		$newPage = "<meta http-equiv='refresh' content='0; url=../incnet/index.php'>";
	}
	if(isset($_POST['addUser'])){
		$sql = "SELECT group_id FROM etut_groups WHERE owner_id=$_SESSION[user_id] AND date='$today' ORDER BY group_id DESC";
		$res = mysql_query($sql) or die(mysql_error()."<br/>".$sql);
		$row = mysql_fetch_assoc($res);
		$group_id = $row['group_id'];
		$sql = "INSERT INTO etut_group_joins(join_id, group_id, user_id) VALUES (0, $group_id, $_POST[addUser])";
		mysql_query($sql) or die(mysql_error()."<br/>".$sql);
	}
	if(isset($_POST['next'])){
		$sqlDelete = "DELETE FROM etut_groups WHERE `owner_id`=$_SESSION[user_id] AND date='$today'";
		echo("<pre><!--$sqlDelete--></pre>");
		mysql_query($sqlDelete) or die(mysql_error());
		$sql = "INSERT INTO `incnet`.`etut_groups` (`group_id`, `room`, `owner_id`, `date`) VALUES ('0', '$_POST[room]', '$_SESSION[user_id]', '$today')";
		mysql_query($sql);
	}
?>

<!doctype html>
<HTML>
	<head>
		<?PHP
			if ($newPage!=''){
				echo $newPage;
			}
			
			$rooms = array("Test 1", "Test 2", "Test 3");
			
		?>
		<link rel="shortcut icon" href="../../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<title>INÇNET | Create Study Group</title>
		<style>
			.hidden{
				display: none;
			}
		</style>
	</head>
  
	
	<body OnLoad="document.reservations.seat.focus();">
		<div class="header">
			<?PHP echo $fullname; ?>
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='../../incnet'><img style='position: relative; top:20px;' src='../../img/etut.png' width='140px'></a>
				</td>
				<div style='position:absolute; bottom:30px; z-index:2;' >
					<form name="logoff" method="POST">
						<input type ="submit" name="logoff" value="Log Off">
					</form>
				</div>
				<td valign='top' style='padding:7px; padding-top:30px;'>
					<div class=titleDiv>Create Study Group</div>
					<br/>
					<form <?php if(isset($_GET['page']) && $_GET['page'] != 1) echo("class=hidden");?> action="?page=2" method=POST>
						<label for="room">Select room to study in</label>
						<select name=room>
							<?php foreach($rooms as $room) echo("<option value=".spacesToCamelCase($room).">$room</option>"); ?>
						</select><br/>
						<input type=Submit value=Next name=next />
					</form>
					<form <?php if($_GET['page'] != 2) echo("class=hidden");?> method=POST action="?page=2" ><br>
						<input type=hidden name=room value="<?=htmlspecialchars($_POST['room']) ?>">
						Add people to you study group at <? echo("<span style='color: #c1272d;'>".ucwords(camelCaseToSpaces(htmlspecialchars($_POST['room'])))."</span>"); ?>
						<br/><br/>
						<input type='text' name='searchKey' style='border:1px solid black; width:150px'>&nbsp
						<input type='submit' name='search' value='Find!' style='width:70px; background-color: transparent; border:1px solid black'>
					<?PHP
						if ((isset($_POST['search']))&&($_POST['searchKey']!='')){
							$searchKey = $_POST['searchKey'];
							$query = mysql_query("SELECT user_id, name, lastname, class FROM incnet.coreUsers WHERE name LIKE '%$searchKey%' OR lastname LIKE '%$searchKey%' AND (type LIKE 'student' AND class NOT LIKE 'grad' AND class NOT LIKE '13' AND class NOT LIKE 'afs' AND class NOT LIKE 'uwc')");
							//echo $query;
							while($row = mysql_fetch_array($query)){
								$addUser = $row[0];
								$name = $row[1];
								$lastname = $row[2];
								$class = $row[3];
								echo "<div style='height:5px'></div><form method='POST'><input type='hidden' name='addUser' value='$addUser'><input type=hidden name=room value=$_POST[room]><input type='submit' name='add' value='Add' style='width:60px; height:20px; background-color: transparent; border:1px solid green; color:green'>  $name $lastname (class: $class)</form>";
							}
						}
					?>
					</form>
					<div>
						<h1>People in your study group</h1>
						<table>
						<?php
							$sql = "SELECT name, lastname, student_id FROM coreusers WHERE user_id IN (SELECT user_id FROM etut_group_joins WHERE group_id=(SELECT group_id FROM  `etut_groups` WHERE  `owner_id`=$_SESSION[user_id] AND  `date`= '$today'))";
							echo $sql;
							$res = mysql_query($sql) or die(mysql_error()."<br/>".$sql);
							while($row = mysql_fetch_assoc($res)){
								echo"<tr><td>$row[name] $row[lastname]</td></tr>";
							}
						?>
						</table>
					</div>
				</td>
			</tr>
		</table>
		
		<div class="copyright">&nbsp © INCNET</div>
    <p style="display:none;"><? echo $msg; ?></p>
	</body>
</HTML>
	
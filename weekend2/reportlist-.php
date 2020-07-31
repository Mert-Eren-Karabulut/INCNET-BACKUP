<?PHP
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:../incnet/login.php");
	}
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$lang = $_SESSION['lang'];
	if (isset($_POST['logoff'])){
		session_destroy();
		setcookie("remember", "", time()-3600);
		header("location:../incnet/login.php");
	}
	
	include ("db_connect.php");
	$con;
	if (!$con){
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("incnet");
	
	$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
	while($permit_row = mysql_fetch_array($permit_query)){
		$allowed_pages[] = $permit_row['page_id'];
	}
	$teacher_query = mysql_query("SELECT student_id FROM incnet.coreUsers WHERE user_id='$user_id'");
	while($teacher_row = mysql_fetch_array($teacher_query)){
		$student_id = $teacher_row['student_id'];
	}
	//week name array$week_name = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
	//state array$state_array = array("closed", "open");
?>
<!DOCTYPE html>
<HTML>
	<head>
		<title>Inçnet | Weekend Departures</title>
		<link rel="shortcut icon" href="favicon.ico" >
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script>
			$(function(){
				$('select[name=bus_and_leave]')[0].value = <?php echo(htmlspecialchars($_POST['bus_and_leave'])); ?>;
			});
		</script>
		<style>
			td[valign=middle] table, td[valign=middle] table tr, td[valign=middle] table td, td[valign=middle] table th{
				border: 1pt solid black;
			}
		</style>
	</head>
	<body>
		<div class="top_menubar">
			<?PHP echo $fullname; ?>
		</div>
		<br><br>
		<div class="page_logo_container">
			<table>
				<tr>
					<td style="vertical-align: top; padding-top: 1%;">
						<a href="index.php"><img src="weekend.png" style="margin-bottom: 10%;" width="120px" border=0 /></a><br>
						<a href="printable_bus_lists.php" style="color:black;">Printable Form</a>
					</td>
					<td width="5px"></td>
					<td bgcolor="black" width=0.1px>
						<td width="3px"></td>
						<td valign="middle">
							<h3>Report List</h3>
								<form action=# method=GET>
									<select name="bus_and_leave">
										<?php
											$sql = "SELECT * FROM weekend2busses ORDER BY bus_name ASC";
											
											$res = mysql_query($sql) or die(mysql_error()." $sql");
											
											while($row = mysql_fetch_assoc($res)){
												echo("<option value=b$row[bus_id]>$row[bus_name]");
												$last_part_dep = substr($row['bus_name'], mb_strlen($row['bus_name']) - 9);
												$last_part_arr = substr($row['bus_name'], mb_strlen($row['bus_name']) - 7);
												if($last_part_dep != "Departure" && $last_part_arr != "Arrival" && $row['direction'] != 2){
													echo(" ");
													echo(($row['direction'] == 0) ? "Departure" : "Arrival");
												}
												echo("</option>");
											}
											
											$sql = "SELECT * FROM weekend2leaves ORDER BY leave_name ASC";
											
											$res = mysql_query($sql) or die(mysql_error()." $sql");
											
											while($row = mysql_fetch_assoc($res)){
												if($row['leave_id'] == 5)
													continue;
												echo("<option value=l$row[leave_id]>".($row['leave_name'] == "Kadıköy" ? "Sunday Kadıköy" : $row['leave_name']));
												echo("</option>");
											}
										?>
									</select>
									<input type=Submit value=Filter>
									<br/>
									<?php
										if(isset($_GET['bus_and_leave'])){
											$id = substr($_GET['bus_and_leave'], 1);
											$kind = substr($_GET['bus_and_leave'], 0, 1);
										
										
											$table = ($kind == "b" ? "busses" : "leaves");
											$field = ($kind == "b" ? "bus" : "leave");
											$row['kind'] = $kind;
											$sql = "SELECT * FROM coreusers, weekend2departures, weekend2".$table.", weekend2".($kind == "b" ? "leaves" : "busses")." WHERE weekend2departures.".$field."_id=$id AND weekend2departures.user_id = coreusers.user_id AND weekend2leaves.assoc_busses = weekend2busses.bus_id AND ";
											
											if(kind == b){
												$sql .= "(weekend2busses.bus_id = $id AND weekend2leaves.bus_id = $id)";
											}else{
												$sql.= "(weekend2departures.leave_id = weekend2leaves.leave_id)";
											}
											$res = mysql_query($sql) or die("ERROR: ".mysql_error()." $sql");
											$i = 0;
											while($row = mysql_fetch_assoc($res)){
												if($row['active'] != 1)
													continue;
												$rows[] = $row;
											}
										}
									?>
								</form>
								<br/><br/>
								<table <?php echo($rows ? "" : "style=\"display: none;\""); ?>>
									<tr>
										<th>Name</th><th>Lastname</th><th>Student ID</th><th>Class</th><th>Dorm</th><th>Bus / Leave</th>
									</tr>
									<?php
										foreach($rows as $row){
											echo("<tr><td>$row[name]</td><td>$row[lastname]</td><td>$row[student_id]</td><td>$row[class]</td><td>$row[dormroom]</td><td>".$row[(($row['kind'] == "b") ? "bus_name" : "leave_name")]."</td></tr>");
										}
									?>
								</table>
						</td>
				</tr>
			</table>
		</div>
		<br><br><br>
		<div class="logoff_button">
			<form name="logoff" method="POST">
				<input type ="submit" name="logoff" value="Log Off">
			</form>
		</div>
		<div class="copyright">
			<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2017 INCNET</a>
		</div>
	</body>
</HTML>
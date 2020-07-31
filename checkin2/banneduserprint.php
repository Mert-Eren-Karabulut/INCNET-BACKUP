<!DOCTYPE HTML>
<html>
	<head>
		<meta charset=UTF-8>
	</head>
	<body>
		<style>
			.bannedlist{
				border: 1pt solid black;
			}
		</style>
		<table class=bannedlist>
		<tr class=bannedlist><th class=bannedlist>Name</th><th class=bannedlist style="width: 130px;">Event Banned</th><th class=bannedlist>Class</th></tr>
		<?php
			//connect to mysql server
			include ("../db_connect.php");
			if (!$con){
			  die('Could not connect: ' . mysql_error());
		  }
			mysql_select_db("incnet");

		$sql = "SELECT * FROM checkin2bans";
									$query = mysql_query($sql);
									while($row = mysql_fetch_assoc($query)){
										$sql2 = "SELECT * FROM checkin2events WHERE (event_id=".mysql_real_escape_string($row['event_id']).")";
										$user = $row['user_id'];
										$query2 = mysql_query("SELECT * FROM coreusers WHERE user_id=$user");
										$query3 = mysql_query($sql2);
										$row3 = mysql_fetch_assoc($query3);
										while($row2 = mysql_fetch_assoc($query2)){
											$eventname = $row3['title'];
											$fullnameofbanned = $row2['name']." ".$row2['lastname'];
											$classofbanned = $row2['class'];
											if($row2['type'] != "student")
												$classofbanned = "--";
											echo "
												<tr class=bannedlist>
													<td class=bannedlist>$fullnameofbanned</td>
													<td class=bannedlist>$eventname</td>
													<td class=bannedlist>$classofbanned</td>
												</tr>
											";
										}
									}
		?>
		</table>
	</body>
</html>
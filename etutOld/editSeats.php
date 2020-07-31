<?PHP
	error_reporting(0);
	
	
	//connect to mysql server
	include ("../db_connect.php");
	include ("functions.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
  
	session_start();
	if (!(isset($_SESSION['user_id']))){
		$newPage = "<meta http-equiv='refresh' content='0; url=../incnet/login.php'>";
	}
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$lang = $_SESSION['lang'];
	
	if (isset($_POST['logoff'])){
		session_destroy();
		$newPage = "<meta http-equiv='refresh' content='0; url=../incnet/index.php'>";
	}
	
	mysql_select_db("incnet");
	
	if (checkAdmin($user_id)==0){
		$newPage = "<meta http-equiv='refresh' content='0; url=index.php'>";
	}

	if (isset($_POST['save'])){
		$user = $_POST['user'];
		$newRoom = $_POST['room'];
		$newSeat = $_POST['seat'];
		$newExtra = $_POST['extraHrs'];
		mysql_query("DELETE FROM etut_defaultSeats WHERE user_id=$user");
		mysql_query("INSERT into etut_defaultSeats VALUES ($user, '$newRoom', '$newSeat')");
		
		mysql_query("DELETE FROM etut_extrahours WHERE user_id=$user");
		$newExtra = $newExtra-5;
		mysql_query("INSERT into etut_extrahours VALUES ($user, $newExtra)");
	}
	
	
?>

<!doctype html>
<HTML>
	<head>
		<?PHP
			if ($newPage!=''){
				echo $newPage;
			}
		?>
		<link rel="shortcut icon" href="../../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	</head>
	
	<body OnLoad="document.reservations.seat.focus();">
		<div class="header">
			<?PHP echo $fullname; ?>
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='index.php'><img style='position: relative; top:20px;' src='../../incnet/incnet.png' width='140px'></a>
				</td>
				<div style='position:absolute; bottom:30px; z-index:2;' >
					<form name="logoff" method="POST">
						<input type ="submit" name="logoff" value="Log Off">
					</form>
				</div>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<br>
					<table>
						<tr>
							<td style='color:#c1272d; font-weight:bold'>Name</td>
							<td style='color:#c1272d; font-weight:bold'>Lastname</td>
							<td style='color:#c1272d; font-weight:bold'>Rooom</td>
							<td style='color:#c1272d; font-weight:bold'>Seat</td>
							<td style='color:#c1272d; font-weight:bold'>Computer Hours</td>
						</tr>
						<?PHP
							$sql = "SELECT coreUsers.user_id, coreUsers.name, coreUsers.lastname FROM coreUsers WHERE coreUsers.type='student' AND coreUsers.class != 'Grad' ORDER BY coreUsers.lastname";
							$query=mysql_query($sql);
							while ($row=mysql_fetch_array($query)){
								$user=$row[0];
								$name=$row[1];
								$lastname=$row[2];
								
								$sql2 = "SELECT room, seat FROM etut_defaultSeats WHERE user_id=$user";
								$query2=mysql_query($sql2);
								$room='';
								$seat='';
								while ($row2=mysql_fetch_array($query2)){
									$room = $row2[0];
									$seat = $row2[1];
								}
								
								$sql3 = "SELECT hours FROM etut_extrahours WHERE user_id=$user";
								$query3=mysql_query($sql3);
								$extra='';
								while ($row3=mysql_fetch_array($query3)){
									$extra = $row3[0];
								}
								$extra = $extra+5;
								
								echo"
								<tr>
									<form method='POST'>
									<input type='hidden' name='user' value='$user'>
									<td>$name</td>
									<td>$lastname</td>
									<td>
										<select name='room'>
											<option value=''></option>";
											
											echo "<option value='lib'";
											if ($room=='lib'){echo "selected='selected'";}
											echo ">Library</option>";
											
											echo "<option value='etut'";
											if ($room=='etut'){echo "selected='selected'";}
											echo ">Study Hall</option>";
											
											echo "<option value='year'";
											if ($room=='year'){echo "selected='selected'";}
											echo ">Year</option>";
											
											echo "<option value='class'";
											if ($room=='class'){echo "selected='selected'";}
											echo ">Classroom</option>";
										echo "</select>
									</td>
									<td><input type='text' name='seat' maxlength='4' style='width:40px' value='$seat'></td>
									<td style='text-align:center'><input type='text' name='extraHrs' maxlength='4' style='width:40px' value='$extra'></td>
									<td><input type='submit' name='save' value='Save'></td>
									</form>
								</tr>";
							}
						?>
					
					</table><div style='height: 20px'></div>
				</td>
			</tr>
		</table>
		
		<div class="copyright">&nbsp © INCNET</div>
	</body>
</HTML>









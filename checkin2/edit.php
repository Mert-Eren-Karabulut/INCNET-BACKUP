<?PHP
	error_reporting(0);

	//connect to mysql server
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }

	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:login.php");
	}
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$lang = $_SESSION['lang'];

	//permissions
	$page_id = "201";
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:../../incnet/login.php");
	}
	$user_id = $_SESSION['user_id'];

	$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='$page_id'");
	while($permit_row = mysql_fetch_array($permit_query)){
		$allowance = "1";
	}
	if ($allowance != "1"){
		header ("location:../../incnet/login.php");
	}

	if (!(isset($_GET['editEvent']))){
		$page = "index.php";
	}else{
		$thisId = $_GET['editEvent'];
	}

	$sql = "SELECT checkin2Events.event_id, checkin2Events.admin, checkin2Events.date ,checkin2Events.title ,checkin2Events.departureTime ,checkin2Events.eventTime ,checkin2Events.returnTime ,checkin2Events.details ,checkin2Events.location ,checkin2Events.deadlineDay ,checkin2Events.deadlineHour ,checkin2Events.quota ,checkin2Events.approved, checkin2Events.class ,coreUsers.name, coreUsers.lastname FROM incnet.checkin2Events, incnet.coreUsers WHERE event_id='$thisId' AND coreUsers.user_id = checkin2Events.admin";
	//echo $sql;
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		$adminId = $row['admin'];
		$admin = $row['name'] . " " . $row['lastname'];
		$date = $row['date'];
			$date = explode("-", $date);
			$day = $date[2];
			$year = $date[0];
			$month = $date[1];
		$title = $row['title'];
		$departTime = $row['departureTime'];
		$eventTime = $row['eventTime'];
		$returnTime = $row['returnTime'];
		$details = $row['details'];
$details = explode("<br>", $details);
$details = implode("
", $details);
		$location = $row['location'];
		$deadline = $row['deadlineDay'];
		$deadline = explode("-", $deadline);
			$deadDay = $deadline[2];
			$deadYear = $deadline[0];
			$deadMonth = $deadline[1];
		$deadlineHour = $row['deadlineHour'];
		$quota = $row['quota'];
		$class = $row['class'];
		$class = explode("," , $class);
		$today = date("Y-m-d");

	}

		if (isset($_POST['approve'])){
			$title = $_POST['title'];
			$date = $_POST['dateYear'] . "-" . $_POST['dateMonth'] . "-" . $_POST['dateDay'];
			$departureTime = $_POST['departTime'];
			$eventTime = $_POST['eventTime'];
			$returnTime = $_POST['returnTime'];
			$details = $_POST['details'];
			$details = explode(PHP_EOL, $details);
			$details = implode("<br>",$details);
			$location = $_POST['location'];
			$deadline = $_POST['deadlineYear'] . "-" . $_POST['deadlineMonth'] . "-" . $_POST['deadlineDay'];
			$deadlineTime = $_POST['deadlineTime'];
			$quota = $_POST['quota'];
			$forbidden_id = $_POST['forbidden'];
			$class = $_POST['classPr'] . "," . $_POST['class9'] . "," . $_POST['class10'] . "," . $_POST['class11IB'] . "," . $_POST['class11MEB'] . "," . $_POST['class12IB'] . "," . $_POST['class12MEB'] . "," . $_POST['classT'] . "," . $_POST['classPe'];

			mysql_query("DELETE from incnet.checkin2Events WHERE event_id = $thisId");
			$query = "INSERT into incnet.checkin2Events VALUES ('$thisId','$adminId','$date','$title','$departureTime','$eventTime','$returnTime','$details','$location','$deadline','$deadlineTime','$quota','$today','$class','$forbidden_id')";
			mysql_query($query);
			echo $query;
			$page = "selectEdit.php";
		}

		if(isset($_POST['reject'])){
			mysql_query("DELETE from incnet.checkin2Events WHERE event_id = $thisId");
			mysql_query("DELETE from incnet.checkin2Joins WHERE event_id = $thisId");
			$page = "selectEdit.php";
		}

		$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
	while($permit_row = mysql_fetch_array($permit_query)){
		$allowed_pages[] = $permit_row['page_id'];
	}
	?>

<!doctype html>
<HTML>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<body OnLoad="init();">
		<?PHP
			if ($page!=''){
				echo " <meta http-equiv='refresh' content='0; url= $page '> ";
			}
		?>


		<script>

			function init(){
				document.event.title.focus();
				<?PHP
					if ($error!=''){ echo "alert('$error')"; }
				?>
				;
			}
			function isGoodKey(evt){
				var charCode = (evt.which) ? evt.which : event.keyCode
				var charCode = evt.which || evt.keyCode;
				var charTyped = String.fromCharCode(charCode);
				var myChars = new Array("A","B","C","Ç","D","E","F","G","Ğ","H","I","İ","J","K","L","M","N","O","Ö","P","R","S","Ş","T","U","Ü","V","Y","Z","1","2","3","4","4","5","6","7","8","9","0",",",":",".","/","a","b","c","ç","d","e","f","g","ğ","h","ı","i","j","k","l","m","n","o","ö","p","r","s","ş","t","u","ü","v","y","z","Q","q","W","w","x","X"," ","@");

				if((myChars.indexOf(charTyped) != -1)||(charCode==8)||(charCode==13)||(charCode==9)){
					return true;
				}else{
					return false;
				}

			}
		</script>
	</head>

	<body>
		<div class='header'>
			<?PHP echo $fullname;?>
			&nbsp&nbsp
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<br><a href='selectEdit.php'><image src='red.png' width='135px'></a><br>
					<br>
					<?PHP
						if (in_array("201", $allowed_pages)) {
							echo "<a style='color:black' href='createEvent.php'> Create Event </a><br>";
						}
						if (in_array("232", $allowed_pages)) {
							echo "<a style='color:black' href='waiting.php'> Approve Events </a><br>";
						}
						if (in_array("201", $allowed_pages)) {
							echo "<a style='color:black' href='getList.php'> View Lists </a><br>";
						}
					?>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<div class='titleDiv'>
						<br>
						Editing:
					</div>
					<hr><br>
					<form method='post' name='event'>
						<table>
							<tr>
								<td style='padding:6px;'>Title</td>
								<td style='padding:6px;'><input type='text' name='title' maxlength='100' onkeypress='return isGoodKey(event)' style='height:20px; background-color: transparent; border:1px solid black;' value='<?PHP echo $title; ?>'> By <i> <?PHP echo $admin; ?></i></td>
							</tr>
							<tr>
								<td style='padding:6px;'>Date</td>
								<td style='padding:6px;'>
									<input type="text" size="2" maxlength="2" name="dateDay" style='height:20px; background-color: transparent; border:1px solid black;' value='<?PHP echo $day; ?>'>
									<select name="dateMonth">
										<option value= "01" <?PHP if($month==1) { echo "selected='yes'"; } ?> >January</option>
										<option value= "02" <?PHP if($month==2) { echo "selected='yes'"; } ?> >February</option>
										<option value= "03" <?PHP if($month==3) { echo "selected='yes'"; } ?> >March</option>
										<option value= "04" <?PHP if($month==4) { echo "selected='yes'"; } ?> >April</option>
										<option value= "05" <?PHP if($month==5) { echo "selected='yes'"; } ?> >May</option>
										<option value= "06" <?PHP if($month==6) { echo "selected='yes'"; } ?> >June</option>
										<option value= "07" <?PHP if($month==7) { echo "selected='yes'"; } ?> >July</option>
										<option value= "08" <?PHP if($month==8) { echo "selected='yes'"; } ?> >August</option>
										<option value= "09" <?PHP if($month==9) { echo "selected='yes'"; } ?> >September</option>
										<option value= "10" <?PHP if($month==10) { echo "selected='yes'"; } ?> >October</option>
										<option value= "11" <?PHP if($month==11) { echo "selected='yes'"; } ?> >November</option>
										<option value= "12" <?PHP if($month==12) { echo "selected='yes'"; } ?> >December</option>
									</select>
									<input type="text" size="4" maxlength="4" name="dateYear" style='height:20px; background-color: transparent; border:1px solid black;' value='<?PHP echo $year; ?>'>&nbsp&nbsp*(Day/Month/Year)
								</td>
							</tr>
							<tr>
								<td style='padding:6px;'>Departure Time</td>
								<td style='padding:6px;'>
									<input type='text' name='departTime' maxlength='5' size='5' style='height:20px; background-color: transparent; border:1px solid black;' value='<?PHP echo $departTime; ?>'>&nbsp&nbsp*(HH:MM)
								</td>
							</tr>
							<tr>
								<td style='padding:6px;'>Event Time</td>
								<td style='padding:6px;'>
									<input type='text' name='eventTime' maxlength='5' size='5' style='height:20px; background-color: transparent; border:1px solid black;'  value='<?PHP echo $eventTime; ?>'>&nbsp&nbsp*(HH:MM)
								</td>
							</tr>
							<tr>
								<td style='padding:6px;'>Return Time</td>
								<td style='padding:6px;'>
									<input type='text' name='returnTime' maxlength='5' size='5' style='height:20px; background-color: transparent; border:1px solid black;'  value='<?PHP echo $returnTime; ?>'>&nbsp&nbsp*(HH:MM)
								</td>
							</tr>
							<tr>
								<td valign='top' style='padding:6px;'>Details</td>
								<td style='padding:6px;'><textarea rows='6' cols='30' name='details' onkeypress='return isGoodKey(event)' style='height:140px; background-color: transparent; border:1px solid black;'> <?PHP echo $details; ?></textarea></td>
							</tr>
							<tr>
								<td style='padding:6px;'>Location</td>
								<td style='padding:6px;'><input type='text' name='location' maxlength='100' onkeypress='return isGoodKey(event)' style='height:20px; background-color: transparent; border:1px solid black;' value='<?PHP echo $location; ?>'></td>
							</tr>
							<tr>
								<td style='padding:6px;' style='padding:6px;'>Deadline</td>
								<td style='padding:6px;'>
									<input type="text" size="2" maxlength="2" name="deadlineDay" style='height:20px; background-color: transparent; border:1px solid black;' value='<?PHP echo $deadDay; ?>'>
									<select name="deadlineMonth">
										<option value= "01" <?PHP if($deadMonth==1) { echo "selected='yes'"; } ?> >January</option>
										<option value= "02" <?PHP if($deadMonth==2) { echo "selected='yes'"; } ?> >February</option>
										<option value= "03" <?PHP if($deadMonth==3) { echo "selected='yes'"; } ?> >March</option>
										<option value= "04" <?PHP if($deadMonth==4) { echo "selected='yes'"; } ?> >April</option>
										<option value= "05" <?PHP if($deadMonth==5) { echo "selected='yes'"; } ?> >May</option>
										<option value= "06" <?PHP if($deadMonth==6) { echo "selected='yes'"; } ?> >June</option>
										<option value= "07" <?PHP if($deadMonth==7) { echo "selected='yes'"; } ?> >July</option>
										<option value= "08" <?PHP if($deadMonth==8) { echo "selected='yes'"; } ?> >August</option>
										<option value= "09" <?PHP if($deadMonth==9) { echo "selected='yes'"; } ?> >September</option>
										<option value= "10" <?PHP if($deadMonth==10) { echo "selected='yes'"; } ?> >October</option>
										<option value= "11" <?PHP if($deadMonth==11) { echo "selected='yes'"; } ?> >November</option>
										<option value= "12" <?PHP if($deadMonth==12) { echo "selected='yes'"; } ?> >December</option>
									</select>
									<input type="text" size="4" maxlength="4" name="deadlineYear" style='height:20px; background-color: transparent; border:1px solid black;' value='<?PHP echo $deadYear; ?>'>&nbsp&nbsp*(Day/Month/Year)&nbsp&nbsp&nbsp&nbsp
								</td>
								<td style='padding:6px;'>
									<input type='text' name='deadlineTime' maxlength='2' size='2' style='height:20px; background-color: transparent; border:1px solid black; text-align:right' value='<?PHP echo $deadlineHour; ?>'>:00&nbsp&nbsp*(HH:MM)
								</td>
							</tr>
							<tr>
								<td style='padding:6px;'>Quota</td>
								<td style='padding:6px;'><input type="text" size="4" maxlength="4" name="quota" style='height:20px; background-color: transparent; border:1px solid black;'  value='<?PHP echo $quota; ?>'></td>
							</tr>
							<tr>
								<td>Open to</td>
								<td>
									<input type='checkbox' name='classPr' value='Pr' <?PHP if(in_array("Pr", $class)){ echo "checked='checked'"; }?>>Preps
									<input type='checkbox' name='class9' value='9'  <?PHP if(in_array("9", $class)){ echo "checked='checked'"; }?>>9
									<input type='checkbox' name='class10' value='10'  <?PHP if(in_array("10", $class)){ echo "checked='checked'"; }?>>10
									<input type='checkbox' name='class11IB' value='11IB'  <?PHP if(in_array("11", $class) || in_array("11IB", $class)){ echo "checked='checked'"; }?>>11 IB
									<input type='checkbox' name='class11MEB' value='11MEB'  <?PHP if(in_array("11", $class) || in_array("11MEB", $class)){ echo "checked='checked'"; }?>>11 MEB
									<input type='checkbox' name='class12IB' value='12IB'  <?PHP if(in_array("12", $class) || in_array("12IB", $class)){ echo "checked='checked'"; }?>>12 IB
									<input type='checkbox' name='class12MEB' value='12MEB'  <?PHP if(in_array("12", $class) || in_array("12MEB", $class)){ echo "checked='checked'"; }?>>12 MEB
									<input type='checkbox' name='classT' value='T'  <?PHP if(in_array("T", $class)){ echo "checked='checked'"; }?>>Teacher
									<input type='checkbox' name='classPe' value='Pe'  <?PHP if(in_array("Pe", $class)){ echo "checked='checked'"; }?>>Personnel
								</td>
							</tr>
														<tr>
								<td>
									Forbid This Event To<br>Attendants Of
								</td>
								<td>
									<select name="forbidden">
										<option value="<? echo $forbidden_to; ?>" selected>
										<?
											$forbidden_sql = "SELECT title FROM incnet.checkin2Events WHERE event_id='$forbidden_to'";
											$forbidden_result = mysql_query($forbidden_sql);
											while($row2 = mysql_fetch_array($forbidden_result))
											{
												echo $row2['title'];
											}
										?>
										</option>
										<?php

											$forbidden_sql = "SELECT event_id, title FROM incnet.checkin2Events ORDER BY date DESC LIMIT 20";
											$forbidden_result = mysql_query($forbidden_sql);
											while($forbidden_row = mysql_fetch_array($forbidden_result))
											{
												echo "<option value='$forbidden_row[0]'>$forbidden_row[1]</option>";
											}
										?>
									</select>
								</td>
							</tr>

							<tr>
								<td></td>
								<td><br>
									<input type='submit' name='approve' value='Save' style='width:156px; height:20px; background-color: transparent; border:1px solid green; color:green'>
									<button type='button' onclick="$('#RUSure').show();" name='reject' value='Delete' style='width:156px; height:20px; background-color: transparent; border:1px solid red; color:red'>Delete</button>
								</td>
							</tr>
						</table>
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
						<div id=RUSure style="display: none; position: fixed; text-align: center; horizontal-align: middle; padding: 30px; background-color: white; border: 2pt solid black; margin: 0 auto; width: 700px;">
							<p>
								Are you sure you want to delete this event?<br/>You cannot undo this action.
							</p>
							<button type=button onclick="$('#RUSure').hide();">Cancel</button> <input type=Submit name=reject value="Delete">
						</div>
					</form>
					<br><br><br>
				</td>
			</tr>
		</table>

		<div class="copyright">&nbsp © INÇNET</div>
	</body>

</HTML>

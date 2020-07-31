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

	//echo $user_id;
	$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='$page_id'");
	while($permit_row = mysql_fetch_array($permit_query)){
		$allowance = "1";
	}
	if ($allowance != "1"){
		header ("location:../../incnet/login.php");
	}

	$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
	while($permit_row = mysql_fetch_array($permit_query)){
		$allowed_pages[] = $permit_row['page_id'];
	}
	if (isset($_POST['submit'])){
		$title = $_POST['title'];
		$date = $_POST['dateYear'] . "-" . $_POST['dateMonth'] . "-" . $_POST['dateDay'];
		$departureTime = $_POST['departHour'] . ":" . $_POST['departMin'];
		$eventTime = $_POST['eventHour'] . ":" . $_POST['eventMin'];
		$returnTime = $_POST['returnHour'] . ":" . $_POST['returnMin'];
		$details = $_POST['details'];
		$forbidden_ids = array();
		
		for($i = 0; isset($_POST['forbidden'.$i]); $i++){
			array_push($forbidden_ids, $_POST['forbidden'.$i]);
		}

		$details_check = preg_split("/[\'\"\\]/", details);
		if (isset($details_check[1]))
		{
			$details = '';
		}

		$details = explode(PHP_EOL, $details);
		$details = implode("<br>",$details);
		$location = $_POST['location'];
		$deadline = $_POST['deadlineYear'] . "-" . $_POST['deadlineMonth'] . "-" . $_POST['deadlineDay'];
		$deadlineTime = $_POST['deadlineTime'];
		$quota = $_POST['quota'];
		$class = $_POST['classPr'] . "," . $_POST['class9'] . "," . $_POST['class10'] . "," . $_POST['class11IB'] . "," . $_POST['class11MEB'] . "," . $_POST['class12IB'] . "," . $_POST['class12MEB'] . "," . $_POST['classT'] . "," . $_POST['classPe'];

		if (($title!='')&&($_POST['dateYear']!='')&&($_POST['dateDay']!='')&&($details!='')&&($location!='')&&($_POST['deadlineYear']!='')&&($_POST['deadlineDay']!='')&&($quota!='')){
			$query = "INSERT into incnet.checkin2Events VALUES ('NULL','$user_id','$date','$title','$departureTime','$eventTime','$returnTime','$details','$location','$deadline','$deadlineTime','$quota',NULL,'$class','".implode(",", $forbidden_ids)."')";
			echo $query;
			mysql_query($query) or die("MySQL Error: " . mysql_error());


			//Sent email to admins for approval
			require("class.phpmailer.php");

			$mail = new PHPMailer();

			$mail->IsSMTP();  // telling the class to use SMTP
			$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

			$mail->Host     = "smtp.gmail.com"; // SMTP server
			$mail->Port = 465;//25 for tevitol??
			$mail->SMTPAuth = true; // turn on SMTP authentication
			$mail->Username = "tevitolincnet"; // SMTP username
			$mail->Password = "TevitolIncnet2015"; // SMTP password

			$mail->From     = "tevitolincnet@gmail.com";


			$mailtext = "A new event has been added to Incnet and needs your approval.
			Event title: " . $title . "
			Date: " . $date;

			$mail->AddAddress("bsevgen@tevitol.k12.tr");
			$mail->AddAddress("bdemirel@tevitol.k12.tr");
			$mail->AddAddress("mkmeral@tevitol.k12.tr");
			//$mail->AddAddress("okucukoruc@tevitol.k12.tr");
			//$mail->AddAddress("mbayburtlu@tevitol.k12.tr");
			//$mail->AddAddress("rkaya@tevitol.k12.tr");
			//$mail->AddAddress("ntekcan@tevitol.k12.tr");
			//$mail->AddAddress("ulerol@tevitol.k12.tr");

			$mail->Subject  = "INCNET new event";
			$mail->Body     = $mailtext;
			$mail->WordWrap = 100;
			
			
			//Emails temporarily disabled
			/*if(!$mail->Send()) {
				echo "<br>error sending notification email. Please contact your helpdesk<br>";
			}
			else {*/
				//echo "<br>Notification email sent successfully<br>";
				$page = "index.php";
			//}

		}else{
			$error = 'Please leave no blank fields and remember that quotes and backslashes are not allowed.';
		}

	}

	if (isset($_POST['cancel'])){
		$page = "index.php";
	}
	//echo $user_id;
?>

<!doctype html>
<HTML>
	<head>
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
				var myChars = new Array("A","B","C","Ç","D","E","F","G","�&#65533;","H","I","İ","J","K","L","M","N","O","Ö","P","R","S","�&#65533;","T","U","Ü","V","Y","Z","1","2","3","4","4","5","6","7","8","9","0",",",":",".","/","a","b","c","ç","d","e","f","g","ğ","h","ı","i","j","k","l","m","n","o","ö","p","r","s","ş","t","u","ü","v","y","z","Q","q","W","w","x","X"," ","@");

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
					<br><a href='index.php'><image src='red.png' width='135px'></a><br>
					<br>
					<?PHP
						if (in_array("232", $allowed_pages)) {
							echo "<a style='color:black' href='waiting.php'> Approve Events </a><br>";
						}
						if (in_array("201", $allowed_pages)) {
							echo "<a style='color:black' href='getList.php'> View Lists </a><br>";
						}
						if (in_array("201", $allowed_pages)) {
							echo "<a style='color:black' href='selectEdit.php'> Edit Events </a><br>";
						}

					?>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<div class='titleDiv'>
						<br>
						Create Event
					</div><br>
					Please enter details for the new event:<br>
					<hr><br>
					<form method='post' name='event'>
						<table>
							<tr>
								<td style='padding:6px;'>Title</td>
								<td style='padding:6px;'><input type='text' name='title' maxlength='100' onkeypress='return isGoodKey(event)' style='height:20px; background-color: transparent; border:1px solid black;'></td>
							</tr>
							<tr>
								<td style='padding:6px;'>Date</td>
								<td style='padding:6px;'>
									<input type="text" size="2" maxlength="2" name="dateDay" style='height:20px; background-color: transparent; border:1px solid black;'>
									<select name="dateMonth">
									<option value="01">January</option>
									<option value="02">February</option>
									<option value="03">March</option>
									<option value="04">April</option>
									<option value="05">May</option>
									<option value="06">June</option>
									<option value="07">July</option>
									<option value="08">August</option>
									<option value="09">September</option>
									<option value="10">October</option>
									<option value="11">November</option>
									<option value="12">December</option>
									</select>
									<input type="text" size="4" maxlength="4" name="dateYear" style='height:20px; background-color: transparent; border:1px solid black;'>&nbsp&nbsp*(Day/Month/Year)
								</td>
							</tr>
							<tr>
								<td style='padding:6px;'>Departure Time</td>
								<td style='padding:6px;'>
									<select name="departHour">
										<option value="08"> 08 </option>
										<option value="09"> 09 </option>
										<option value="10"> 10 </option>
										<option value="11"> 11 </option>
										<option value="12"> 12 </option>
										<option value="13"> 13 </option>
										<option value="14"> 14 </option>
										<option value="15"> 15 </option>
										<option value="16"> 16 </option>
										<option value="17"> 17 </option>
										<option value="18"> 18 </option>
										<option value="19"> 19 </option>
										<option value="20"> 20 </option>
										<option value="21"> 21 </option>
										<option value="22"> 22 </option>
										<option value="23"> 23 </option>
										<option value="24"> 24 </option>
										<option value="01"> 01 </option>
										<option value="02"> 02 </option>
										<option value="03"> 03 </option>
										<option value="04"> 04 </option>
										<option value="05"> 05 </option>
										<option value="06"> 06 </option>
										<option value="07"> 07 </option>
									</select> <b>:</b>
									<select name="departMin">
										<option value="00"> 00 </option>
										<option value="10"> 10 </option>
										<option value="20"> 20 </option>
										<option value="30"> 30 </option>
										<option value="40"> 40 </option>
										<option value="50"> 50 </option>
									</select>&nbsp&nbsp*(HH:MM)
								</td>
							</tr>
							<tr>
								<td style='padding:6px;'>Event Time</td>
								<td style='padding:6px;'>
									<select name="eventHour">
										<option value="08"> 08 </option>
										<option value="09"> 09 </option>
										<option value="10"> 10 </option>
										<option value="11"> 11 </option>
										<option value="12"> 12 </option>
										<option value="13"> 13 </option>
										<option value="14"> 14 </option>
										<option value="15"> 15 </option>
										<option value="16"> 16 </option>
										<option value="17"> 17 </option>
										<option value="18"> 18 </option>
										<option value="19"> 19 </option>
										<option value="20"> 20 </option>
										<option value="21"> 21 </option>
										<option value="22"> 22 </option>
										<option value="23"> 23 </option>
										<option value="24"> 24 </option>
										<option value="01"> 01 </option>
										<option value="02"> 02 </option>
										<option value="03"> 03 </option>
										<option value="04"> 04 </option>
										<option value="05"> 05 </option>
										<option value="06"> 06 </option>
										<option value="07"> 07 </option>
									</select> <b>:</b>
									<select name="eventMin">
										<option value="00"> 00 </option>
										<option value="10"> 10 </option>
										<option value="20"> 20 </option>
										<option value="30"> 30 </option>
										<option value="40"> 40 </option>
										<option value="50"> 50 </option>
									</select>&nbsp&nbsp*(HH:MM)
								</td>
							</tr>
							<tr>
								<td style='padding:6px;'>Return Time</td>
								<td style='padding:6px;'>
									<select name="returnHour">
										<option value="08"> 08 </option>
										<option value="09"> 09 </option>
										<option value="10"> 10 </option>
										<option value="11"> 11 </option>
										<option value="12"> 12 </option>
										<option value="13"> 13 </option>
										<option value="14"> 14 </option>
										<option value="15"> 15 </option>
										<option value="16"> 16 </option>
										<option value="17"> 17 </option>
										<option value="18"> 18 </option>
										<option value="19"> 19 </option>
										<option value="20"> 20 </option>
										<option value="21"> 21 </option>
										<option value="22"> 22 </option>
										<option value="23"> 23 </option>
										<option value="24"> 24 </option>
										<option value="01"> 01 </option>
										<option value="02"> 02 </option>
										<option value="03"> 03 </option>
										<option value="04"> 04 </option>
										<option value="05"> 05 </option>
										<option value="06"> 06 </option>
										<option value="07"> 07 </option>
									</select> <b>:</b>
									<select name="returnMin">
										<option value="00"> 00 </option>
										<option value="10"> 10 </option>
										<option value="20"> 20 </option>
										<option value="30"> 30 </option>
										<option value="40"> 40 </option>
										<option value="50"> 50 </option>
									</select>&nbsp&nbsp*(HH:MM)
								</td>
							</tr>
							<tr>
								<td valign='top' style='padding:6px;'>Details</td>
								<td style='padding:6px;'><textarea rows='6' cols='30' name='details' onkeypress='return isGoodKey(event)' style='height:140px; background-color: transparent; border:1px solid black;'></textarea></td>
							</tr>
							<tr>
								<td style='padding:6px;'>Location</td>
								<td style='padding:6px;'><input type='text' name='location' maxlength='100' onkeypress='return isGoodKey(event)' style='height:20px; background-color: transparent; border:1px solid black;'></td>
							</tr>
							<tr>
								<td style='padding:6px;' style='padding:6px;'>Deadline</td>
								<td style='padding:6px;'>
									<input type="text" size="2" maxlength="2" name="deadlineDay" style='height:20px; background-color: transparent; border:1px solid black;'>
									<select name="deadlineMonth">
										<option value="01">January</option>
										<option value="02">February</option>
										<option value="03">March</option>
										<option value="04">April</option>
										<option value="05">May</option>
										<option value="06">June</option>
										<option value="07">July</option>
										<option value="08">August</option>
										<option value="09">September</option>
										<option value="10">October</option>
										<option value="11">November</option>
										<option value="12">December</option>
									</select>
									<input type="text" size="4" maxlength="4" name="deadlineYear" style='height:20px; background-color: transparent; border:1px solid black;'>&nbsp&nbsp*(Day/Month/Year)&nbsp&nbsp&nbsp&nbsp
								</td>
								<td style='padding:6px;'>
									<select name="deadlineTime">
										<option value="08"> 08:00 </option>
										<option value="09"> 09:00 </option>
										<option value="10"> 10:00 </option>
										<option value="11"> 11:00 </option>
										<option value="12"> 12:00 </option>
										<option value="13"> 13:00 </option>
										<option value="14"> 14:00 </option>
										<option value="15"> 15:00 </option>
										<option value="16"> 16:00 </option>
										<option value="17"> 17:00 </option>
										<option value="18"> 18:00 </option>
										<option value="19"> 19:00 </option>
										<option value="20"> 20:00 </option>
										<option value="21"> 21:00 </option>
										<option value="22"> 22:00 </option>
										<option value="23"> 23:00 </option>
										<option value="24"> 24:00 </option>
										<option value="01"> 01:00 </option>
										<option value="02"> 02:00 </option>
										<option value="03"> 03:00 </option>
										<option value="04"> 04:00 </option>
										<option value="05"> 05:00 </option>
										<option value="06"> 06:00 </option>
										<option value="07"> 07:00 </option>
									</select>
										&nbsp&nbsp *HH:MM
								</td>
							</tr>
							<tr>
								<td style='padding:6px;'>Quota</td>
								<td style='padding:6px;'><input type="text" size="4" maxlength="4" name="quota" style='height:20px; background-color: transparent; border:1px solid black;'></td>
							</tr>
							<tr>
								<td>Open to</td>
								<td>
									<input type='checkbox' name='classPr' value='Pr' checked='checked'>Preps
									<input type='checkbox' name='class9' value='9' checked='checked'>9
									<input type='checkbox' name='class10' value='10' checked='checked'>10
									<input type='checkbox' name='class11IB' value='11IB' checked='checked'>11 IB
									<input type='checkbox' name='class11MEB' value='11MEB' checked='checked'>11 MEB
									<input type='checkbox' name='class12IB' value='12IB' checked='checked'>12 IB
									<input type='checkbox' name='class12MEB' value='12MEB' checked='checked'>12 MEB
									<input type='checkbox' name='classT' value='T' checked='checked'>Teacher
									<input type='checkbox' name='classPe' value='Pe' checked='checked'>Personnel
								</td>
							</tr>
							<tr>
								<td>
									Forbid This Event To<br>Attendants Of
								</td>
								<td id=forbiddens>
									<select id=forbidden0 name="forbidden0">
										<option value=""></option>
										<?php
											$forbiddenString = "";
											$forbidden_sql = "SELECT event_id, title FROM incnet.checkin2Events ORDER BY date DESC LIMIT 20";
											$forbidden_result = mysql_query($forbidden_sql);
											while($forbidden_row = mysql_fetch_array($forbidden_result))
											{
												$forbiddenString .= "<option value='$forbidden_row[0]'>$forbidden_row[1]</option>";
											}
											echo($forbiddenString);
										?>
									</select>
									<button type=button onClick="addForbiddenField()" class="button0" >+</button> <button type=button class="remForbidden button0" style="display: none;" onClick="remForbiddenField(0)">-</button>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input type='submit' name='submit' value='Save!' style='width:60px; height:20px; background-color: transparent; border:1px solid green; color:green'>
									<input type='submit' name='cancel' value='Cancel' style='width:60px; height:20px; background-color: transparent; border:1px solid #c1272d; color: #c1272d'>
								</td>
							</tr>
						</table>
					</form>
					<br><br><br>
				</td>
			</tr>
		</table>
		
		<script>
			var forbiddenString = "<select name=\"forbidden\"><option value=\"\"></option> <?php echo(addslashes($forbiddenString)); ?> </select><button type=button onClick=\"addForbiddenField()\" class=\"button0\" >+</button> <button type=button class=\"remForbidden button0\" onClick=\"remForbiddenField(0)\">-</button>";
			
			var forbiddenLastId = 0;
			var activeForbiddens = 1;
			function addForbiddenField(){
				forbiddenLastId++;
				if(activeForbiddens == 1) $('.remForbidden').show();
				activeForbiddens++;
				forbiddenString = "<select id=forbidden" + forbiddenLastId + " name=\"forbidden" + forbiddenLastId + "\"><option value=\"\"></option> <?php echo(addslashes($forbiddenString)); ?> </select>&nbsp;<button type=button onClick=\"addForbiddenField()\" class=\"button" + forbiddenLastId +"\" >+</button> <button type=button class=\"remForbidden button" + forbiddenLastId +"\" onClick=\"remForbiddenField(" + forbiddenLastId +")\">-</button>";
				$("#forbiddens")[0].innerHTML += "<span class=button" + forbiddenLastId + "><br/></span>" + forbiddenString;
			}
			
			function remForbiddenField(id){
				if(activeForbiddens == 1) return;
				$("#forbidden"+id)[0].remove();
				$(".button"+id).remove();
				activeForbiddens--;
				if(activeForbiddens == 1) $('.remForbidden').hide();
			}
		</script>
		
		<div class="copyright">&nbsp © INÇNET</div>
	</body>
</HTML>

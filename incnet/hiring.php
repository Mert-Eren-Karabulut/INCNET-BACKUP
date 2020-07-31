<?PHP
	error_reporting(0);

session_start();
if ((!(isset($_SESSION['user_id'])))||(!($_SESSION['user_id'])>0)){
	session_destroy;
	$newPage = "<meta http-equiv='refresh' content='0; url=login.php'>";
}

$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];

if (isset($_POST['logoff'])){
	session_destroy();
	setcookie("remember", "", time()-3600);
	//header("location:login.php");
	$newPage = "<meta http-equiv='refresh' content='0; url=login.php'>";
}

include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}

$type_query = mysql_query("SELECT student_id, type FROM incnet.coreUsers WHERE user_id='$user_id'");
while($type_row = mysql_fetch_array($type_query)){
	$student_id = $type_row['student_id'];
	$user_type = $type_row['type'];
}

$name_query = mysql_query("SELECT name FROM incnet.coreUsers WHERE user_id='$user_id'");
while($name_row = mysql_fetch_array($name_query)){
	$name = $name_row['name'];
	$username = $type_row['username'];
}

//Questions for design
$questions = array("computer", "tablet", "phablet", "cell phone", "typewriter");
if (isset($_COOKIE['question'])){
	$cookieQ = explode(".", $_COOKIE['question']);
	if ($user_id == $cookieQ[0]){
		$qNo = $cookieQ[1];
	} else {
		$noCookie = 1;
	}	
} else {
	$noCookie = 1;
}

if ($noCookie == 1){
	$qNo = mt_rand(0, 4);
	setcookie("question", $user_id . "." . $qNo, time()+(60*60*24*365));
}

if (isset($_POST['submit'])){
	$job = $_POST['job'];
	$ans1 = $_POST['whyjob'];
	$ans2 = $_POST['whyinc'];
	$ans3 = $_POST['whychoose'];
	switch ($job){
		case 1:
			$extraq1 = "Which language(s) do you know?
			";
			$extra1 = $extraq1 . $_POST['lang'];
			$extraq2 = "Which language(s) do you want to know?
			";
			$extra2 = $extraq2 . $_POST['langwish'];
			break;
		case 2:
			$extraq1 = "Which program(s) can you use?
			";
			$extra1 = $extraq1 . $_POST['progde'];
			$extraq2 = "Rate the design of the Inçnet, why?
			";
			$extra2 = $extraq2 . $_POST['design'] . "
			" . $_POST['whydesign'];
			break;
		case 3:
			$uploadDir = "uploads/" . $username . "_" . $questions[$qNo] . ".png";
			$extraq1 = "Which program(s) can you use?
			";
			$extra1 = $extraq1 . $_POST['progdo'];
//		$extraq2 = "Draw a picture that describes how the $questions[$qNo] is invented:
//			";
			//$extra2 = $extraq2 . $uploadDir;
			//Upload file
//			$extension = "png";
			//echo "a" . $_FILES["file"]["tmp_name"];
			//echo "c" . $_POST["upload"];
//		$upFile = explode(".", $_FILES["file"]["name"]);
			//echo "b" . $_FILES["userfile"]["tmp_name"];
//		$countUp = count($upFile) - 1;
//		$upExt = $upFile[$countUp];
			//echo $upExt . " " . $upFile[0];
//		if ((($_FILES["file"]["type"] == "image/x-png")||($_FILES["file"]["type"] == "image/png"))&&($upExt == $extension)){
//			if ($_FILES["file"]["error"] > 0){
//				$error = "Return Code: " . $_FILES["file"]["error"] . "<br>";
//			} else {
//				$message = "Thank you for applying! Your application has been submitted. You can continue browsing Inçnet";
//				move_uploaded_file($_FILES["file"]["tmp_name"], $uploadDir);
//			}
//		} else {
			//echo "yup!";
//			$error = "Invalid file type! Please upload a .png file.";
//		}
			break;
		default:
			$error = "Invalid job!";
	}
	if (!(isset($error))){
		mysql_query("INSERT INTO incnet.hiringapplications VALUES (NULL, '$user_id', '$job', '$ans1', '$ans2', '$ans3', '$extra1', '$extra2')");
	}	
}
?>
<!DOCTYPE html>
<HTML>
	<head>
		<?PHP
			if ($newPage!=''){
				echo $newPage;
			}
		?>
		<title>Inçnet | Hiring!</title>
		<link rel="shortcut icon" href="favicon.ico" >
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<link rel="stylesheet" href="chosen.css">
		<script>
		alertm = '<? echo $error . $message; ?>';
		if (alertm != ''){
			alert(alertm);
		}
		function showDiv(){
			jobDrop = document.getElementById('job').value;
			if (jobDrop == 0){
				document.getElementById('dev').style.visibility='hidden';
				document.getElementById('des').style.visibility='hidden';
				document.getElementById('doo').style.visibility='hidden';
			} else if (jobDrop == 1){
				document.getElementById('dev').style.visibility='visible';
				document.getElementById('des').style.visibility='hidden';
				document.getElementById('doo').style.visibility='hidden';
			} else if (jobDrop == 2){
				document.getElementById('dev').style.visibility='hidden';
				document.getElementById('des').style.visibility='visible';
				document.getElementById('doo').style.visibility='hidden';
			} else if (jobDrop == 3){
				document.getElementById('dev').style.visibility='hidden';
				document.getElementById('des').style.visibility='hidden';
				document.getElementById('doo').style.visibility='visible';
			}
		}
		</script>
	</head>
	<body>
		<div class="header">
			<?PHP echo $fullname; ?>
		</div>
		<br><br>
		<div class="page_logo_container">
			<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
				<tr>
				
					<!--Side Panel-->
					<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
						<br>
						<a href='../incnet'><img src='incnet12.png' width='135px'></a>
						<?PHP
							if (in_array("101", $allowed_pages)) {
								echo "<a style='color:black' href='add_user.php'> Add User </a><br>";
							}
							
							if (in_array("102", $allowed_pages)) {
								echo "<a style='color:black' href='reset_user_password.php'> Reset User Password </a><br>";
							}
								
							if (in_array("103", $allowed_pages)) {
								echo "<a style='color:black' href='permission_manager.php'> Permission Manager </a><br>";
							}
							if (in_array("150", $allowed_pages)) {
								echo "<a style='color:black' href='../webCam/take.php'> webCam </a><br>";
							}
						?>
					</td><td width='5px'></td>
					<td valign='top'>
					
						<!--First Message to User-->
						<br><br><p style='font-size:12pt'>
						Welcome <b><? echo $name; ?>!</b><br>
						To apply to Inçnet you need to fill this form. <b>If you want to apply to two or more
						jobs, you can fill the form twice.</b><br>
						After filling the form, you will be informed within <b>five workdays</b>.<br>
						If you have any questions you can send an email to us: <a style='color:#c1272d;' href='mailto:tevitolincnet@gmail.com'>tevitolincnet@gmail.com</a></p>
						
						<!--General Form-->
						<form enctype='multipart/form-data' name='main' method='POST'><table><tr><td width='250px'>
							Job:</td><td><select name='job' id='job' data-placeholder="Select job..." class="chosen-select" style='width:160px;' onChange='showDiv()'>
										<option value='0'></option>
										<option value='1'>Developer</option>
										<option value='2'>Designer</option>
										<option value='3'>Doodle Team</option>
									</select></td></tr><tr><td>
							Why did you select that job?</td><td><textarea name='whyjob'></textarea></td></tr><tr><td>		
							Why do you want to work with us?</td><td><textarea name='whyinc'></textarea></td></tr><tr><td>
							Why should we choose you?</td><td><textarea name='whychoose'></textarea></td></tr></table>
							
							<!--Developer Div-->
							<div class='developer' id='dev' style='visibility:hidden; position:absolute; top:355px'><table><tr><td width='250px'>
								Which language(s) do you know?</td><td><textarea name='lang'></textarea>
								</td></tr><tr><td>
								Which language(s) do you want to know?</td><td><textarea name='langwish'></textarea></td></tr></table><br><input type='submit' name='submit' value='Submit'></div>
							
							<!--Designer Div-->
							<div class='designer' id='des' style='visibility:hidden; position:absolute; top:355px'><table width='1000px'><tr><td width='250px'>
								Which program(s) can you use?</td><td><textarea name='progde'></textarea>
								</td></tr><tr><td>
								Rate the design of Inçnet:</td><td>
								<input type='radio' name='design' value='1'>Very Bad
								<input type='radio' name='design' value='2'>Bad
								<input type='radio' name='design' value='3'>Moderate
								<input type='radio' name='design' value='4'>Good
								<input type='radio' name='design' value='5'>Very Good
								</td></tr><tr><td>
								Why do you think so?</td><td><textarea name='whydesign'></textarea></td></tr></table><input type='submit' name='submit' value='Submit'></div>
							
							<!--Doodle Team Div-->
							<div class='doodle'  id='doo' style='visibility:hidden; position:absolute; top:355px; border:1px'><table width='1000px'><tr><td width='250px'>
								Which program(s) can you use?</td><td><textarea name='progdo'></textarea>
								</td></tr><tr><td>
<!--						Draw a picture that describes how the <? echo $questions[$qNo];?> could be invented and upload it as a png file with dimensions 400x600px:-->
								</td><td><!--<input type='file' name='upload'><br>-->
							</td></tr></table><br><input type='submit' name='submit' value='Submit'></div>
						</form>
					</td>
				</tr>
			</table>
		</div>
		
		<!--Log off-->
		<div class="logoff_button" style='position:absolute; bottom:30px' >
			<form name="logoff" method="POST">
				<input type ="submit" name="logoff" value="Log Off">
			</form>
		</div>
		<div class="copyright">
			<a href='about.php'>&nbsp © INÇNET</a>
		</div>
	
		<!--Scripts for jQuery Chosen-->
		<script src="jquery_min.js" type="text/javascript"></script>
		<script src="chosen.jquery.js" type="text/javascript"></script>
		<script type="text/javascript">
			jQuery('select').chosen( {disable_search: true} );
			var config = {
				'.chosen-select'           : {},
		    '.chosen-select-no-single' : {disable_search_threshold:5},
		    '.chosen-select-no-results': {no_results_text:'No records found!'},
		    '.chosen-select-width'     : {width:"95%"}
			}
		  for (var selector in config) {
			  $(selector).chosen(config[selector]);
		  }
		</script>
	</body>
</HTML>

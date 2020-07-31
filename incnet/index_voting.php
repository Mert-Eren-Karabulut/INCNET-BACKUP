<?PHP
	error_reporting(0);

session_start();
if ((!(isset($_SESSION['user_id'])))||(!($_SESSION['user_id'])>0)){
	session_destroy;
	header("location:login.php");
	//$newPage = "<meta http-equiv='refresh' content='0; url=login.php'>";
}

if ($_SESSION['passchange']=="must"){
	header("location:must_change_pass.php");
}

$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];

if (isset($_POST['logoff'])){
	session_destroy();
	setcookie("remember", "", time()-3600);
	header("location:login.php");
	//$newPage = "<meta http-equiv='refresh' content='0; url=login.php'>";
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

$teacher_query = mysql_query("SELECT student_id FROM incnet.coreUsers WHERE user_id='$user_id'");
while($teacher_row = mysql_fetch_array($teacher_query)){
	$student_id = $teacher_row['student_id'];
}

$type_query = mysql_query("SELECT student_id, type FROM incnet.coreUsers WHERE user_id='$user_id'");
while($type_row = mysql_fetch_array($type_query)){
	$student_id = $type_row['student_id'];
	$user_type = $type_row['type'];
}

if (isset($_POST['postSuggestion'])){
	$userSuggests = $_POST['suggestions'];
	$userSuggests = trim($userSuggests);
	mysql_query("DELETE FROM incnet.postersuggests WHERE user_id = '$user_id'");
	$sql = "INSERT INTO incnet.postersuggests VALUES('$user_id','$userSuggests')";
	mysql_query($sql);
}

$userSuggests = '';

$suggestions_query = mysql_query("SELECT * FROM incnet.postersuggests WHERE user_id='$user_id'");
while($suggestions_row = mysql_fetch_array($suggestions_query)){
	$userSuggests = $suggestions_row[1];
}

if (isset($_GET['pic'])){
	$picId = $_GET['pic'];
	//echo $picId;
	mysql_query("DELETE FROM incnet.posters WHERE user_id = '$user_id'");
	$sql = "INSERT INTO incnet.posters VALUES('$user_id','$picId')";
	mysql_query($sql);
	//echo $sql;
}

$poster_query = mysql_query("SELECT poster_id FROM incnet.posters WHERE user_id='$user_id'");
while($poster_row = mysql_fetch_array($poster_query)){
	$prevPoster = $poster_row['0'];
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
		<title>Inçnet</title>
		<link rel="shortcut icon" href="favicon.ico" >
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	</head>
	<body>
		<div class="header">
			<?PHP echo $fullname; ?>
		</div>
		<br><br>
		<div class="page_logo_container">
			<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
				<tr>
					<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
						<br>
						<a href='../incnet'><image src='incnet12.png' width='135px'></a>
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
					</td>
					<td valign='top' style='padding:7px; padding-top:15px;'>
						<br>
						<div style='color: #c1272d; font-size:16pt'>
							Services:
						</div>
						<br>
						<a style='color:black' href='../checkin2'> Checkin <span style='color:#c1272d; font-weight:bold;'>2.0</span> </a><br>
						<a style='color:black' href='../pool/index.php'> Pool Reservations </a><br>
						<a style='color:black' href='../movies/index.php'> Movie Library </a><br>
						<a style='color:black' href='../weekend/index.php'> Weekend Departures </a><br>

						<?PHP 
						if (($user_type=='student')||(in_array("350", $allowed_pages))||(in_array("351", $allowed_pages))){
							echo "<a style='color:black' href='../etut'> Etut Reservations</a><br>";
						}
						if ($user_type=='student'){
							//echo "<a style='color:#c1272d' href='../profileBuilder/student_info.php'> Complete your profile </a></br>";
							//echo "<a style='color:black' href='../profileBuilder/selfAdmin/'> Edit your profile </a></br>";
						}
						if (in_array("401", $allowed_pages)) {
							echo "<a style='color:black' href='../tv/admin.php'> Public Display </a></br>";
						}
						if (in_array("901", $allowed_pages)) {
							echo "<a style='color:black' href='../profileBuilder/admin/fullProfile.php'> &nbsp Edit student profiles </a><br>";
						}
						if (in_array("902", $allowed_pages)) {
							echo "<a style='color:black' href='../profileBuilder/admin/emergencySearch.php'> &nbsp Student contact and social security information </a><br>";
						}
						if (in_array("903", $allowed_pages)) {
							echo "<a style='color:black' href='../profileBuilder/admin/deviceInfo.php'> &nbsp Student device information </a><br>";
						}
						if (in_array("904", $allowed_pages)) {
							echo "<a style='color:black' href='../profileBuilder/admin/summerInfo.php'> &nbsp Student summer camps information </a><br>";
						}
						
						
						
						/*
						if (in_array("300", $allowed_pages)) {
							echo "<a style='color:black' href='/announcements/admin.php'> e-announcements </a><br>";
						}
						*/
						
						if (in_array("501", $allowed_pages)) {
							echo "<a style='color:black' href='/tevitolkayit/admin/'> tevitolkayit </a><br>";}
						/* if (in_array("104", $allowed_pages)) {
							echo "<a style='color:black' href='add_doodle.php'>Add doodle</a><br>";
							echo "<a style='color:black' href='remove_doodle.php'>Remove doodle</a><br>";
							}
						*/
						?>	
						<a style="color:black" href="changepass.php"> Change Password </a><br>
						<a style="color:black" href="about.php"> About INÇNET </a><br><br><br>
						<table border=0; style='width:620px;'>
							<tr>
								<td colspan=2>
									<span style='color:#545454; font-size:14pt' id='votePosters'>Vote for the school's posters!</span>
									<span style='font-size:11pt;'>Click on the pictures to vote.</span>
								</td>
							</tr>
							<tr>
								<td>
									<a href="index.php?pic=1">
										<?
											if ($prevPoster==1) {
												echo "<img style='width:350px; border:5px solid green;' src='posters/1.jpg'>";
											}else{
												echo "<img style='width:350px; border:5px solid #c1272d;' src='posters/1.jpg'>";
											}
										?>
									</a>
									<br><a target='_blank' href='posters/large/1.jpg' style='color:#c1272d'>Full Resolution</a>
								</td>
								<td style='text-align:center'>
									<a href="index.php?pic=2">
										<?
											if ($prevPoster==2) {
												echo "<img style='width:250px; border:5px solid green;' src='posters/2.jpg'>";
											}else{
												echo "<img style='width:250px; border:5px solid #c1272d;' src='posters/2.jpg'>";
											}
										?>
									</a>
									<br><a target='_blank' href='posters/large/2.jpg' style='color:#c1272d'>Full Resolution</a><br><br>
							</tr>
							<tr>
								<td>
									<a href="index.php?pic=3">
										<?
											if ($prevPoster==3) {
												echo "<img style='width:350px; border:5px solid green;' src='posters/3.jpg'>";
											}else{
												echo "<img style='width:350px; border:5px solid #c1272d;' src='posters/3.jpg'>";
											}
										?>
									</a>
									<br><a target='_blank' href='posters/large/3.jpg' style='color:#c1272d'>Full Resolution</a>
								</td>
								<td>
									<a href="index.php?pic=4">
										<?
											if ($prevPoster==4) {
												echo "<img style='width:350px; border:5px solid green;' src='posters/4.jpg'>";
											}else{
												echo "<img style='width:350px; border:5px solid #c1272d;' src='posters/4.jpg'>";
											}
										?>
									</a>
									<br><a target='_blank' href='posters/large/4.jpg' style='color:#c1272d'>Full Resolution</a>
							</tr>
							<tr style='height:150px'>
								<td colspan='2'>
									<form method='POST'>
										Any suggestions?(optional)<br>
										<textarea name='suggestions' autofocus style='font-family:arial; font-size:10pt;' rows=4 cols=60><? echo $userSuggests; ?></textarea>
										<input type='submit' name='postSuggestion' value='Send'>
									</form>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

		</div>

		<div class="logoff_button" style='position:absolute; bottom:30px' >
			<form name="logoff" method="POST">
				<input type ="submit" name="logoff" value="Log Off">
			</form>
		</div>
		<div class="copyright">
			<a href='about.php'>&nbsp © INÇNET</a>
		</div>
	</body>
</HTML>

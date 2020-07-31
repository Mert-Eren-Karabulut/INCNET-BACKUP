<?PHP
	error_reporting(0);
session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}
$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];

include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}
if (!(in_array('801', $allowed_pages))){
	header('location:index.php');
}

if ((!(isset($_POST[select_movie])))&&(!(isset($_POST[approve])))){
	header("location:lend_movies.php");
}

$lend_user_id = $_POST['borrower_id'];
$lend_user_name = $_POST['borrower_name'];
$lend_movie_id = $_POST['select_movie_id'];
$lend_movie_details = $_POST['select_movie'];

$lend_movie_details = explode('
', $lend_movie_details);

$lend_movie_details = "<b>" . $lend_movie_details[0] . "</b><br>" . $lend_movie_details[1] . "<br>" . $lend_movie_details[2];

$query = mysql_query("SELECT username FROM incnet.coreUsers WHERE user_id='$lend_user_id'");
while($row = mysql_fetch_array($query)){
	$lend_username = $row['username'];
}

if (isset($_POST['cancel'])){
	header("location:lend_movies.php");
}



if (isset($_POST['approve'])){
	
	$borrower_id = $_POST['borrower_id'];
	$borrow_movie_id = $_POST['borrow_movie_id'];
	$borrow_duration = $_POST['borrow_duration'];
//	echo $borrower_id . "<br>" . $borrow_movie_id;
	
	$today_date = date("Y-m-d");
	
	mysql_query("INSERT INTO incnet.moviesBorrows VALUES(NULL, '$borrower_id', '$borrow_movie_id', '$today_date', '$borrow_duration')");
	
	header("location:lend_movies.php");
}


?>


<HTML>
<head>
<!--<title>In?net | Movie Library<title>-->

	<link rel="shortcut icon" href="favicon.ico" >
	<meta charset="UTF-8">
	<link rel="stylesheet" href="incnet.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="movies.css" type="text/css" media="screen" title="no title" charset="utf-8">
	
	<script>
		function changeColor(ele,color){
			ele.style.backgroundColor = color;
		}
	</script>
</head>
<body>
	
<div style='position:absolute; width:700px; height:450px; z-index:15; top:50%; left:50%; margin:-225px 0 0 -350px;'>
	<table width=100% border=0>
		<tr>
			<td width=40%><center><p style='color:c1272d; font-size:16'>Borrower details:</p></center></td>
			<td width=60%><center><p style='color:c1272d; font-size:16'>Movie details:</p></center></td>
		</tr>
		<tr>
			<td>
				<center>
				<img src="<?PHP echo '../student_photos/' . $lend_username . '.jpg'; ?>" width='140' border=0/><br>
				<?PHP echo $lend_user_name; ?>
				</center>
			</td>			
			<td>
				<?PHP echo $lend_movie_details; ?>
			</td>
		</tr>
	</table><br><br>
				<center>
					<form method='POST'>
						<p style='font-size:20'>Duration: <input type='text' name='borrow_duration' value='3' style='width:60px; height: 40px; font-size:22;'> days</p>
						<input type='hidden' name='borrower_id' value="<?PHP echo $lend_user_id?>">
						<input type='hidden' name='borrow_movie_id' value="<?PHP echo $lend_movie_id?>">
						<input onMouseOver="changeColor(approve,'green')" onMouseOut="changeColor(approve,'black')" type='submit' id='approve' name='approve' value='Approve' style='height:50px; width:150px; background-color:black; color:white; border:0; border-radius:10px; font-size:20; font-weight:bold'>
&nbsp
&nbsp
&nbsp
&nbsp
						<input onMouseOver="changeColor(cancel,'red')" onMouseOut="changeColor(cancel,'black')" type='submit' id='cancel' name='cancel' value='Cancel' style='height:50px; width:150px; background-color:black; color:white; border:0; border-radius:10px; font-size:20; font-weight:bold'>
					</form>
				</center>
</div>
		
</body>
</HTML>

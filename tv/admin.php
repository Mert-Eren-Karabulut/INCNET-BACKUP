<?PHP
session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}

if (isset($_POST['logoff'])){
	session_destroy();
	setcookie("remember", "", time()-3600);
	header("location:../incnet/login.php");	
}

$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];


include ("db.php");

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}


?>
<!DOCTYPE html>
<HTML>
	<head>
		<title>INÇNET | TV</title>
		<link rel="shortcut icon" href="favicon.ico" >
		<meta charset="UTF-8">
		<link rel="stylesheet" href="admin.css" type="text/css" media="screen" title="no title" charset="utf-8">
	</head>
	<body>
		<div class="header">
		</div>
		<br><br>
		<div class="page_logo_container">
			<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
				<tr>
					<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
						<br>
						<a href='../incnet'><image src='incnet.png' width='135px'></a>	
					</td>
					<td valign='top' style='padding:7px; padding-top:15px;'>
						<br>
						<div style='color: #c1272d; font-size:16pt'>
							Services:
						</div>
						<br>
						<?PHP
							if (in_array("403", $allowed_pages)) {
								echo "<a style='color:black' href='view_message.php'> View Message </a><br>";
							}
							
							if (in_array("403", $allowed_pages)) {
								echo "<a style='color:black' href='submit_new.php'> Submit New! </a><br>";
							}
						
							if (in_array("404", $allowed_pages)) {
								echo "<a style='color:black' href='upload.php'> Today in History </a><br>";
							}
							
							if (in_array("402", $allowed_pages)) {
								echo "<a style='color:black' href='show_upload.php'> Update Slideshow </a><br>";
							}
						?>
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
			<a href='../incnet/about.php'>&nbsp © INÇNET</a>
		</div>
	</body>
</HTML>

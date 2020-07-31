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

$page_id = "404";
include ("db.php");
$fullname = $_SESSION['fullname'];

?>
<!DOCTYPE html>
<HTML>
	<head>
		<title>INÇNET | TV</title>
		<link rel="shortcut icon" href="favicon.ico" >
		<meta charset="UTF-8">
		<link rel="stylesheet" href="admin.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<script>
		function myFunction()
		{
		alert("'Today in History' has been updated.");
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
					<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
						<br>
						<a href='admin.php'><image src='incnet.png' width='135px'></a>	
					</td>
					<td valign='top' style='padding:7px; padding-top:15px;'>
						<br>
						<br>
						<form action="uploader.php" method="post" enctype="multipart/form-data">
						<h3>Upload format: "tarih.htm</h3>
						<input type="file" name="file" id="file"><br>
						<input type="submit" name="submit" value="Submit" onclick="myFunction()">
						</form>						
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

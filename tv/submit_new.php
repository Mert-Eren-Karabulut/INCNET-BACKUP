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
$page_id = "403";
include ("db.php");
$fullname = $_SESSION['fullname'];

if (isset($_POST['submit'])){	

	$baslik=$_POST['baslik'];
	$title=$_POST['title'];
	$metin=$_POST['metin'];

	insert_content ($baslik,$title,$metin);
	
	echo "<br><br><h3><center>DONE</center></h3>";
	header("location:admin.php");

	}

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
		alert("Message has been updated.");
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
<form name="new_content" action="submit_new.php" method="POST" style="color: black; position: relative; left: 7%; top: 2%; width: 80%; height: 80%;">

Başlık/Title:<br><input type="text" size="49" maxlength="22" name="baslik"><br><br>

2. Başlık/Title:<br><input type="text " size="49" maxlength="28" name="title"><br><br>

Metin/Text: <br>
	<textarea rows="7" cols="80" name="metin" wrap="none" maxlength="126"></textarea><br><br><br>
		
	<input type="submit" value="Submit" name="submit" onclick="myFunction()"><br />
	
	
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


<?PHP
	error_reporting(0);

session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:login.php");
}
$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];
//echo $lang;

include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}

$page_id = "104";
$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='$page_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}
if ($allowance != "1"){
header ("location:login.php");
}

if (isset($_POST['logoff'])){
	session_destroy();
	header("location:login.php");	
}

$doodle_result = mysql_query("SELECT * FROM incnet.coreDoodles");
while($doodle_row = mysql_fetch_array($doodle_result)){
		$doodle_id = $doodle_row['doodle_id'];
}


$doodle_id = $doodle_id+1;
?>
<HTML>
<head>
<!--<title>Inçnet</title>-->
<link rel="shortcut icon" href="favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
</head>
	<div class="top_menubar">
	<?PHP echo $fullname; ?>
	</div>
<br><br>
<div class="page_logo_container">
<table width="900"><tr>

<td width="120"><a href="index.php"><img src="incnet.png" width="120" border=0/></a></td>
<td width="3"></td>
<td bgcolor="black" width=1>
<td width="3"></td>
<td><br><br>

<!--Begin content-->
		<form action='uploader.php' method='post' enctype='multipart/form-data'>
		<?PHP echo $pleed; ?>
		<input type='file' name='file' id='file' /><br>
		<input type='hidden' name='doodle_id' value='<?PHP echo $doodle_id; ?>'>
		Date: <input type='text' name='date' maxlength='10' size=10><br>
		Link: <input type='text' name='link' size=10><br>
		Title: <input type='text' name='title' size=10><br>
		
		<br>
		<input type='submit' name='submit' value='Upload' />
		</form>

<!--end of content-->
</td>
</tr></table>
<div>
<br><br><br>
<div class="logoff_button">
<?PHP if ($lang == "EN") {$logoff_string="Log Off";} else if ($lang == "TR") {$logoff_string="Çıkış Yap"; } ?>
<input type ="submit" name="logoff" value="<? echo $logoff_string; ?>">
</form>
</div>


<div class="copyright">
<a style="text-decoration:none; color: white" href="copyright.php" >© 2012 Levent Erol</a>
</div>
</HTML>

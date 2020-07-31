<?PHP
$page_id = "402";
session_start();
	
/*if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}
$user_id = $_SESSION['user_id'];

include("../incnet/db_connect.php");
$con;

$permit_query = mysql_query("SELECT * FROM permissions.permits WHERE user_id='$user_id' AND page_id='$page_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}
if ($allowance != "1"){
header ("location:index.php");
}


if (isset($_POST['logoff'])){	

session_destroy();
header ("Location: login.php");	

	}*/
?>
<html>
<head>
<link rel="shortcut icon" href="favicon.ico" >
</head>
<body>

<h3>Larger than 1500x600 px suggested<br>1920x1080 is the best!</h3>



<form enctype="multipart/form-data" action="upload_file2.php" method="POST" >
		
			<input name="uploaded" type="file" ></input><br>
			<input type="submit" value="Upload Background Photo" title="Upload Your Photo" s />
	
	</form>
<a href="admin.php">Admin Page</a>
</body>
</html>

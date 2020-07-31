<?PHP
	error_reporting(0);

include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}


session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:login.php");
}
$user_id = $_SESSION['user_id'];


$page_id = "104";
$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='$page_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}
if ($allowance != "1"){
header ("location:login.php");
}


$doodle_id = $_POST['doodle_id'];
$doodle_date = $_POST['date'];
$doodle_link = $_POST['link'];
$doodle_title = $_POST['title'];


session_start();


$allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "JPEG", "PNG");
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 2000000000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Hata kodu: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
      $filename = $doodle_id . "." . $extension;
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "doodles/" . $filename);
      $new_location = "doodles/" . $filename;
      $_SESSION['uploaderror'] = 'none';
      $sql = "INSERT into incnet.coreDoodles VALUES('$doodle_id','$doodle_date','$new_location','$doodle_link','$doodle_title')";
      echo $sql;

      //header("location:index.php");
  
    }
  }
else
  {

	header("location:add_doodle.php");
  }
?> 

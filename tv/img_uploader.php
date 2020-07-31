<?php
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 20000000000)
&& in_array($extension, $allowedExts))
  {

  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1029999999999999994) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    /*if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {*/
     
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
	header("location:show_upload.php");
      }
    }
  
else
  {
  echo "
<!DOCTYPE html>
<HTML>
	<head>
		<title>Inçnet</title>
		<link rel='shortcut icon' href='favicon.ico' >
		<meta charset='UTF-8'>
		<link rel='stylesheet' href='admin.css' type='text/css' media='screen' title='no title' charset='utf-8'>
	</head>
	<body>
		<div class='header'>
		</div>
		<br><br>
		<div class='page_logo_container'>
			<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
				<tr>
					<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
						<br>
						<a href='show_upload.php'><image src='incnet.png' width='135px'></a>	
					</td>
					<td valign='top' style='padding:7px; padding-top:15px;'>
						<br>
						<br>
						<h3>Invalid File, Please Try Another</h3>
					</td>
				</tr>
			</table>

		</div>

		<div class='logoff_button' style='position:absolute; bottom:30px' >
			<form name='logoff' method='POST'>
				<input type ='submit' name='logoff' value='Log Off'>
			</form>
		</div>
		<div class='copyright'>
			<a href='../incnet/about.php'>&nbsp © INÇNET</a>
		</div>
	</body>
</HTML>";


  }


?> 

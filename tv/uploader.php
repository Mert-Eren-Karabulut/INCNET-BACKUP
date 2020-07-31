<?php

$temp = explode(".", $_FILES["file"]["name"]);
move_uploaded_file($_FILES["file"]["tmp_name"],
"upload/" . $_FILES["file"]["name"]);
header("location:admin.php")
      
?> 

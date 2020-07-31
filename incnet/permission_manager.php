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

$page_id = "103";
$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='$page_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}
if ($allowance != "1"){
header ("location:login.php");
}

if (isset($_POST['logoff'])){
	session_destroy();
	setcookie("remember", "", time()-3600);
	header("location:login.php");	
}
?>
<!DOCTYPE html>
<HTML>
<head>
<title>Inçnet | Permission Manager</title>
<link rel="shortcut icon" href="favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
</head>
<body>
	<div class="top_menubar">
	<?PHP echo $fullname; ?>
	</div>
<br><br>
<div class="page_logo_container">
<table width="900px"><tr>

<td width="120px"><a href="index.php"><img src="incnet.png" width="120px" border=0/></a></td>
<td width="3px"></td>
<td bgcolor="black" width="1px">
<td width="3px"></td>
<td><br><br>

<form name="select_user" method="POST">
Edit Permissions for
	<select name="edituser_id"><?PHP
$sql1 = mysql_query("SELECT * FROM incnet.coreUsers ORDER by name ASC");
while($row1 = mysql_fetch_array($sql1)){
	$user_displayname = $row1['username'] . " - " . $row1['name'] . " " . $row1['lastname'];
	$user_user_id = $row1['user_id'];
	echo "
	<option value='" . $user_user_id . "'>" . $user_displayname . " (user id: " . $user_user_id . ")</option>";
}

?></select>
<input type='submit' value="Go" name='search_by_user'>
</form>
<hr>
	
<br>
<?PHP
	if(isset($_POST['go'])){
		$edited_user = $_POST['user_to_permit'];
		$edited_page = $_POST['new_permission'];
		mysql_query("INSERT INTO incnet.corePermits  VALUES ('NULL', '$edited_page', '$edited_user')");
		echo "added permission no $edited_page to user $edited_user";
	}

	if(isset($_POST['remove_permit'])){
		$remove_user = $_POST['remove_user_id'];
		$remove_page_id = $_POST['remove_page_id'];
		mysql_query("DELETE FROM incnet.corePermits WHERE page_id=$remove_page_id AND user_id=$remove_user");
		echo "removed permission $remove_page_id from user id $remove_user";
	}
	
	if(isset($_POST['search_by_user'])){
		$search_userid = $_POST['edituser_id'];
		

		$sql4 = mysql_query("SELECT * FROM incnet.coreUsers WHERE user_id=$search_userid");
		while($row4 = mysql_fetch_array($sql4)){
			$user_displayname = $row4['username'] . " - " . $row4['name'] . " " . $row4['lastname'] . " (user id: " . $search_userid . ")";
		}

		echo "Permissions for";
		echo "<b>" . $user_displayname . ":</b><br>";
		$sql2 = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id=$search_userid ORDER BY page_id ASC");
		while($row2 = mysql_fetch_array($sql2)){
			$user_pages = $row2['page_id'];
			$sql3 = mysql_query("SELECT * FROM incnet.corePage_ids WHERE page_id=$user_pages");
			while($row3 = mysql_fetch_array($sql3)){
			$meaning = $row3['meaning'];
			echo "<form method='post'> <input type='hidden' name='remove_user_id' value='$search_userid'> <input type='hidden' name='remove_page_id' value='$user_pages'> <input type='submit' style='background:none; cursor: hand; border:0; color:red; font-weight:bold' name='remove_permit' value='[remove]'>" . $user_pages . " - " . $meaning . "</form>";
			}
		}
		echo "<br><form method='post'>Add permissions<input name='user_to_permit' type='hidden' value='" . $search_userid . "'><select name='new_permission'>";
		$sql5 = mysql_query("SELECT * FROM incnet.corePage_ids ORDER BY page_id ASC");
		while($row5 = mysql_fetch_array($sql5)){
		$nopermission_meaning = $row5['meaning'];
		$nopermission_id = $row5['page_id'];
		echo "<option value='$nopermission_id'> $nopermission_id - $nopermission_meaning</option>";
		}
		echo "</select><input type='submit' value='go' name='go'></form>";
}	
?>


<!--end of content-->
</td>
</tr></table>
</div>
<br><br><br>
<div class="logoff_button" style='position:absolute; bottom:30px' >
	<form name="logoff" method="POST">
		<input type ="submit" name="logoff" value="Log Off">
	</form>
</div>
<div class="copyright">
	<a style="text-decoration:none; color: white;" href="copyright.php" >Levent Erol 2012 ©</a>
</div>
</body>
</HTML>

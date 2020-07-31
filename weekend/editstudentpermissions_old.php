<?PHP
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

$page_id = "701";
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
<title>Inçnet | Weekend Departures</title>
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

<td width="120px"><a href="index.php"><img src="weekend.png" width="120px" border=0 /></a></td>
<td width="3px"></td>
<td bgcolor="black" width=1>
<td width="3px"></td>
<td><br><br>

<form name="select_user" method="POST">
Add Permissions for:
	<select name="edituser_id"><?PHP
$sql1 = mysql_query("SELECT * FROM incnet.coreUsers WHERE student_id != 0 ORDER by name ASC");
while($row1 = mysql_fetch_array($sql1)){
	$user_displayname = $row1['name'] . " " . $row1['lastname'];
	$user_user_id = $row1['user_id'];
	$user_class = $row1['class'];
	echo "
	<option value='" . $user_user_id . "'>" . $user_displayname . " (class " . $user_class . ")</option>";
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
		mysql_query("INSERT INTO incnet.weekendStudentperms  VALUES ( '$edited_user' , '$edited_page' )");
		echo "added permission no $edited_page to user $edited_user";
	}

	if(isset($_POST['remove_permit'])){
		$remove_user = $_POST['remove_user_id'];
		$remove_page_id = $_POST['remove_page_id'];
		mysql_query("DELETE FROM incnet.weekendStudentperms WHERE leave_id=$remove_page_id AND student_id=$remove_user");
		echo "removed permission $remove_page_id from user id $remove_user";
	}
	
	if(isset($_POST['search_by_user'])){
		$search_userid = $_POST['edituser_id'];
		

		$sql4 = mysql_query("SELECT * FROM incnet.coreUsers WHERE user_id=$search_userid");
		while($row4 = mysql_fetch_array($sql4)){
			$user_displayname = $row4['username'] . " - " . $row4['name'] . " " . $row4['lastname'] . " (user id: " . $search_userid . ")";
		}

$sql6 = mysql_query("SELECT * FROM incnet.profilesMain WHERE user_id=$search_userid");
		while($row6 = mysql_fetch_array($sql6)){
			$user_from = $row6['il'];
		}
		echo "Permissions for <b>" . $user_displayname . ":</b><br>Lives in $user_from";
		$sql2 = mysql_query("SELECT * FROM incnet.weekendStudentperms WHERE student_id=$search_userid ORDER BY leave_id ASC");
		while($row2 = mysql_fetch_array($sql2)){
			$user_leaves = $row2['leave_id'];
			$sql3 = mysql_query("SELECT * FROM incnet.weekendLeaves WHERE leave_id=$user_leaves");
			while($row3 = mysql_fetch_array($sql3)){
			$leave_name = $row3['leave_name'];
			$leave_day_number_x = $row3['leave_day_number'];
			$leave_day_number = $leave_day_number_x - 1;
			$week_name = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
	$leave_day_edited = $week_name[$leave_day_number];
			$i = array("Taksi","Kadıköy","Aile","Gebze-Otagar","Gebze-İstasyon","Gebze-Eskihisar","Kocaeli (en az 4 kişi)");
			$bus_id = $row3['bus_id'] -1;
			$bus_name = $i[$bus_id];
			$displayname = $user_leaves . " - " . $leave_name . " - " .$leave_day_edited." - " . $bus_name; 
			echo "<form method='post'> <input type='hidden' name='remove_user_id' value='$search_userid'> <input type='hidden' name='remove_page_id' value='$user_leaves'> <input type='submit' style='background:none; cursor: hand; border:0; color:red; font-weight:bold' name='remove_permit' value='[remove]'>" . $displayname  ."</form>";
			}
		}
		echo "<br><form method='post'>Add Permissions:<input name='user_to_permit' type='hidden' value='" . $search_userid . "'><select name='new_permission'>";
		$sql5 = mysql_query("SELECT * FROM incnet.weekendLeaves");
		while($row5 = mysql_fetch_array($sql5)){
		$leave_name_b = $row5['leave_name'];
			$leave_day_number_b = $row5['leave_day_number'];
			$leave_day_number_b2 = $leave_day_number_b - 1;
			$week_name = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
	$leave_day_edited_b = $week_name[$leave_day_number_b2];
			$ii = array("Taksi","Kadıköy","Aile","Gebze-Otagar","Gebze-İstasyon","Gebze-Eskihisar","Kocaeli (en az 4 kişi)");
			$bus_id_b = $row5['bus_id'] -1;
			$bus_name_b = $ii[$bus_id_b];
			$leave_id_b = $row5['leave_id'];
			$displayname = $leave_name_b . " - " . $leave_day_edited_b ." - " . $bus_name_b;
		echo "<option value='$leave_id_b'> $displayname </option>";
		}
		echo "</select><input type='submit' value='go' name='go'></form>";
}	
?>


<!--end of content-->
</td>
</tr></table>
</div>
<br><br><br>
<div class="logoff_button">
<form name="logoff" method="POST">
<input type ="submit" name="logoff" value="Log Off">
</form>
</div>
<div class="copyright">
<a style="text-decoration:none; color: white" href="copyright.php" >© 2012 INCNET</a>
</div>
</HTML>

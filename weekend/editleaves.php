<?PHP
session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}

$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];

if (isset($_POST['logoff'])){
	session_destroy();
	setcookie("remember", "", time()-3600);
	header("location:../incnet/login.php");	
}

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
$permit_query = mysql_query("SELECT * FROM innet.corePermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}

$teacher_query = mysql_query("SELECT student_id FROM incnet.coreUsers WHERE user_id='$user_id'");
while($teacher_row = mysql_fetch_array($teacher_query)){
	$student_id = $teacher_row['student_id'];
}

$week_name = array("","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
	
?>
<!DOCTYPE html>
<html>
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
<table><tr>
<td><a href="index.php"><img src="weekend.png" width="120px" border=0 /></a><br>


</td>
<td width="5px"></td>
<td bgcolor="black" width=0.1px>
<td width="3px"></td>
<td valign="middle">
<h3>Edit Leaves Page</h3>
<form name="select_leave" method="POST">
Select Leave to Edit:<br><br>
<select name="leave_select"><?PHP
$sql1 = mysql_query("SELECT * FROM incnet.weekendLeaves");
while($row1 = mysql_fetch_array($sql1)){
	$leave_id = $row1['leave_id'];
	$leave_day_number = $row1['leave_day_number'];
	$leave_day = $week_name[$leave_day_number];
	$leave_displayname = $row1['leave_name'] . " - " . $leave_day;
	$bus_id = $row1['bus_id']; 
	$selected_value = $_POST['leave_select'];
	if ($selected_value==$leave_id){
		echo "<option selected='yes' value='" . $leave_id . "'>" . $leave_displayname . "</option>";
	} else {
		echo "<option value='" . $leave_id . "'>" . $leave_displayname . "</option>";	
	}
}

?></select>
<input type='submit' value='Go' name='selectleave'>
</form>
<hr>
<?

if(isset($_POST['selectleave'])){
	$edited_leave_id = $_POST['leave_select'];
	#echo "";
	$sql5 = mysql_query("SELECT * FROM incnet.weekendLeaves WHERE leave_id=$edited_leave_id");
	while($row5 = mysql_fetch_array($sql5)){
	  $edited_leave_name = $row5['leave_name'];
	  $edited_bus_id = $row5['bus_id'];
	  echo "<form name='edit_leave' method='POST'><input type='hidden' name='leave_idh' value='$edited_leave_id'><table>
						<tr><td>Leave name:</td><td><input type='text' name='leave_name' value='$edited_leave_name'></td></tr>
						<tr><td>Transportation:</td><td><select name='busname'>";
	  $sql6 = mysql_query("SELECT * FROM incnet.weekendBuses");
	  while($row6 = mysql_fetch_array($sql6)){
	  	$edited_bus_name = $row6['bus_name'];
	  	$bus_ids = $row6['bus_id'];
		//$selected_value_bus = $_POST['busname'];
	  	if ($edited_bus_id==$bus_ids){
		echo	"<option selected='yes' value='" . $bus_ids . "'>" . $edited_bus_name . " </option>";}
		else{
		echo	"<option value='" . $bus_ids . "'>" . $edited_bus_name . " </option>";}				
		}
	  echo "<tr><td>Leave Day:</td><td><select name='leave_day'>"
	  			<$sql7 = mysql_query("SELECT leave_day_number FROM incnet.weekendLeaves WHERE leave_id=$selected_value");
	 while($row7 = mysql_fetch_array($sql7)){ 
	 $leave_day_number_edited = $row7['leave_day_number'];
	 $leave_day_number_edited2 = $leave_day_number_edited;}
	 $leave_day_edited = $week_name[$leave_day_number_edited2];
	  echo "<tr><td>Leave Day:</td><td><select name='leave_day'>";
	 $i = 5;
	 while($i<=7){
	 if ($leave_day_number_edited2 != $i){
	 echo "<option value='" . $i . "'>" . $week_name[$i] . "</option>";}
	 else {echo "<option selected='" . "yes" . "' value='" . $leave_day_number_edited2 . "'>" . $leave_day_edited . "</option>";}
	 $i = $i + 1;}
			echo "</select></td>
			</tr><tr>";
			
		echo	"</select></td></tr></table>
					<input type='submit' name='editleave' value='Save'>
					</form><form name= 'remove_leave' method='POST'> <input type='hidden' name='remove_leave_idh' value='$edited_leave_id'>
<input type='submit' style='background:none; cursor: hand; border:0; color:red; font-weight:bold' name='remove_leave' value='[remove]'></form><br>";
	}
}
if(isset($_POST['remove_leave'])){
	$leave_idh2 = $_POST['remove_leave_idh'];
	$sql9= "DELETE FROM incnet.weekendLeaves WHERE leave_id = $leave_idh2";
	mysql_query($sql9);
	echo "Removed Leave $leave_displayname";
}
if (isset($_POST['editleave'])){
	$leave_idh = $_POST['leave_idh'];
	$new_leave_name = $_POST['leave_name'];
	$new_leave_day_number = $_POST['leave_day'] + 1;
	$busname = $_POST['busname'];
	//$edited_leave_id = $_POST['select_leave'];
	

//$sql = 'UPDATE weekend.leaves SET leave_name = "'.  $new_leave_name  .'" , leave_day_number = ' .  $new_leave_day_number . ', bus_id = ' . $busname . ' WHERE leave_id = ' . $leave_id .
$sql = "UPDATE incnet.weekendLeaves SET leave_name =   '$new_leave_name'  , leave_day_number =    $new_leave_day_number , bus_id =  $busname  WHERE leave_id = $leave_idh";
mysql_query($sql);
}
if(isset($_POST['editleave'])){
header('Location:index.php');
}

?>
<br><br>
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
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2012 INCNET</a>
</div>
</body>
</html>

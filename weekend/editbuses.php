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
$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}

$teacher_query = mysql_query("SELECT student_id FROM incnet.coreUsers WHERE user_id='$user_id'");
while($teacher_row = mysql_fetch_array($teacher_query)){
	$student_id = $teacher_row['student_id'];
}


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
<h3>Edit Buses Page</h3>
<form method='POST' name='add_bus'>
<table><tr><td>Bus name:</td>
	   <td><input type='text' name='bus_name'></td></tr>
	<tr><td>Select the way:</td>
	<td><select name ='select_way'>
      	<option value='0'>Departure</option>
      	<option value='1'>Arrival</option>
      	<option value='2'>Round Trip</option>
      </select></td></tr>
</table>	
<input type='submit' name='addbus' value="Add Bus">
</form><hr><form name="select_bus" method="POST">
Select Bus to Edit:<br><br>
<select name="bus_select"><?PHP
$sql1 = mysql_query("SELECT * FROM incnet.weekendBuses");
while($row1 = mysql_fetch_array($sql1)){
	$bus_id = $row1['bus_id'];
	$bus_displayname = $bus_id . " - " . $row1['bus_name'];
	$selected_value = $_POST['bus_select'];
	if ($selected_value==$bus_id){
		echo "<option selected='" . "yes" . "' value='" . $bus_id . "'>" . $bus_displayname . "</option>";
	} else {
		echo "<option value='" . $bus_id . "'>" . $bus_displayname . "</option>";	
	}
}

?></select>
<input type='submit' value='Go' name='selectbus'>
</form>
<hr>
<?
if(isset($_POST['selectbus'])){
	$edited_bus_id = $_POST['bus_select'];
	echo "<form name= 'remove_bus' method='POST'> <input type='hidden' name='remove_bus' value = '$edited_bus_id'>
<input type='submit' style='background:none; cursor: hand; border:0; color:red; font-weight:bold' name='remove_bus_button' value='[remove]'></form>";
$sql5 = mysql_query("SELECT * FROM incnet.weekendBuses WHERE bus_id=$edited_bus_id");
	while($row5 = mysql_fetch_array($sql5)){
	  $edited_bus_name = $row5['bus_name'];
		$edited_select_way = $row5['direction']; }
echo "<form name='edit_bus' method='POST'>
      <input type='hidden' name='edit_bus_n' value = '$edited_bus_id'>
      Bus name:<input type='text' name='bus_name' value='$edited_bus_name'><br>
      Select the way:
      <select name ='select_way2'>
      	<option";if($edited_select_way==0){echo " selected='yes'";}echo " value='0'>Departure</option>
      	<option";if($edited_select_way==1){echo " selected='yes'";}echo " value='1'>Arrival</option>
      	<option";if($edited_select_way==2){echo " selected='yes'";}echo " value='2'>Round Trip</option>
      </select>
      <input type='submit' value='Save' name='edit_bus'>
</form>";
}
if (isset($_POST['addbus'])){
	$bus_name = $_POST['bus_name'];
	$direction= $_POST['select_way'];
	$sql = "INSERT into incnet.weekendBuses (bus_name, direction) VALUES ('$bus_name', '$direction')";
	mysql_query($sql);
	header('Location:index.php');
}
if(isset($_POST['remove_bus'])){
	$bus_idh = $_POST['remove_bus'];
	$sql3= "DELETE FROM incnet.weekendBuses WHERE bus_id = $bus_idh";
	mysql_query($sql3);
	echo "Bus is removed"; 
}
if(isset($_POST['edit_bus'])){
	$bus_id = $_POST['edit_bus_n'];
	$bus_name = $_POST['bus_name'];
	$direction= $_POST['select_way2'];
	$sql4 = "UPDATE incnet.weekendBuses SET bus_name = '$bus_name', direction = '$direction' WHERE bus_id = $bus_id";
	mysql_query($sql4);
	echo "Saved Bus";
}
?>
</table>
<br><br><br>
<div class="logoff_button">
<form name="logoff" method="POST">
<input type ="submit" name="logoff" value="Log Off">
</form></div>
<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2012 INCNET</a>
</div>
</body>
</html>


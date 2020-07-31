<?PHP
	error_reporting(0);

$lang = "EN";

session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:login.php");
}
$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];

if (isset($_POST['logoff'])){
	session_destroy();
	header("location:login.php");	
}

include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}

//permissions  
session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:login.php");
}
$user_id = $_SESSION['user_id'];

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='601'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}

if ($allowance != "1"){
	header ("location:../../incnet/login.php");
}


if (isset($_POST['ban_student'])){
//	echo "hello";
	$ban_user_id = $_POST['user_id'];
	$sql_query = "INSERT into incnet.poolBanned (user_id) VALUES ('$ban_user_id')";
//	echo  $sql_query;
	mysql_query($sql_query);
	$sql_query2 = "DELETE FROM incnet.poolRecords WHERE user_id = '$ban_user_id'";
//	echo  $sql_query;
	mysql_query($sql_query2);

}

if (isset($_POST['unban_student'])){
	$unban_user_id = $_POST['user_id'];
	$sql_query = "DELETE FROM incnet.poolBanned WHERE user_id = '$unban_user_id'";
//	echo  $sql_query;
	mysql_query($sql_query);

}

if (isset($_POST['student_swim'])){
	$noswim_id = $_POST['user_id'];
	$sql_query = "DELETE FROM incnet.poolNonSwimmers WHERE user_id = '$noswim_id'";
//	echo  $sql_query;
	mysql_query($sql_query);
}

if (isset($_POST['student_noswim'])){
	$swim_id = $_POST['user_id'];
	$sql_query = "INSERT into incnet.poolNonSwimmers (user_id) VALUES ('$swim_id')";
//	echo  $sql_query;
	mysql_query($sql_query);
}

?>

<HTML>
<head>
<!--<title>In?net | Pool Reservations<title>-->
<link rel="shortcut icon" href="../../incnet/favicon.ico" >
<meta charset="UTF-8">
<link rel="stylesheet" href="incnet.css" type="text/css" media="screen" title="no title" charset="utf-8">
</head>
	<div class="top_menubar">
	<?PHP echo $fullname; ?>
	</div>
<br><br>
<div class="page_logo_container">
<table><tr>
<td valign="top"><br><br><a href="index.php"><img src="../../incnet/incnet.png" width="120" border=0/></a><br>


</td>
<td width="3"></td>
<td bgcolor="black" width=0.1px>
<td width="3"></td>
<td valign="middle">
<?PHP
$sql2 = mysql_query("SELECT * FROM incnet.poolBanned");
while($row2 = mysql_fetch_array($sql2)){
	$banned_users[] = $row2['user_id'];
}

$sql3 = mysql_query("SELECT * FROM incnet.poolNonSwimmers");
while($row3 = mysql_fetch_array($sql3)){
	$non_swimmers[] = $row3['user_id'];
}

?>
	<table width=560 class="swimmer_list">
		<tr>
			<td><b>Student Id</b></td><td><b>Name</b></td><td><b>Lastname</b></td><td><b>Class</b></td><td><b>Skill</b></td><td><b>Allowance</b></td>
			<?PHP

			$sql1 = mysql_query("SELECT * FROM incnet.coreUsers WHERE (class != 'Grad' AND class != '13') OR class IS NULL ORDER BY student_id");
			while($row1 = mysql_fetch_array($sql1)){
				$select_user_id = $row1['user_id'];
				$student_no = $row1['student_id'];
				$name = $row1['name'];
				$lastname = $row1['lastname'];
				$class = $row1['class'];

				
				echo "<tr><td>" . $student_no . "</td><td>" . $name . "</td><td>" . $lastname . "</td><td>" . $class . "</td><td>";
				echo "<form method='post'><input type='hidden' size=3 name='user_id' value='" . $select_user_id . "'>";
				if (in_array($select_user_id, $non_swimmers)){
					//echo make swimmer button, value=nonswimmer
					echo "<input type='submit' name='student_swim' value='Non-Swimmer' style='background:none; border:0; font-weight:bold; color:red'>";
				}else{
					//echo make non-swimmer button, value=swimmer
					echo "<input type='submit' name='student_noswim' value='Swimmer' style='background:none; border:0; font-weight:bold; color:green'>";
				}
				echo "</td><td>";
				echo "<form method='post'><input type='hidden' size=3 name='user_id' value='" . $select_user_id . "'>";

				if (in_array($select_user_id, $banned_users)){
					//echo unban button
					echo "<input type='submit' name='unban_student' value='Banned' style='background:none; border:0; font-weight:bold; color:red'>";
								}else{
					//echo ban button
					echo "<input type='submit' name='ban_student' value='Allowed' style='background:none; border:0; font-weight:bold; color:green'>";
				}
				echo "</form>";
					 
				echo "</td></tr>";
			}
			?>
		</td>
	</table>

<br><br>
</td>
</tr></table>



<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2012 Levent Erol</a>
</div>
</HTML>

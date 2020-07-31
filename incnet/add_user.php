<?PHP
	error_reporting(0);

//connect to mysql server
include ("db_connect.php");
if (!$con){
  die('Could not connect: ' . mysql_error());
  }

//permissions  
$page_id = "101";
session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:login.php");
}
$user_id = $_SESSION['user_id'];

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='$page_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowance = "1";
}
if ($allowance == "1"){
}else {
header ("location:login.php");
}
	
if (isset($_POST['adduser'])){
	$new_firstname = $_POST['firstname'];
	$new_lastname = $_POST['lastname'];
	$new_s_id = $_POST['student_id'];
	$new_username = $_POST['username'];
	$new_class = $_POST['class'];
	$new_dorm = $_POST['dormroom'];
	$new_email = $new_username . "@tevitol.k12.tr";
	$new_password_hash = md5($_POST['password']);
	$new_type = $_POST['type'];



//select database of incnet
mysql_select_db("incnet", $con);
mysql_query("INSERT INTO coreUsers  VALUES ('NULL', '$new_firstname', '$new_lastname', '$new_s_id', '$new_username', '$new_password_hash', '$new_email', '$new_class', '$new_dorm', '$new_type')");

}
?>

<HTML>
<head>
<title>Inçnet</title>
<link rel="shortcut icon" href="favicon.ico" >
<meta charset="UTF-8">
<body OnLoad="document.add_user.firstname.focus();">
</head>
<body>

<h1>Add user</h1><br>

	<form name="add_user" method="post" autocomplete="off">
	
	<table border="0">
		
		<tr>
			<td>Firstname</td>
			<td><input type="text" name="firstname"></td>
		</tr>
		<tr>
			<td>Lastname:</td>
			<td><input type="text" name="lastname"></td>
		</tr>
		<tr>
			<td>Student id:</td>
			<td><input type="text" name="student_id"></td>
		</tr>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username"></td>
		</tr>
		<tr>
			<td>Class:</td>
			<td><input type="text" name="class">&nbsp Hz/9/10/11/12; blank for teachers and personnel.</td>
		</tr>
		<tr>
			<td>Dormroom:</td>
			<td><input type="text" name="dormroom" >&nbsp Prep/Tekcan/Sedefoğlu, etc.</td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password"/></td>
		</tr>
		<tr>
			<td>Type: </td>
			<td>
				<select name='type'>
					<option value='student'>Student</option>
					<option value='teacher'>Teacher</option>
					<option value='personnel'>Personnel</option>
				</select>
			</td>
		</tr>

	</table>
	
	<input type ="submit" name="adduser" value="Add User">

</form>
<a href="index.php"> Back to InçNet Home </a>
</HTML>

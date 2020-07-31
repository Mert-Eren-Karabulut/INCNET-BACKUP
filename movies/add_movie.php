<?PHP
	error_reporting(0);
session_start();
if (!(isset($_SESSION['user_id']))){
	header("location:../incnet/login.php");
}
$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];

if (isset($_POST['logoff'])){
	session_destroy();
	header("location:../incnet/login.php");	
}

include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}
if (!(in_array('801', $allowed_pages))){
	header('index.php');
}


if (isset($_POST['save'])){
	$newtitle = $_POST['newtitle'];
	$newtype = $_POST['newtype'];
	$newgenre = $_POST['newgenre'];
	$newdirector = $_POST['newdirector'];
	$newyear = $_POST['newyear'];
	$newlanguages = $_POST['newlanguages'];
	$newsubtitles = $_POST['newsubtitles'];
	$newlength = $_POST['newlength'];
	$new_SE = $_POST['new_SE'];
	$newformat = $_POST['newformat'];
	$picture_id = time();


	

$extension = end(explode(".", $_FILES["file"]["name"]));
$new_file_name = $picture_id . "." . $extension;
//echo "<br>Stored in: " . "upload/" . $_FILES["file"]["name"];  
move_uploaded_file($_FILES['file']['tmp_name'], 'upload/'.$new_file_name);

//echo "<br>" . $new_file_name;
//echo "<br>" . $extension;
	$sql = "INSERT INTO incnet.moviesMovies values('$newtype', '$newgenre', NULL, '$newtitle', '$newdirector', '$newyear', '$newlanguages', '$newsubtitles', '$newlength', '$new_SE', '$newformat', '$new_file_name')";
	echo $sql;
	mysql_query($sql);
	  
}
			
?>

<HTML>
<head>
<!--<title>In?net | Movie Library<title>-->
	<link rel="shortcut icon" href="favicon.ico" >
	<meta charset="UTF-8">
	<link rel="stylesheet" href="incnet.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="movies.css" type="text/css" media="screen" title="no title" charset="utf-8">
	
	<script language="javascript">

	var state = 'none';

	function showhide(layer_ref) {

	if (state == 'block') {
	state = 'none';
	}
	else {
	state = 'block';
	}
	if (document.all) { //IS IE 4 or 5 (or 6 beta)
	eval( "document.all." + layer_ref + ".style.display = state");
	}
	if (document.layers) { //IS NETSCAPE 4 or below
	document.layers[layer_ref].display = state;
	}
	if (document.getElementById &&!document.all) {
	hza = document.getElementById(layer_ref);
	hza.style.display = state;
	}
	}
	</script> 
	
	<script>
		function changeColor(ele,color){
			ele.style.backgroundColor = color;
		}
	</script>
</head>

<body OnLoad="document.change_movie.newtitle.focus();">
<div class="top_menubar">
	<?PHP echo $fullname; ?>
</div>

<br><br>

<div class="page_logo_container">
<table style="width:100%"><tr>

<td width='120' valign='top'>
<?PHP
	if (in_array("801", $allowed_pages)) {
		echo "<a href='index.php'><img src='movies.png' width='120' border=0/></a>";
} else {
		header("location:index.php");
}

?>

</td>
<td width="3"></td>
<td bgcolor="black" width=0.1px>
<td width="3"></td>
<td valign="middle">
<h3>Enter details for the movie:</h3>

<form name='change_movie' method='post' action='add_movie.php' enctype='multipart/form-data'>
	<table border=0>
		<tr><td>Name: </td><td><input type='text' name='newtitle' maxlength=100></td>
		<tr><td valign='top'>Type: </td><td>
		<input type='radio' name='newtype' value='Series'>Series<br>
		<input type='radio' name='newtype' value='Movie'>Movie
	</td>
		</tr>
		<tr><td valign='top'> Genre: </td><td><input type='text' name='newgenre' maxlength='18' size='6'></td></tr>
		<tr><td valign='top'> Directed by: </td><td><input type='text' name='newdirector' maxlength='150'></td></tr>
		<tr><td valign='top'> Year: </td><td><input type='text' name='newyear' size='4'></td></tr>
		<tr><td valign='top'> Languages: </td><td><input type='text' name='newlanguages' maxlength='100'></td></tr>
		<tr><td valign='top'> Subtitles: </td><td><input type='text' name='newsubtitles' maxlength='200'></td></tr>
		<tr><td valign='top'> Time: </td><td><input type='text' name='newlength' maxlength='4' size='4'> minutes</td></tr>

		<tr><td colspan='2'><input type='checkbox' name='new_SE' value='SE'>Special Edition</td>

		<tr>
			<td valign='top'> Media Format: </td>
			<td>
				<select name='newformat'>
					<option value='dvd'> DVD </option>
					<option value='vcd'> VCD </option>
					<option value='vhs'> VHS </option>
					<option value='Blu-Ray'> Blu-Ray </option>
					<option value='Laser-Disc'> Laser-Disc </option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Poster*:</td>
			<td><input type='file' name='file' id='file' /></td>
		</tr>
		<tr>
			<td colspan=2 style='text-align:center'>
				<input id='greenbutton' onMouseOver="changeColor(greenbutton,'green')" onMouseOut="changeColor(greenbutton,'black')" style='height:40px; background-color:black; color:white; font-weight:bold; border:0; border-radius:10px;' type='submit' name='save' value='Save Changes'>
			</td>
		</tr>
	</table>
</form>



</td>
</tr></table>

<br><br><br>
<div class="logoff_button">
<form name="logoff" method="POST">
<input type ="submit" name="logoff" value="Log Off">
</form>
</div>


<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2012 Levent Erol</a>
</div>
</HTML>

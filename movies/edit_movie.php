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

if (isset($_POST['delete'])){//delete the poster and the db records
	$delete_id = $_POST['editid'];
	$delete_poster = $_POST['delete_poster'];
	$delete_poster = "upload/" . $delete_poster;
	unlink($delete_poster);
	mysql_query("DELETE from incnet.moviesMovies WHERE id=$delete_id");
}

if (isset($_POST['save'])){
	$update_id = $_POST['editid'];
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

	mysql_query("UPDATE incnet.moviesMovies SET type='$newtype', genre='$newgenre', title='$newtitle', director='$newdirector', year='$newyear', languages='$newlanguages', subtitles='$newsubtitles', length='$newlength', special_edition='$new_SE', format='$newformat' WHERE id='$update_id'");
}
			
?>

<HTML>
<head>
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


if (isset($_POST['edit_movie'])){
	$selected_movie_id = $_POST['select_movie'];

		$sql2 = mysql_query("SELECT * FROM incnet.moviesMovies WHERE id=$selected_movie_id");
		while($row2 = mysql_fetch_array($sql2)){
			$editmovie_id = $selected_movie_id;
			$editmovie_title = $row2['title'];
			$editmovie_type = $row2['type'];
			$editmovie_genre = $row2['genre'];
			$editmovie_director = $row2['director'];
			$editmovie_year = $row2['year'];
			$editmovie_languages = $row2['languages'];
			$editmovie_subtitles = $row2['subtitles'];
			$editmovie_length = $row2['length'];
			$editmovie_SE = $row2['special_edition'];			
			$editmovie_format = $row2['format'];
			$editmovie_poster = $row2['picture_filename'];
		}

	}


//get a list of all movies
$sql1 = mysql_query("SELECT * FROM incnet.moviesMovies");
while($row1 = mysql_fetch_array($sql1)){
	$movie_id = $row1['id'];
	$movie_title = $row1['title'];
	$movie_director = $row1['director'];
	$movie_year = $row1['year'];
	$movie_format = $row1['format'];
	
	if ($movie_id == $selected_movie_id){
		$movies_select = $movies_select . "<option selected='yes' value='$movie_id'><b>$movie_title</b> by:$movie_director ($movie_year) - $movie_format (Movie ID:'$movie_id')</option>";
	}else{
		$movies_select = $movies_select . "<option value='$movie_id'><b>$movie_title</b> by:$movie_director ($movie_year) - $movie_format (Movie ID:'$movie_id')</option>";
	}
	
}


?>

</td>
<td width="3"></td>
<td bgcolor="black" width=0.1px>
<td width="3"></td>
<td valign="middle">
<h3>Select a movie for editing</h3>

<form name='editmovie' method='POST'>
	<select name='select_movie'>
		<?PHP echo $movies_select; ?>
	</select>
	<input type='submit' value='Go' name='edit_movie'>
</form>

<?PHP
if (isset($_POST['edit_movie'])){
	echo
	"
	<form name='change_movie' method='POST'>
	<input type='hidden' name='delete_poster' value='$editmovie_poster'>
		<table border=0>
			<tr><td colspan='2'><img src='upload/$editmovie_poster' height='300' border=0/></td></tr>
			<tr><td>Name: </td><td><input type='text' name='newtitle' maxlength=100 value='$editmovie_title'></td>
			<tr><td valign='top'>Type: </td><td>";
			
			if ($editmovie_type == 'Series'){
				echo
				"<input type='radio' name='newtype' value='Series' checked>Series<br>
				<input type='radio' name='newtype' value='Movie'>Movie";
			} else if ($editmovie_type == 'Movie'){
				echo
				"<input type='radio' name='newtype' value='Series'>Series<br>
				<input type='radio' name='newtype' value='Movie' checked>Movie";
			} else {
				echo
				"<input type='radio' name='newtype' value='Series'>Series<br>
				<input type='radio' name='newtype' value='Movie'>Movie";
			}
			echo
				"</td>
			</tr>
			<tr><td valign='top'> Genre: </td><td><input type='text' name='newgenre' value='$editmovie_genre' maxlength='18' size='6'></td></tr>
			<tr><td valign='top'> Directed by: </td><td><input type='text' name='newdirector' value='$editmovie_director' maxlength='150'></td></tr>
			<tr><td valign='top'> Year: </td><td><input type='text' name='newyear' value='$editmovie_year' maxlength='150' size='4'></td></tr>
			<tr><td valign='top'> Languages: </td><td><input type='text' name='newlanguages' value='$editmovie_languages' maxlength='100'></td></tr>
			<tr><td valign='top'> Subtitles: </td><td><input type='text' name='newsubtitles' value='$editmovie_subtitles' maxlength='200'></td></tr>
			<tr><td valign='top'> Time: </td><td><input type='text' name='newlength' value='$editmovie_length' maxlength='4' size='4'> minutes</td></tr>";

			if ($editmovie_SE==''){
				echo "<tr><td colspan='2'><input type='checkbox' name='new_SE' value='SE'>Special Edition</td>";
			} else {
				echo "<tr><td colspan='2'><input type='checkbox' name='new_SE' value='SE' checked='yes'>Special Edition</td>";
			}
			
			echo "
			<tr>
				<td valign='top'> Media Format: </td>
				<td>
					<select name='newformat'>
						<option value='dvd'"; if ($editmovie_format=='dvd'){echo "selected='yes'";} echo "> DVD </option>
						<option value='vcd'"; if ($editmovie_format=='vcd'){echo "selected='yes'";} echo "> VCD </option>
						<option value='vhs'"; if ($editmovie_format=='vhs'){echo "selected='yes'";} echo "> VHS </option>
						<option value='Blu-Ray'"; if ($editmovie_format=='Blu-Ray'){echo "selected='yes'";} echo "> Blu-Ray </option>
						<option value='Laser-Disc'"; if ($editmovie_format=='Laser-Disc'){echo "selected='yes'";} echo "> Laser-Disc </option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan=2 style='text-align:center'>
					<input id='greenbutton' onMouseOver=\"changeColor(greenbutton,'green')\" onMouseOut=\"changeColor(greenbutton,'black')\" style='height:40px; background-color:black; color:white; font-weight:bold; border:0; border-radius:10px;' type='submit' name='save' value='Save Changes'>
					&nbsp
					&nbsp
					&nbsp
					<input type='hidden' name='editid' value='$editmovie_id'>
					<input id='redbutton' onMouseOver=\"changeColor(redbutton,'red')\" onMouseOut=\"changeColor(redbutton,'black')\"  style='height:40px; background-color:black; color:white; font-weight:bold; border:0; border-radius:10px;' type='submit' name='delete' value='Delete Movie'>
				</td>
			</tr>
		</table>
	</form>";
}
?>

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

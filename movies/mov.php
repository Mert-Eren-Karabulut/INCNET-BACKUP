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

$permit_query = mysql_query("SELECT * FROM incnet.coreermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}
if (!(in_array('801', $allowed_pages))){
	header('index.php');
}

			
?>

<HTML>
<head>
<!--<title>In?net | Movie Library<title>-->

	<link rel="shortcut icon" href="favicon.ico" >
	<meta charset="UTF-8">
	<link rel="stylesheet" href="incnet.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="movies.css" type="text/css" media="screen" title="no title" charset="utf-8">
	
	<script language=javascript>
	function showhide(ele){
		element  = document.getElementById(ele);
		if(element.style.visibility=='hidden'){
			element.style.visibility = 'visible';
		}else{
			element.style.visibility = 'hidden';
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

if (isset($_POST['set_new_mov'])){
	$new_mov_id = $_POST['new_mov_id'];
	$update_sql = "UPDATE incnet.moviesMovie_week SET movie_id=$new_mov_id";
	mysql_query($update_sql);
}

//get the current mov
$sql2 = mysql_query("SELECT * FROM incnet.moviesMovie_week");
while($row2 = mysql_fetch_array($sql2)){
	$mov_id = $row2['movie_id'];
}

$sql4 = mysql_query("SELECT * FROM incnet.moviesMovies WHERE id='$mov_id'");
while($row4 = mysql_fetch_array($sql4)){
	$mov_title = $row4['title'];
	$mov_genre = $row4['genre'];
	$mov_director = $row4['director'];
	$mov_year = $row4['year'];
	$mov_length = $row4['length'];
	$mov_poster = $row4['picture_filename'];
	$mov_poster = "upload/" . $mov_poster;	
}


if (isset($_POST['update_mov'])){
	$selected_mov_id = $_POST['select_mov'];

		$sql3 = mysql_query("SELECT * FROM incnet.moviesMovies WHERE id=$selected_mov_id");
		while($row3 = mysql_fetch_array($sql3)){
			$mov_id = $selected_mov_id;
			$mov_title = $row3['title'];
			$mov_genre = $row3['genre'];
			$mov_director = $row3['director'];
			$mov_year = $row3['year'];
			$mov_length = $row3['length'];
			$mov_poster = $row3['picture_filename'];
			$mov_poster = "upload/" . $mov_poster;
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
	
	if ($movie_id == $selected_mov_id){
		$movies_select = $movies_select . "<option selected='yes' value='$movie_id'><b>$movie_title</b> by:$movie_director ($movie_year) - $movie_format</option>";
	}else{
		$movies_select = $movies_select . "<option value='$movie_id'><b>$movie_title</b> by:$movie_director ($movie_year) - $movie_format</option>";
	}
	
}

		
?>

</td>
<td width="3"></td>
<td bgcolor="black" width=0.1px>
<td width="3"></td>
<td valign="middle">
<h3>Movie of the Week

<?PHP
	if ($mov_id == '0'){
		echo "is not set</h3>You can select one from the menu below<br>";
	} else {
	 echo ":</h3>";
	}
?>

<form name='select_movie' method='POST'>
	<select name='select_mov'>
		<?PHP echo $movies_select; ?>
	</select>
	<input type='submit' value='Go' name='update_mov'>
</form>

<table>
	<tr>
		<td>
			<img src="<?PHP echo $movie_poster; ?>" height='200' border=0/>
		</td>
		<td>
			<table>
				<tr>
					<td>Title:</td>
					<td><?PHP echo $mov_title; ?></td>
				</tr>
				<tr>
					<td>Genre:</td>
					<td><?PHP echo $mov_genre; ?></td>
				</tr>
				<tr>
					<td>Directed by:</td>
					<td><?PHP echo $mov_director; ?></td>
				</tr>
				<tr>
					<td>Year:</td>
					<td><?PHP echo $mov_year; ?></td>
				</tr>
				<tr>
					<td>Time:</td>
					<td><?PHP echo $mov_length; ?> minutes</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!--checkin connections?-->
<form method='POST'>
	<input type='hidden' name='new_mov_id' value="<? echo $mov_id; ?>">
	<input type=checkbox name=chk1 onClick="showhide('checkin_div')" >Publish this as an event to Checkin+
	<div id='checkin_div' style='visibility:hidden;'>
		
	</div>
	<input id='greenbutton' onMouseOver="changeColor(greenbutton,'green')" onMouseOut="changeColor(greenbutton,'black')" style='height:40px; background-color:black; color:white; font-weight:bold; border:0; border-radius:10px;' type='submit' name='set_new_mov' value='Save MoV'>

	
</form>


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

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

$search_keywords = $_GET['search_movie'];

if (($search_keywords=='')||($search_keywords=="Movie Title or Director")){
	$search_msg = "You did not enter any search keywords";
	$search_msg = "<div style='font-size:18; color:c1272d'>$search_msg</div>";
}else{
	$sql1 = "SELECT * FROM incnet.moviesMovies WHERE title LIKE '%$search_keywords%' OR director LIKE '%$search_keywords%'";
	
	$search_msg = "
	<div style='font-size:18; color:c1272d'>Search results for:</div>
	<div style='font-size:18; color:black'>\"$search_keywords\"</div>";

}

$query1 = mysql_query($sql1);
while($row1 = mysql_fetch_array($query1)){
	$search_movie_id = $row1['id'];
	$search_movie_title = $row1['title'];
	$search_movie_director = $row1['director'];	
	$search_movie_year = $row1['year'];
	$search_movie_languages = $row1['languages'];
	$search_movie_subtitles = $row1['subtitles'];
	$search_movie_time = $row1['length'];
	$search_movie_SE = $row1['special_edition'];
	$search_movie_picture = $row1['picture_filename'];
	$search_movie_medium = $row1['format'];

	if ($search_movie_picture!=''){
		$search_movie_picture = 'upload/' . $search_movie_picture;
		$divheight = '320px';
		$search_movie_picture ="&nbsp&nbsp <img src='$search_movie_picture' height='200' border=0/><br>";
	} else {
		$divheight = '120px';
	}

	$search_movie_languages = explode("," , $search_movie_languages);
	$langs_count = count($search_movie_languages);
	if ($langs_count > 4){
		$search_movie_languages = $search_movie_languages[0] . ", " . $search_movie_languages[1] . ", " . $search_movie_languages[2] . ", " . $search_movie_languages[3] . "...";
	}else{
		$search_movie_languages = implode(", ", $search_movie_languages);
	}

	$search_movie_subtitles = explode("," , $search_movie_subtitles);
	$subs_count = count($search_movie_subtitles);
	if ($subs_count > 4){
		$search_movie_subtitles = $search_movie_subtitles[0] . ", " . $search_movie_subtitles[1] . ", " . $search_movie_subtitles[2] . ", " . $search_movie_subtitles[3] . "...";
	}else if($subs_count == 0){
		$search_movie_subtitles = "No subtitles for this movie";
	}else{
		$search_movie_subtitles = implode(", ", $search_movie_subtitles);
	}


$movie_search_results = $movie_search_results . "
<div id= 'maindiv$search_movie_id' style='background-color:black; color:white; width:400px; height:25px; border-radius:6px' onClick=\"expandShrink(maindiv$search_movie_id, movie$search_movie_id, '$divheight')\" onMouseOver=\"changeColor(maindiv$search_movie_id,'green')\" onMouseOut=\"changeColor(maindiv$search_movie_id,'black')\">
	<div id='titlediv$search_movie_id' style='font-size:16;'>
		&nbsp$search_movie_title ($search_movie_year)
	</div>
	<div id='movie$search_movie_id' style='font-size:12; visibility:hidden'>
		$search_movie_picture
		&nbsp&nbsp Movie ID: $search_movie_id<br>
		&nbsp&nbsp Directed by: $search_movie_director<br>
		&nbsp&nbsp Languages: $search_movie_languages<br>
		&nbsp&nbsp Subtitles: $search_movie_subtitles<br>
		&nbsp&nbsp Time: $search_movie_time minutes<br>
		&nbsp&nbsp Medium: $search_movie_medium<br>	
	</div>
</div>
<div style='height:5px; width:20px'></div>";

}


//echo $search_keywords;

?>
<HTML>
<head>
<!--<title>In?net | Movie Library<title>-->

	<link rel="shortcut icon" href="favicon.ico" >
	<meta charset="UTF-8">
	<link rel="stylesheet" href="incnet.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="movies.css" type="text/css" media="screen" title="no title" charset="utf-8">
	
	<script>
		function changeColor(ele,color){
			ele.style.backgroundColor = color;
		}
	</script>
	
	<script>
		function expandShrink(ele1, ele2, newh){
			if (ele2.style.visibility == 'hidden'){
				ele1.style.height = newh;
				ele2.style.visibility = 'visible';
			} else {
				ele1.style.height = '25px';
				ele2.style.visibility = 'hidden';
			}
		}
	</script>
</head>

<body onLoad="document.search.search_movie.select()">

<div class="top_menubar">
	<?PHP echo $fullname; ?>
</div>

<br><br>

<div class="page_logo_container">
<table style="width:100%"><tr>

<td width='120' valign='top'>

<a href='index.php'><img src='movies.png' width='120' border=0/></a>




</td>
<td width="3"></td>
<td bgcolor="black" width=0.1px>
<td width="3"></td>
<td valign="middle">

<form name='search' method='GET' autocomplete='off' action='searchmovie.php'>
	Search for a movie:
	<input type='text' name='search_movie' style='height:30px' value='Movie Title or Director' onClick="document.search.search_movie.select()">
	<input id='searchmovie' onMouseOver="changeColor(searchmovie,'green')" onMouseOut="changeColor(searchmovie,'black')" style='height:30px; background-color:black; color:white; font-weight:bold; border:0; border-radius:10px;' type='submit' name='movie_search' value='Go'>
</form>
<br>
<?PHP echo $search_msg; ?>
<?PHP echo $movie_search_results; ?>


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

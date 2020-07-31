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
	header('location:index.php');
}

if (isset($_POST['search_user'])){
	$user_search = $_POST['search_user'];

	$sql1 = "SELECT * FROM incnet.coreUsers WHERE name LIKE '%$user_search%' OR lastname LIKE '%$user_search%' OR username LIKE '%$user_search%'";
	$query1 = mysql_query($sql1);
		while($row1 = mysql_fetch_array($query1)){
			$search_user_name = $row1['name'] . " " . $row1['lastname'];
			$search_user_id = $row1['user_id'];
			
			$user_select_form = $user_select_form . "<form method='POST'><input type='hidden' name='select_user_id' value='$search_user_id'><input type='submit' name='select_user' value='$search_user_name' id='userbutton$search_user_id' onMouseOver=\"changeColor(userbutton$search_user_id,'green')\" onMouseOut=\"changeColor(userbutton$search_user_id,'black')\" style='height:25px; background-color:black; color:white; border:0; border-radius:8px;'></form><div style='height:5px; width:20px;'></div>";
		}

}

if (isset($_POST['select_user'])){
	 $borrower_id = $_POST['select_user_id'];
	 $borrower_name = $_POST['select_user'];
	 
	 //echo "$borrower_id<br>$borrower_name";


}

	$movie_search_form = "
	<form method='POST'>
		<input type='text' name='search_movie' style='height:30px'>
		<input type='hidden' name='borrower_id' value='$borrower_id'>
		<input type='hidden' name='borrower_name' value='$borrower_name'>
		<input id='searchmovie' onMouseOver=\"changeColor(searchmovie,'green')\" onMouseOut=\"changeColor(searchmovie,'black')\" style='height:30px; background-color:black; color:white; font-weight:bold; border:0; border-radius:10px;' type='submit' name='movie_search' value='Go'>
	</form>
	";

if (isset($_POST['movie_search'])){
	$borrower_id = $_POST['borrower_id'];
	$borrower_name = $_POST['borrower_name'];
	$movie_search_keywords = $_POST['search_movie'];
	
	
	//movies that are already lend
	$sql3 = "SELECT * FROM incnet.moviesBorrows";
	$query3 = mysql_query($sql3);
		while($row3 = mysql_fetch_array($query3)){
			$lent_movies[] = $row3['movie_id'];
	}

	$sql2 = "SELECT * FROM incnet.moviesMovies WHERE title LIKE '%$movie_search_keywords%'";
	$query2 = mysql_query($sql2);
		while($row2 = mysql_fetch_array($query2)){
			$search_movie_title = $row2['title'];
			$search_movie_id = $row2['id'];
			$search_movie_director = $row2['director'];
			$search_movie_year = $row2['year'];
			$search_movie_format = $row2['format'];			
			
			
			if (in_array($search_movie_id, $lent_movies)){//movie lent to someone
			
				//movies that are already lent
				$sql4 = "SELECT borrower_id FROM incnet.moviesBorrows WHERE movie_id='$search_movie_id'";
				$query4 = mysql_query($sql4);
					while($row4 = mysql_fetch_array($query4)){
						$this_movie_borrower_id = $row4['borrower_id'];
				}

				$sql5 = "SELECT name, lastname FROM incnet.coreUsers WHERE user_id='$this_movie_borrower_id'";
				$query5 = mysql_query($sql5);
					while($row5 = mysql_fetch_array($query5)){
						$this_movie_borrower_name = $row5['name'] . " " . $row5['lastname'];
				}
				
	
				$movie_select_form = $movie_select_form . "
					<div style='height:5px; width:20px;'></div>
					<form method='POST' action='lend_movie_approval.php'>
						<input type='hidden' name='select_movie_id' value='$search_movie_id'>
						<input type='hidden' name='borrower_id' value='$borrower_id'>
						<input type='hidden' name='borrower_name' value='$borrower_name'>
						<input disabled='disabled' id='selectmovie$search_movie_id' style='height: 90px; text-align:left; width:400px; background-color:red; color:white; border:0; border-radius:10px;' type='submit' name='select_movie' value=' $search_movie_title ($search_movie_year)
Directed by: $search_movie_director
Format: $search_movie_format
Borrowed by: $this_movie_borrower_name'>
					</form>
				";

			}else{
				$movie_select_form = $movie_select_form . "
					<div style='height:5px; width:20px;'></div>
					<form method='POST' action='lend_movie_approval.php'>
						<input type='hidden' name='select_movie_id' value='$search_movie_id'>
						<input type='hidden' name='borrower_id' value='$borrower_id'>
						<input type='hidden' name='borrower_name' value='$borrower_name'>
						<input id='selectmovie$search_movie_id' onMouseOver=\"changeColor(selectmovie$search_movie_id,'green')\" onMouseOut=\"changeColor(selectmovie$search_movie_id,'black')\" style='height: 70px; text-align:left; width:400px; background-color:black; color:white; valign:center; border:0; border-radius:10px;' type='submit' name='select_movie' value=' $search_movie_title ($search_movie_year)
Directed by: $search_movie_director
Format: $search_movie_format'>
					</form>
				";

			}
		}
}


$user_search_form = "
<form method='POST'>
	<input type='text' name='search_user' style='height:30px'>
	<input id='searchuser' onMouseOver=\"changeColor(searchuser,'green')\" onMouseOut=\"changeColor(searchuser,'black')\" style='height:30px; background-color:black; color:white; font-weight:bold; border:0; border-radius:10px;' type='submit' name='user_search' value='Go'>
</form>
";



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
</head>

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
<h3>Lend Movies:</h3>

<?PHP

$cancelform = "<div style='font-size:20; color:c1272d'><form method='POST' action='lend_movies.php'><b>$borrower_name</b>&nbsp&nbsp<input id='cancel' onMouseOver=\"changeColor(cancel,'red')\" onMouseOut=\"changeColor(cancel,'FF6666')\" style='height:30px; width:30px; background-color:FF6666; color:white; font-size:25; border:0; border-radius:20px;' type='submit' name='cancel' value='X'></form></div></form>";

if (isset($_POST['user_search'])){
	echo "<div style='font-size:20; color:c1272d'>Search for a user:</div>";
	echo $user_search_form;	

	echo "<div style='font-size:20; color:c1272d'><b>OR</b></div>";
	
	echo "<div style='font-size:20; color:c1272d'>Select user:</div>";
	echo $user_select_form;
}else if (isset($_POST['select_user'])){
	echo "<div style='font-size:20; color:c1272d'>Search for a movie for:</div>$cancelform";
	echo $movie_search_form;
}else if (isset($_POST['movie_search'])){
	echo "<div style='font-size:20; color:c1272d'>Select movie for:</div>$cancelform";
	if ($movie_select_form==''){
		echo "The movie could not be found. Please try again";
		echo"
		<form method='POST'>
		<input type='text' name='search_movie' style='height:30px'>
		<input type='hidden' name='borrower_id' value='$borrower_id'>
		<input type='hidden' name='borrower_name' value='$borrower_name'>
		<input id='searchmovie' onMouseOver=\"changeColor(searchmovie,'green')\" onMouseOut=\"changeColor(searchmovie,'black')\" style='height:30px; background-color:black; color:white; font-weight:bold; border:0; border-radius:10px;' type='submit' name='movie_search' value='Go'>
	</form>";
	}else{
	echo $movie_select_form;
	}
}else{
	echo "<div style='font-size:20; color:c1272d'>Search for a user:</div>";
	echo $user_search_form;
}

/*
	echo $user_search_form;
	echo $user_select_form;
	echo $movie_search_form;
	echo $movie_select_form;
*/
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

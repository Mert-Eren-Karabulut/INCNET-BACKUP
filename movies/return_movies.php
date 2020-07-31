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
	$borrower_name = $_POST['select_user'];
	$borrower_id = $_POST['select_user_id'];

	$sql2 = "SELECT * FROM incnet.moviesBorrows, incnet.moviesMovies WHERE incnet.moviesBorrows.movie_id = incnet.moviesMovies.id AND incnet.moviesBorrows.borrower_id = '$borrower_id'";
	echo $sql2;
	$query2 = mysql_query($sql2);
	while($row2 = mysql_fetch_array($query2)){
		$borrows_id = $row2['id'];
		$borrows_title = $row2['title'];
		$borrows_year = $row2['year'];
		$borrows_director = $row2['director'];
		$borrows_format = $row2['format'];
		
		$returnform = $returnform . "
		<div style='height:5px; width:20px;'></div>
		<form method='POST'>
		<input type='hidden' name='movie_id' value='$borrows_id'>
		<input type='hidden' name='borrower_id' value='$borrower_id'>
		<input id='borrows$borrows_id' style='height: 90px; text-align:left; width:400px; background-color:black; color:white; border:0; border-radius:10px;' type='submit' name='select_return_movie' onMouseOver=\"changeColor(borrows$borrows_id,'green')\" onMouseOut=\"changeColor(borrows$borrows_id,'black')\" value='$borrows_title ($borrows_year)
Directed by: $borrows_director
Format: $borrows_format'>
		</form>";
		
	}
}

if (isset($_POST['select_return_movie'])){
	$returning_movie_id = $_POST['movie_id'];
	$returning_user_id = $_POST['borrower_id'];
	
	mysql_query("DELETE FROM incnet.moviesBorrows WHERE movie_id='$returning_movie_id' AND borrower_id='$returning_user_id'");
}
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
<?
if (in_array("801", $allowed_pages)) {
	echo 	"<a href='index.php'><img src='movies.png' width='120' border=0/></a>";
} else {
	header("location:index.php");
}
?>
</td>
<td width="3"></td>
<td bgcolor="black" width=0.1px>
<td width="3"></td>
<td valign="middle">
<h3>Return Movies: </h3>
<div style='font-size:20; color:c1272d'>Search for user:</div>
<form method='POST'>
	<input type='text' name='search_user' style='height:30px'>
	<input id='searchuser' onMouseOver="changeColor(searchuser,'green')" onMouseOut="changeColor(searchuser,'black')" style='height:30px; background-color:black; color:white; font-weight:bold; border:0; border-radius:10px;' type='submit' name='user_search' value='Go'>
</form>


	<?PHP
		if ($user_select_form!=''){
			echo "<br><div style='font-size:20; color:c1272d'>Select returning user:</div>";
			echo $user_select_form;
		}
		if($returnform!=''){
			echo "<br><div style='font-size:20; color:c1272d'>Select movie to be returned:</div>";
			echo $returnform;
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

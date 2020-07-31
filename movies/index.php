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

<div class="top_menubar">
	<?PHP echo $fullname; ?>
</div>

<br><br>

<div class="page_logo_container">
<table style="width:100%"><tr>

<td width='120' valign='top'>
<?PHP
	if (in_array("801", $allowed_pages)) {
		echo 	"<a href=\"#\" onclick=\"showhide('moviesmenu');\"><img src='movies.png' width='120' border=0/></a>";
} else {
		echo "<a href='../incnet'><img src='movies.png' width='120' border=0/></a>";
}
?>

<div id="moviesmenu" style="display: none;">
<a href='add_movie.php'>		Add Movies</a><br>
<a href='edit_movie.php'>		Edit Movies</a><br>
<!--<a href='mov.php'>					Movie of the Week</a><br>-->
<a href='lend_movies.php'>	Lend Movies</a><br>
<a href='return_movies.php'>Return Movies</a><br>
<a href='overdue.php'>View Lent Movies</a><br>
<a href='view_requests.php'>View Requested Movies</a><br>
<a href='../incnet'>				Back to INCNET</a>
</div>



</td>
<td width="3"></td>
<td bgcolor="black" width=0.1px>
<td width="3"></td>
<td valign="middle">
<h3>Welcome to the Movie Library</h3>


<!--	Movie of the week<br><br>-->
	

<table border="0">
	<tr>
		<td>
			<form name='search' method='GET' autocomplete='off' action='searchmovie.php'>
					Search for a movie:
		</td>
		<td>
			<input type='text' name='search_movie' style='height:30px' value='Movie Title or Director' onClick="document.search.search_movie.select()">
			<input id='searchmovie' onMouseOver="changeColor(searchmovie,'green')" onMouseOut="changeColor(searchmovie,'black')" style='height:30px; background-color:black; color:white; font-weight:bold; border:0; border-radius:10px;' type='submit' name='movie_search' value='Go'>
		</form>
		</td>
	</tr>
	<tr>
		<td>
			<form name='request' method='GET' autocomplete='off' action='requestmovie.php'>
			Request a movie:
		</td>
		<td>
			<input type='text' name='request_movie' style='height:30px' value='Movie Title' onClick="document.request.request_movie.select()">
			<input id='request' onMouseOver="changeColor(request,'green')" onMouseOut="changeColor(request,'black')" style='height:30px; background-color:black; color:white; font-weight:bold; border:0; border-radius:10px;' type='submit' name='movie_request' value='Go'>
			</form>
		</td>
	</tr>
</table>







</td>
</tr></table>

<br><br><br>
<div class="logoff_button">
<form name="logoff" method="POST">
<input type ="submit" name="logoff" value="Log Off">
</form>
</div>


<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© INÇNET</a>
</div>
</HTML>

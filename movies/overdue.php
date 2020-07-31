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
	
	<style>	
		@media print {
		body * {
		  visibility:hidden;
		}
		#section_to_print, #section_to_print * {
		  visibility:visible;
		}
		#section_to_print {
		  position:absolute;
		  left:0;
		  top:0;
		}
		}
	</style>

</head>
<body>
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

<a style='color:c1272d; font-weight: bold; text-decoration:none; font-size:12' href="javascript:window.print()">[Print this Page]</a>
<div id='section_to_print'>
<h3>Lent movies:</h3>
<p style='font-size:12'>*Overdue movies are printed in bold.</p>
<?PHP

$sql1 = "SELECT * FROM incnet.moviesBorrows";
$query1 = mysql_query($sql1);
while($row1 = mysql_fetch_array($query1)){
	$borrower_id = $row1['borrower_id'];
	$movie_id = $row1['movie_id'];
	$date_given = $row1['date_given'];
	$duration = $row1['duration'];

	$date_lent = $date_given;
	$date_given = explode("-", $date_given);
	
	
	$given_day = $date_given[2];
	$given_month = $date_given[1];
	$given_year = $date_given[0];

	$return_day = $given_day + $duration;

	$return_time = mktime(0,0,0,$given_month,$return_day,$given_year);
	$return_time = date("Y-m-d", $return_time);

	$sql2 = "SELECT name, lastname, email FROM incnet.coreUsers WHERE user_id='$borrower_id'";
	$query2 = mysql_query($sql2);
	while($row2 = mysql_fetch_array($query2)){
		$borrower_name = $row2['name'] . " " . $row2['lastname'];
		$borrower_email = $row2['email'];
	}

	$sql3 = "SELECT title, format FROM incnet.moviesMovies WHERE id='$movie_id'";
	$query3 = mysql_query($sql3);
	while($row3 = mysql_fetch_array($query3)){
		$movie_title = $row3['title'];
		$movie_format = $row3['format'];
	}

	
	$today=date("Y-m-d");
	if ($return_time<$today){
		echo "<b>$borrower_name must return $movie_title($movie_format) on $return_time.</b><br>";
		} else {
			echo "$borrower_name must return $movie_title($movie_format) on $return_time.<br>";	
		}

}


?>

</td>
</tr></table>
</div>
<br><br><br>
<div class="logoff_button">
<form name="logoff" method="POST">
<input type ="submit" name="logoff" value="Log Off">
</form>
</div>


<div class="copyright">
<a style="text-decoration:none; color: white" href="../incnet/copyright.php" >© 2012 Levent Erol</a>
</div>
</body>
</HTML>

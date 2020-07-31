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
		echo "<a href='index.php'><img src='movies.png' width='120' border=0/></a>";
} else {
		header("location:index.php");
}

	if (isset($_POST['delete_request'])){
		$delete_id = $_POST['delete_id'];
		mysql_query("DELETE from incnet.moviesRequests WHERE request_id='$delete_id'");
	}
?>

</td>
<td width="3"></td>
<td bgcolor="black" width=0.1px>
<td width="3"></td>
<td valign="middle">
<h3>Requested Movies:</h3>

<table border=1>
<tr>
	<td style='font-weight: bold'>Requested by</td>
	<td style='font-weight: bold'>Title</td>
	<td style='font-weight: bold'>Director</td>
	<td style='font-weight: bold'>Year</td>
	<td style='font-weight: bold'>Requested on</td>
	<td></td>
</tr>
<?PHP
	$sql = "SELECT * FROM incnet.moviesRequests";
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		$requested_id = $row['request_id'];	
		$requested_by = $row['user_id'];	
		$requested_title = $row['title'];
		$requested_director = $row['director'];
		$requested_year = $row['year'];				
		$requested_date = $row['date'];		
echo "<tr><td>$requested_by</td><td>$requested_title</td><td>$requested_director</td><td>$requested_year</td><td>$requested_date</td>
<td>
	<form method='POST'><input type='hidden' name='delete_id' value='$requested_id'><input type='submit' name='delete_request' value='Delete request'></form>
</td></tr>";

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

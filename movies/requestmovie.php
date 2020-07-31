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

$request_movie_title = $_GET['request_movie'];


if (isset($_POST['send_request'])){
	$requested_movie_title = $_POST['requested_title'];
	$requested_movie_director = $_POST['requested_director'];
	$requested_movie_year = $_POST['requested_year'];
	$today = date("Y-m-d");
	
	if ((($requested_movie_title=='')&&($requested_movie_director=='')&&($requested_movie_year==''))||(($requested_movie_title==''))){
		$error = 'You did not fill in enough information.<br> Please inform us as much as you can.';
	}else{
		mysql_query("INSERT INTO incnet.moviesRequests VALUES(NULL, '$user_id', '$requested_movie_title', '$requested_movie_director', '$requested_movie_year', '$today')");
		header("location:index.php");
	}
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
<body onLoad="document.requestform.requested_director.focus()">

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

<div style='font-size:20; color:c1272d'>Please give details about the movie you requested:</div>

<?PHP
	echo "<div style='font-size:20; color:c1272d'>" . $error . "</div>";
?>
<table>
<form method='POST' name='requestform' autocomplete='off'>
	<tr>
		<td>Title:</td>
		<td><input type='text' name='requested_title' maxlength='100' value="<?PHP echo $request_movie_title; ?>"></td>
	</tr>
	<tr>
		<td>Director:</td>
		<td><input type='text' name='requested_director' maxlength='100' value="<?PHP echo $requested_movie_director; ?>"></td>
	</tr>
	<tr>
		<td>Year:</td>
		<td><input type='text' name='requested_year' maxlength='4' size='4' value="<?PHP echo $requested_movie_year; ?>"></td>
	</tr>	
	<tr>
		<td></td><td>
			<input type='submit' name='send_request' value='Send Request' id='request' onMouseOver="changeColor(request,'green')" onMouseOut="changeColor(request,'black')" style='height:30px; background-color:black; color:white; font-weight:bold; border:0; border-radius:10px;'>
		</td>
	</tr>
</form>
</table>

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

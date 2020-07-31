<?php
	$redir = "#";
	if(!isset($_GET['site']))
		die("This page is intended for automated use only!");
	else if($_GET['site'] == "9fabcd6f8b4581a7f099" ){
		echo("
			<html>
			<head></head>
			<body></body>
			</html>
		");
		die();
	}
	header("Location: $redir");
?>
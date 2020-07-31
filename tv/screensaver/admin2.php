<?php
include ("db.php");
session_start();
	
retrieve_content();

	$baslik = $_SESSION['baslik'];
	$title = $_SESSION['title'];
	$metin = $_SESSION['metin'];
	$text = $_SESSION['text'];
	
	$i=0;
//	$blogcount = 1;
	$blogcount = count($title);	
	$displayitem = $blogcount - 1;
	while ($i<$blogcount) {
		$div []="
		
		<div class='baslik'>
		$baslik[$i] </br>
		</div>

		<div class='title'>
		$title[$i] </br>
		</div>

		
		<div class='metin'>
		$metin[$i]</br></br>
		<div>
		
		<div class='text'>
		$text[$i]
		</div>";
		
		$i++;
	}



?>

<HTML>

	<HEAD>
	<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<meta http-equiv="refresh" content="5" >
	
	</HEAD>
	
	
	<BODY>

<div style="word-wrap: break-word;" width="343" height="381">
	<?
	$i=$blogcount - 1;

	while ($i<$blogcount) {
		
		
		echo $div[$displayitem];
		
		
		$i++;
	}
	
	
	?>
</div>
	</br>

	
	</BODY>
	
</HTML>

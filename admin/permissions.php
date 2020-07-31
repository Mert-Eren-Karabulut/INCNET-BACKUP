<?php

require_once "../class/init.class.php";
$init = new init();

$dbase = new dbase;

$stmt = "SELECT * FROM corepage_ids ORDER BY page_id ASC";
$permissions = $dbase -> query($stmt, array());

foreach ($permissions as $perm)
{
	$lines[$perm["page_id"]] = "<span class='permissions'>" . $perm["page_id"] . "-" . $perm["meaning"] . "</span>";
}

?>
<!doctype html>
<html>
<head>
	<meta charset='UTF-8'>
	<title>
		Inçnet | Permission Manager
	</title>
	<meta name='viewport' content='initial-scale=1'>
	<link rel="shortcut icon" href='../img/favicon.ico'>
	<link rel='stylesheet' type='text/css' href='../css/input.css'>
	<link rel='stylesheet' type='text/css' href='../css/header.css'>
	<style>
		#content
		{
			background: rgba(181, 158, 159, 0.5);
			margin: 0 200px;
			position: relative;
			top: 0;
			width: 966px;
			margin-left: auto;
			margin-right: auto;
			box-sizing: border-box;
			padding: 60px 85px 10px;
		}
		.permitted
		{
			float: right;
			height: 20px !important;
			width: 150px !important;
			border-radius: 0 !important;
		}
		.permissions
		{
			line-height: 29px;
		}
		.addtag
		{
			height: 26px !important;
			width: 50px !important;
			color: #c1272d !important;
			background-color: white !important;
			float: right !important;
			border-radius: 0 !important;
		}
	</style>
</head>
<body>
	<header>
	</header>
	<section id='content'>
		<?php
		
		foreach ($lines as $id => $line)
		{
			echo $line . "<input type='button' class='addtag' value='Add'><input type='text' class='permitted' data-role='tagsinput' name='$id' value=''><br>";
		}
		
		?>
	</section>
	<script src="../js/jquery.min.js"></script>
	<script src="../plugins/jquery.intent.js"></script>
	<script>
	$(document).ready(function(){	
		/* make header work */
		$.ajax(
		{
			url:	"../incnet/header.php",
			type:	"GET"
		})
		.done(function(data)
		{
			$('header').html(data);
			/* count */
			count = $('div#moreMenu a').size();
			time = 100 * count;
			$("#moreLink").hoverIntent(function()
			{
				$("#moreMenu").slideDown(time);
			},
			function()
			{
				$("#moreMenu").slideUp(time);
			});
			$("#personalLink").hoverIntent(function()
			{
				$("#personalMenu").slideDown(400);
			},
			function()
			{
				$("#personalMenu").slideUp(400);
			});
		});
		$.ajax(
		{
			url: 	"../incnet/getname.php",
			type:	"GET"
		})
		.done(function(data)
		{
			$('#name').html(data);
		});
	});
</script>
</body>
</html>

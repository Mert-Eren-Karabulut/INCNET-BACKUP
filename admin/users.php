<?php

require_once "../class/init.class.php";
$init = new init;

$dbase = new dbase;

$stmt = "SELECT * FROM coreusers WHERE (class IS NULL OR (class != 'Grad' AND class != 'Old' AND class != '13')) AND (student_id >= 0) ORDER BY type, class * 1, lastname ASC";
$users = $dbase -> query($stmt, array());

foreach ($users as $user)
{
	$student_id = $user["student_id"];
	$fullname = $user["name"] . " " . $user["lastname"];
	$username = $user["username"];
	$dorm = $user["dormroom"];
	if ($user["type"] != "student")
	{
		$classtemp = $user["type"];
	}
	else
	{
		$classtemp = $user["class"];
	}
	
	$groups = array(
		"personnel" => "Personnel",
		"teacher" => "Teachers",
		"Hz" => "Preps",
		"9" => "9th Graders",
		"10" => "10th Graders",
		"11" => "11th Graders",
		"12" => "12th Graders",
	);
	
	if (($class != $classtemp)||($class == ""))
	{
		$lines[] = "<tr>
									<td>
										<b>
											{$groups[$classtemp]}
										</b>
									</td>
									<td>
									</td>
									<td>
									</td>
									<td>
										<span class='reset'>
											Reset Password
										</span>
									</td>
									<td>
										$classtemp
									</td>
									<td>
										default
									</td>";
	}
	
	$class = $classtemp;
	
	$lines[] = "<tr>
								<td>
									$fullname
								</td>
								<td>
									$student_id
								</td>
								<td>
									$username
								</td>
								<td>
									<button class='resett'>
										Reset Password
									</button>
								</td>
								<td>
									$class
								</td>
								<td>
									$dorm
								</td>
							</tr>";
}

/*
* list with php **
* group with -jQuery- php **
* design
* function with jQuery and AJAX 
*/

?>
<!doctype html>
<html>
<head>
	<meta charset='UTF-8'>
	<title>
		Inçnet | User Manager
	</title>
	<link rel="shortcut icon" href='../img/favicon.ico'>
	<!--<link rel='stylesheet' type='text/css' href='../css/input.css'>-->
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
			padding: 60px 75px 10px;
		}
		table
		{
			border: 1px solid black;
		}
		.reset
		{
			cursor: pointer;
		}
	</style>
	<meta name='viewport' content='initial-scale=1'>
</head>
<body>
	<header>
	</header>
	<section id='content'>
		<table>
			<tr>
				<td class='head column1'>
					Full Name
				</td>
				<td class='head'>
					Student Id
				</td>
				<td class='head column3'>
					Username
				</td>
				<td class='head column4'>
					Password
				</td>
				<td class='head column5'>
					Class
				</td>
				<td class='head column6'>
					Dorm
				</td>
			</tr>
			<?php
			
			foreach ($lines as $line)
			{
				echo $line;
			}
			
			?>
		</table>
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
		
		/* group people */
		$("td").parents("tr").css({"display":"none"});
		$("td:contains('Full Name')").parents("tr").css({"display":"table-row"});
		$("td:contains('default')").parents("tr").css({"display":"table-row"});
/*
		if ($("body").height < $(window).height)
		{
			$("#content").css({"height":"100vh"});
		}
		else
		{
			$("#content").css({"height":"auto"});
		}
*/	});
</script>
</body>
</html>

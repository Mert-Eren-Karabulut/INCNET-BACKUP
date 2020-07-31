<!doctype html>
<HTML>
	<head>
		<meta charset="utf-8">

    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>


	<body OnLoad="document.reservations.seat.focus();">
		<div class="header">
			<?PHP echo $fullname; ?>
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='../../incnet'><img style='position: relative; top:20px;' src='../../img/incnet12.png' width='140px'></a>
				</td>
				<div style='position:absolute; bottom:30px; z-index:2;' >
					<form name="logoff" method="POST">
						<input type ="submit" name="logoff" value="Log Off">
					</form>
				</div>
				<td valign='top' style='padding:7px; padding-top:15px;'>
		<div class=titleDiv><br/>Dönem Ödevi Seçimi Yapmayan Öğrenciler</div>
		<table>
			<tr><th>Ad</th><th>Soyad</th><th>Sınıf</th></tr>
			<?php
				$didntDoIt = array();

				include("../db_connect.php");
				mysql_select_db("incnet");

				$sql = "SELECT user_id FROM coreusers WHERE (class LIKE 'Hz' OR class LIKE '9' OR class LIKE '10' OR class LIKE '11IB' OR class LIKE '11MEB' OR class LIKE '12IB' OR class LIKE '12MEB') AND type='student' ORDER BY class ASC, lastname ASC";
				$result = mysql_query($sql);

				while($row = mysql_fetch_assoc($result)) $everyone[]=$row['user_id'];

				$connection = mysql_connect("94.73.170.253", "Tproject", "5ge353g5419L8fIEPv0E");
				mysql_select_db("tproject");

				$sql = "SELECT user_id FROM tp";
				$result = mysql_query($sql);

				if (!$result) {
						$message  = 'Invalid query: ' . mysql_error() . "\n";
						$message .= 'Whole query: ' . $sql;
						die($message);
					}

				$nonfuckers = array();
				while($row = mysql_fetch_array($result)){
					$nonfuckers[] = $row[0];
				}
				if(isset($_GET['debug'])){ echo "nonfuckers:";var_dump($nonfuckers);}
				if(isset($_GET['debug'])){ echo "<br/><br/>everyone:"; var_dump($everyone);}
				$didntDoIt = array_diff($everyone, $nonfuckers);
				if(isset($_GET['debug'])){ echo "<br/><br/>didntDoIt: "; var_dump($didntDoIt);}

				if(isset($_GET['debug']))die();

				include("../db_connect.php");
				mysql_select_db("incnet");

				$didntDoIt = array_unique($didntDoIt);

				foreach($didntDoIt as $fuckerId){
					$fucker = mysql_fetch_assoc(mysql_query("SELECT name, lastname, class FROM coreusers WHERE user_id=".$fuckerId));
					echo("<tr><td>".$fucker['name']."</td><td>".$fucker['lastname']."</td><td>".$fucker['class']."</td></tr>");
				}
			?>
		</table>

		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/materialize.min.js"></script>
	</body>
</html>

<html>
	<head>
		<title>Inçnet</title>
		<link rel="shortcut icon" href="favicon.ico" >
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	</head>
	
	<script>
		function startGame(){
			ele = document.getElementById("joke");
			ele.style.display='block';
			
		}
	</script>
	
	<body>
	
		<div style='width:700px; position:relative; margin-left:-350px; left:50%'>
			<div style='background-color:#c1272d; position:relative; top:2px; width:700px; height:40px;'>
				<table style='width:700px; height:40px; font-size:10pt' border='0'>
					<tr>
						<td valign='middle' style='text-align:center' ><a href='#about' style='color:white'>About INÇNET</a></td>
						<td valign='middle' style='text-align:center' ><a href='#developers' style='color:white'>the Team</a></td>
						<td valign='middle' style='text-align:center' ><a href='#tech' style='color:white'>Technologies</a></td>
						<td valign='middle' style='text-align:center' ><a href='#game' style='color:white'>The Game</a></td>
						<td valign='middle' style='text-align:center' ><a href='#contact' style='color:white'>Contact</a></td>
					</tr>
				</table>
			</div><br><br>
			<div style='z-index:2; position:absolute; width:200px; background-color:transparent; left:50%; margin-left:-100px'>
				<?PHP
					include("tetris.html");
				?>
			</div>
			<a name='#about'></a>
			<div style='color:#c1272d; font-size:16pt;'>About INÇNET</div><br>
			INÇNET is a set of <a href='http://en.wikipedia.org/wiki/Web_application' style='color:#c1272d'>web-based applications</a> designed to help it's users with everyday things.<br><br>
			It is powered by advanced <a href='#tech' style='color:#c1272d'>technologies</a> and dedicated <a href='comic.jpg' style='color:#c1272d'>developers.</a>We aim to reduce human effort using technology. We respect privacy and keep our data secure.<br>

			<hr>
			
			<a name='developers'></a>
			<div style='color:#c1272d; font-size:16pt;'>the Team</div><br>
			<b>Levent Erol ('14)</b> &nbsp Founder<br>
			<b>Utku Ünlü ('15)</b> &nbsp Developer<br>
			<b>Barış Demirel ('16)</b> &nbsp Developer, co-creator of Weekend departures<br>
			<b>Hakan Dingenç ('16)</b> &nbsp Developer, co-creator of Weekend departures<br>
			<b>Berk Can Özmen ('16)</b> &nbsp Developer, Doodles creator<br>
			<b>Barkın Şimşek ('17)</b> &nbsp Developer, creator of INÇNET for mobile devices<br>
			
			<hr>
			<a name='tech'></a>
			<div style='color:#c1272d; font-size:16pt;'>Technologies</div><br>
			As the technology pioneer of TEVITOL, we make use of the beset technology available.<br>
			We use open-source software to make our products more reliable and robust.
			Here are some of the technologies we use:<br><br>
			<b>PHP:</b> Php is the heart of Incnet. Everything you do on INÇNET is processed by code written in php.<br>
			<b>SQL:</b> All the information in the system is kept in an SQL database. SQL is the industry leading database solution used by millions of users worldwide.<br>
			<b>MD5 Hashing:</b> Here at Incnet, we support privacy. User passwords are kept as hashes instead of strings. This keeps your password safe from people.<br>
			<b>Linux Servers:</b> Incnet runs on Linux servers that are designed for security, high performance and reliability. Most of the important work is done on Linux computers aroud the world.<br>
			<b>Javascript:</b> INÇNET uses Javascript to give you a decent graphical interface.<br>
			
			<hr>
			<a name='game'></a>
			<div style='color:#c1272d; font-size:16pt;'>The game!</div><br>
			<b>Yes!</b> The game. Although we do some serious business, we do have a sense of humor. Inçnet is full of <a href='http://en.wikipedia.org/wiki/Easter_egg_%28media%29' style='color:#c1272d'>easter eggs</a> and small games like <a href="javascript:play();" style='color:#c1272d' >this one</a>. All you have to do is search for them. Don't forget to tell us about it if you find any!
			<br>

			<hr>
			<a name='contact'></a>
			<div style='color:#c1272d; font-size:16pt;'>Anything missing?</div><br>
			Weird as it sounds, developers are also human. We make mistakes, miss things and so on. If you think INÇNET can be improved or just feel like chatting, <a href='mailto:tevitolincnet@gmail.com' style='color:#c1272d'>send us an email!</a><br><br><br><br>


		</div>

	</body>
</html>
<!doctype html>
<html>
<head>
	<meta charset='UTF-8'>
	<title>
		Inçnet | About
	</title>
	<link rel="shortcut icon" href='../img/favicon.ico'>
	<link rel='stylesheet' type='text/css' href='../css/header.css'>
	<meta name='viewport' content='initial-scale=1'>
</head>
<body>
	<style>
	@media screen and (min-width:1801px){
	
		header nav
		{
			padding-top: 0.25px;
			padding-bottom: 0.25px;
			padding-left: 400px;
		}
		
		.linkWord{
			margin-left:10px;
			padding-right:20px;
		}
		.linkPicture{
			padding-right:20px;
		}	
	}
	@media screen and (max-width:1800px){
	header nav
		{
			padding: 0.25px 212.5px;
			padding-right: 0;
		}
	}
	#content
	{
		background: none repeat scroll 0 0 rgba(226, 226, 226, 0.9);
		height: 100vh;
		margin: 0 200px;
		position: relative;
		top: 0;
		width: 966px;
		box-sizing:border-box;
		margin-left: auto;
		margin-right: auto;
		padding: 50.5px 100px 0;
		/*z-index:-1;
		color: white; */
	}
	.title
	{
		font-weight: bold;
		display: inline-block;
		color:#c1272d;
	}
	.title2
	{
		/*text-decoration: underline;*/
		display: inline-block;
		font-weight: bold;
	}
	.tab
	{
		display: none;
		position: relative;
	}
	#img
	{
		height: 250px;
		position: relative;
		transform: translateX(-50%);
	}
	a
	{
		display: inline-block;
		color:#c1272d;
	}
	#imgDiv
	{
		padding-left: 383px;
		padding-top: 15px;
	}
	.dropContent
	{
		display: none;
	}
	.drop
	{
		cursor: pointer;
	}
	.half
	{
		display: block;
		margin: 5px;
	}
	p
	{
		margin: 0.5em 0;
	}
	</style>
	<header>
		<nav>
			<a href='index.php' class='linkPicture left'>
				<img src='../img/incnetWhite.png' alt='incnetWhite' id='headerLogo'>
			</a>
			<a href='#' class='linkWord left about' id='aboutLink'>
				&nbsp; About Us &nbsp;
			</a>
			<a href='#' class='linkWord left team' id='teamLink'>
				&nbsp; INÇNET Team &nbsp;
			</a>
			<a href='#' class='linkWord left tech' id='techLink'>
				&nbsp; Technologies &nbsp;
			</a>
			<a href='#' class='linkWord left pol' id='polLink'>
				&nbsp; Policies &nbsp;
			</a>
			<!--<a href='#' class='linkWord left eegg' id='eeggLink'>
				&nbsp; Easter Eggs &nbsp;
			</a>-->
			<a href='#' class='linkWord left clog' id='clogLink'>
				&nbsp; Change Log &nbsp;
			</a>
			<a href='#' class='linkWord left contact' id='contactLink'>
				&nbsp; Contact &nbsp;
			</a>
		</nav>
	</header>
	<section id='content'>
		<div id='imgDiv'>
			<a href='index.php'><img src='incnet14.png' alt='logo' id='img'></a>
		</div>
		<div id='about' class='tab'>
			<p>
				INÇNET is a set of
				<a href='http://en.wikipedia.org/wiki/Web_application'>
					web-based applications
				</a>
				 designed to help it's users with everyday things.
				<br>
				It is powered by advanced
				<a href='#tech' style=''>
					technologies
				</a>
				 and dedicated	developers.	We aim to reduce human effort using technology.
				<br>
			</p>
		</div>
		<div id='team' class='tab'>
			<p>
				<span class='title'>
					Founder
				</span>
				<br>
				<span class='title2'>
					Levent Erol ('14):
				</span>
				<br>
				The founder of the Team, the creator of INÇNET idea and the first developer of it. He developed until v1.2, and also many of the modules of INÇNET. He is now studying in Case Western Reserve University, USA.
			</p>
			<div>
				<span class='title drop'>
					Developer Team
					<img src='../img/header-drop.png' alt='drop' class='tabDrop'>
				</span>
				<div class='dropContent'>
					<span class='title2'>
						Arman Özcan ('21) :
					</span>	
						Member of Developer Team.
						<br>
					<span class='title2'>
						Bahar Kahraman ('21) :
					</span>	
						Member of Developer Team.
						<br>
					<span class='title2'>
						Berke Cüra ('20) :
					</span>	
						Member of Developer Team.
						<br>
					<span class='title2'>
						Berke Ünal ('21) :
					</span>	
						Member of Developer Team.
						<br>						
					<span class='title2'>
						Ege Feyzioğlu ('19): 
					</span>
					Head of Developer Team.
					<br>
					<span class='title2'>
						Ender Okur ('21) :
					</span>	
						Member of Developer Team.
						<br>
					<span class='title2'>
						Görkem Topal ('19): 
					</span>
					Current head of the INÇNET Team.
					<br>
					<span class='title2'>
						Kerem Öner ('21) :
					</span>	
						Member of Developer Team.
						<br>
					<span class='title2'>
						Mert Eren Karabulut ('20) :
					</span>	
						Head Assistant of Developer Team.
						<br>
						 
				</div>
			</div>
			<br class='half'>
			<div>
				<span class='title drop'>
					Design Team
					<img src='../img/header-drop.png' alt='drop' class='tabDrop'>
				</span>
				<div class='dropContent'>
					<span class='title2'>
						Berke Filiz ('19) :
					</span>	
						Member of Design Team.
						<br>
					<span class='title2'>
						Görkem Topal ('19): 
					</span>
					Head of the Design Team.
					<br>
					
				</div>
			</div>
			<br class='half'>
			<div>
				<span class='title drop'>
					Old Members
					<img src='../img/header-drop.png' alt='drop' class='tabDrop'>
				</span>
				<div class='dropContent'>
					<span class='title2'>
						Ada Dikici ('18):
					</span>
					Old designer for the re-write of INÇNET.
					<br>
					<span class='title2'>
						Barış Demirel	('16):
					</span>
					Old developer and co-creator of the module Weekend Departures. Worked on the re-write of the INÇNET.
					<br>
					<span class='title2'>
						Barkın Şimşek ('17):
					</span>
					Creator of the old mobile version of INÇNET. Also old designer for the re-write.
					<br>
					<span class='title2'>
						Berk Can Özmen ('16):
					</span>
					Creator of most of the celebrations. Worked on the re-write of INÇNET.
					<br>
					<span class='title2'>
						Dilge Gül ('18):
					</span>
					Old designer and icon creator for the re-write of INÇNET.
					<br>
					<span class='title2'>
						Göktuğ Çağlar Gönüller('18):
					</span>
					Old designer for the re-write of INÇNET and new celebrations creator.
					<span class='title2'>
						Hakan Dingenç ('16):
					</span>
					Co-creator of the module Weekend Departures. Worked on the re-write of the INÇNET.
					<br>
					<span class='title2'>
						Halil Utku Ünlü ('15):
					</span>
					Old developer and co-creator of the enrollment system for our school. Now, he is the head of the school web site team.
					<br>
					<span class='title2'>
						İdil Duman ('18):
					</span>
					Old designer for the re-write of INÇNET.
					<br>
					<span class='title2'>
						Hazal Ergelen ('18):
					</span>
					Old designer and icon creator for the re-write of the system.
					<br>
					<span class='title2'>
						Murat Kaan Meral ('18):
					</span>
					Creator of the mobile version of INÇNET. Worked on the re-write.
					<br>
					<span class='title2'>
						Senanur Bayram ('18):
					</span>
					 Old designer for the re-write of the system.
				</div>
			</div>
		</div>
		<div id='tech' class='tab'>
			<p>
				As the technology pioneer of TEVITOL, we make use of the best technology available.
				<br>
				We use open-source software to make our products more reliable and robust. Here are some of the technologies we use:
			</p>
			<p>
				<span class='title2'>
					PHP:
				</span>
				Php is the heart of INÇNET. Everything you do on INÇNET is processed by code written in php.
				<br>				
				<span class='title2'>
					SQL:
				</span>
				All the information in the system is kept in an SQL database. SQL is the industry leading database solution used by millions of users worldwide.
				<br>
				<span class='title2'>
					MD5 Hashing:
				</span>
				Here at INÇNET, we support privacy. User passwords are kept as hashes instead of strings. This keeps your password safe from people.
				<br>
				<span class='title2'>
					Linux Servers:
				</span>
				INÇNET runs on Linux servers that are designed for security, high performance and reliability. Most of the important work is done on Linux computers aroud the world.
				<br>
				<span class='title2'>
					Javascript:
				</span>
				INÇNET uses Javascript -and the jQuery framework- to give you a decent graphical interface.
				<br>
				<span class='title2'>
					AJAX:
				</span>
				The changes in INÇNET led to use of AJAX, to create asynchronous web pages.
				<br>
			</p>
		</div>
		<div id='pol' class='tab'>
			<p>
				<span class='title'>
					Information Policy:
				</span>
				<br>
				We know how information is important in the age we live. For everyone's security, we try to get as less information about you as possible. The information we collect from you, are used by school administration, and sometimes us, to give you a better experience of INÇNET.
				<br>
			</p>
			<p>
				<span class='title'>
					Privacy Policy:
				</span>
				<br>
				<!--We believe that power corrupts people. That's why, we try to give people the least privileges possible, so that your information is seen by less people.-->
        We are a bunch of kids playing 'programmer' on the interwebs. We put stuff here and there but we really have no idea what we are doing. We just like to act cool, create interfaces but we can't do any real programming.
				<br>
			</p>
		</div>
		<div id='eegg' class='tab'>
		Even though we are in a serious business, we do have sense of humour -in some sense- . INÇNET is full of
		<a href='http://en.wikipedia.org/wiki/Easter_egg_%28media%29'>
			easter eggs
		</a>
		and we will continue to add more. All you have to do is search for them. Don't forget to tell us about it if you find any!
		</div>
		<div id='clog' class='tab'>
			<p>
				<span class='title'>
					v1.3.0:	
				</span>
				<br>
				&nbsp;&nbsp;Change Log is added.<br>
				&nbsp;&nbsp;Summary of the modules are added to homepage.<br>
				&nbsp;&nbsp;Homepage is re-written in an Object-Oriented way.<br>
				&nbsp;&nbsp;UI has changed, header is used more effectively, sidebar is removed and only the center of the page is used, instead.<br>
				&nbsp;&nbsp;Login and index is merged into one index, and AJAX is used.<br>
			</p>
			<p>
				<span class='title'>
					v1.4.0:	
				</span>
				<br>
				&nbsp;&nbsp;Weekly Bulletin & Exam Schedule is added.<br>
				&nbsp;&nbsp;Some bugs are fixed in etut module.<br>
				&nbsp;&nbsp;Writeups page activated.<br>
				&nbsp;&nbsp;Troubles and bugs are fixed in mobile version.<br>
			</p>
			<p>
				<span class='title'>
					v1.4.1: Coming Soon	
				</span>
				<br>
				&nbsp;&nbsp;Activity Calendar & Registration page is added.<br>
				&nbsp;&nbsp;Password sender is working now.<br>
			</p>
		</div>
		<div id='contact' class='tab'>
		That's true that, we live and think like machine-at least some of us-, but we're still human beings. We can make mistakes and errors, and we do. If you ever encounter any
		<a href='http://en.wikipedia.org/wiki/software_bug'>
			bugs
		</a>
		, please let us know. You can either tell
		<a href='#' class='us'>
			us
		</a>
		in school, or
		<a href='mailto:tevitolincnet@gmail.com'>
			e-mail
		</a>
		us.
		<br>
		</div>
	</section>
	<script src="../js/jquery.min.js"></script>
	<script src="../plugins/jquery.rotate.min.js"></script>
	<script>
	$(document).ready(function()
	{
		if ($("div.tab:visible").length == 0)
		{
			$("#about").slideDown(300);
		}
		
		function runDeferred() {
			var args = arguments;
			if(args.length) {
					args[0]().done(function() {
						  runDeferred.apply(this, Array.prototype.slice.call(args, 1));
					});
			}
		}
		
		$("a.linkWord").click(function()
		{
			var classes = $(this).attr("class").split(/\s+/);
			var thisClass = classes[2];
			function step1()
			{
				return $("div.tab:visible").slideUp(300).promise();
			}
			function step2()
			{
				$("#"+thisClass).slideDown(300);
			}
			runDeferred(step1, step2);
		});
		
		$(".us").click(function()
		{
			function step1()
			{
				return $("div.tab:visible").slideUp(300).promise();
			}
			function step2()
			{
				$("#team").slideDown(300);
			}
			runDeferred(step1, step2);
		});
		
		$(".drop").click(function()
		{
			if ($(this).siblings(".dropContent:visible").length > 0)
			{
				$(this).siblings(".dropContent").slideUp(300);
				$(this).children("img.tabDrop").rotate(0);
			}
			else
			{
				$(".dropContent:visible").siblings(".drop").children("img.tabDrop").rotate(0);
				$(".dropContent:visible").slideUp(300);
				$(this).siblings(".dropContent").slideDown(300);
				$(this).children("img.tabDrop").rotate(180);
			}
		});
		
		$("a#minesweeper").click(function()
		{
			newwindow = window.open("minesweeper.html", "Minesweeper", 'height=450,width=510');
			if (window.focus)
			{
				newwindow.focus()
			}
		});
		
		$("a#tetris").click(function()
		{
			newwindow = window.open("tetris.html", "Tetris", 'height=500,width=525');
			if (window.focus)
			{
				newwindow.focus()
			}
		});
	});
	</script>
</body>
</html>

<?php

require_once "../class/init.class.php";
$init = new init;
error_reporting(0);
$id = $_SESSION["user_id"];

/* get permissions and set more dropown */
$more = array("Pool Reservations" => "../pool/index.php");
$dbase = new dbase;
$stmt = "SELECT page_id FROM corepermits WHERE user_id = :id";
$array = array(":id" => $id);
$permissions = $dbase -> query($stmt, $array);

foreach ($permissions as $user)
{
	$permits[] = $user["page_id"];
}

if (in_array("101", $permits)||in_array("102", $permits)||in_array("103", $permits)||in_array("901", $permits)||in_array("902", $permits)||in_array("903", $permits)||in_array("904", $permits))
{
	/* more with admin tools */
	$more["Admin Tools"] = "admintools.php";
}

if (in_array("150", $permits))
{
	/* webCam */
	$more["webCam"] = "../webCam/take.php";
}

if (in_array("160", $permits))
{
	/* Hiring */
	$more["Hiring Applications"] = "hiringadmin.php";
}

if (in_array("501", $permits))
{
	/* tevitolkayit */
	$more["tevitolkayıt"] = "../tevitolkayit/admin/index.php";
}

if (count($more) > 1)
{
	$navdiv = "
	<div class='linkWord left more' id='moreLink' style='border-right:0px;'>
		<span>
			More
		</span>
		<img src='../img/header-drop.png' alt='drop' class='dropimg'>
		<div class='dropMenu more' id='moreMenu'>";
	
	foreach ($more as $link => $href)
	{
		$navdiv .= "
			<a href='$href' class='dropWord left'>
				$link
			</a><br>";
	}
	
	$navdiv .= "
		</div>
	</div>";
}
else if (count($more) == 1)
{
	foreach ($more as $link => $href)
	{
		$navdiv = "
		<a href='$href' class='linkWord left'>
			$link
		</a>";
	}
}
else
{
	/* error */
}

$index = "
<section id='content'>
	<div id='icons'>
	</div>
	<section id='summary'>
		<img src='../img/checkin.png' alt='checkin' class='summaryLogo' id='checkinLogo'>
		<div class='summaryDiv' id='checkinDiv'>
		</div>
		<img src='../img/weekend.png' alt='weekend' class='summaryLogo' id='weekendLogo'>
		<div class='summaryDiv' id='weekendDiv'>
		</div>
		<img src='../img/etut.png' alt='etut' class='summaryLogo' id='etutLogo'>
		<div class='summaryDiv' id='etutDiv'>
		</div>
		<img src='../img/pool.png' alt='pool' class='summaryLogo' id='poolLogo'>
		<div class='summaryDiv' id='poolDiv'>
		</div>
	</section>
	<section id='bulletin'>
	
	</section>
</section>";
$login = "
<div class='form'>
	<form method='POST'>
		<span id='welcome'>Welcome!</span>
		<input type='text' name='username' placeholder='username' size='10'>
		<br>
		<input type='password' name='password' placeholder='&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;' size='10'>
		<br>
		<span id='remember'>
			<input type='checkbox' name='remember'>
			<label class='fildname' id='rememberme'>Remember Me</label>
		</span>
		<br>
		<span id='error'>
		</span>
		<input type='submit' name='signin' value='Sign In' id='signin'>
	</form>
</div>
<a href='about.php'><img src='../img/incnet.png' alt='incnet' id='incnetLogo'></a>
<div class='gradient'>
</div>";
$name = "Your Name";

if ($id != "")
{
	/* index */
	$user = new user;
	$user_info = $user -> user_info($id);
	foreach ($user_info as $info)
	{
		$name = $info["name"] . " " . $info["lastname"];
	}
	$content = $index;
	$jQuery = "$('#content').slideDown(900);
	fillContent();";
}
else
{
	/* login */
	$content = $login;
	$jQuery = "	$('nav').css({'top':'initial', 'bottom':'0px'});
	$('input:checkbox').iCheck({
   	checkboxClass: 'icheckbox_flat-grey',
  	radioClass: 'iradio_flat-grey'
  });
  ";
  $css = "	<link rel='stylesheet' type='text/css' href='../css/input.css'>
	<link rel='stylesheet' type='text/css' href='../plugins/iCheck/grey.css'>
	";
}
?>
<!doctype html>
<html>
<head>
	<meta charset='UTF-8'>
	<title>
		Inçnet | Home
	</title>
	<link rel="shortcut icon" href='../img/favicon.ico'>
	<link rel='stylesheet' type='text/css' href='../css/index.css'>
	<link rel='stylesheet' type='text/css' href='../css/header.css'>
	<?php
		if (isset($css))
		{
			echo $css;
		}
	?>
	<meta name='viewport' content='initial-scale=1'>
</head>
<body>
	<header>
		<nav>
			<a href='#' class='linkPicture left'>
				<img src='../img/incnetWhite.png' alt='incnetWhite' id='headerLogo'>
			</a>
			<a href='../checkin/index.php' class='linkWord left' id='checkinLink'>
				Checkin
			</a>
			<a href='../weekend/index.php' class='linkWord left' id='weekendLink'>
				Weekend Departures
			</a>
			<a href='../etut/index.php' class='linkWord left' id='etutLink'>
				Etut Reservations
			</a>
			<?php
			
				echo $navdiv;
				
			?>
			<div href='#' class='linkWord right personal' id='personalLink' style='border-right:0px;'>
				<span id='name'>
					<?php
			
					echo $name;
			
					?>
				</span>
				<img src='../img/header-drop.png' alt='drop' class='dropimg'>
				<div class='dropMenu personal' id='personalMenu'>
					<a href='../core/settings.php' class='dropWord right' id='settingLink'>
						Change Settings
					</a>
					<br>
					<a href='../profiles/edit.php' class='dropWord right' id='profileLink'>
						Profile Settings
					</a>
					<br>
					<a href='../core/hiring.php' class='dropWord right' id='hiringLink'>
						Apply to INÇNET
					</a>
					<br>
					<a href='../core/about.php' class='dropWord right' id='aboutLink'>
						About Us
					</a>
					<br>
					<a href='../core/logoff.php' class='dropWord right' id='logoffLink'>
						Sign Out
					</a>
				</div>
			</div>
		</nav>
	</header>
	<?php
	
	echo $content;
	
	?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!--<script src="../../jquery.min.js"></script>-->
	<script src='../plugins/iCheck/icheck.min.js'></script>
	<script src='../plugins/jquery.cookie.js'></script>
	<script>
	$(document).ready(function()
	{
		/* define functions */
		
		function hides()
		{
			/* effect of hiding the form and the picture */
			return $('#incnetLogo, div.form').hide(600).promise();
		}
		
		function moveTop()
		{
			/* effect of moving the navbar to top */
			$('nav').animate(
			{
				'bottom': 'initial',
				'top': '0px'
			}, 600);
			$('.gradient').animate(
			{
				'bottom': 'initial',
				'top': '-10px'
			}, 600);
			return $("nav, .gradient").promise()
		}
		
		function destroys()
		{
			/* destroy gradient */
			return $('.gradient').hide(0).promise();
		}
		
		function content()
		{
			/* write index */
			return $('header').after("<?php echo preg_replace( '/\r|\n/', '', $index); ?>").promise();			
		}
		
		function fillContent()
		{
			/* fill index */
			$.ajax(
			{
				url: 	"getname.php",
				type:	"GET"
			})
			.done(function(data)
			{
				$('#name').html(data);
			});
						
			return $.ajax(
			{
				url	:	"retrieveSummary.php",
				type:	"GET"
			})
			.done(function(data)
			{
				summaries = data.split("<br>");
				checkinSummary = summaries[0];
				$('#checkinDiv').html(checkinSummary);
				weekendSummary = summaries[1];
				$('#weekendDiv').html(weekendSummary);
				poolSummary = summaries[2];
				$('#poolDiv').html(poolSummary);
				etutSummary = summaries[3];
				$('#etutDiv').html(etutSummary);
			}).promise();
		}
		
		function slideNshow()
		{
			return $('#content').slideDown(900).promise();
		}

		//run functions one by one
		function runDeferred() {
			var args = arguments;
			if(args.length) {
					args[0]().done(function() {
						  runDeferred.apply(this, Array.prototype.slice.call(args, 1));
					});
			}
		}

		<?php if (isset($jQuery)){ echo $jQuery; } ?>
		$("#signin").click(function(event)
		{
			event.preventDefault();
			var formData = $("form").serialize();
			$.ajax(
			{
				url : "checkpass.php",
				type: "POST",
				data: formData
			})
			.done(function(data)
			{
				if (data == "true")
				{
					/* run index functions */
					runDeferred(hides, moveTop, destroys, content, fillContent, slideNshow);
				}
				else if (data == "false")
				{
					/* login error */
					$("input:text, input:password").val("").css({"background-color":"#fcf5de"});
					$("span#error").html("Wrong username or password!");
				}
				else
				{
					/* Unknown error */
					$("input:text, input:password").val("").css({"background-color":"#ffebef"});
					$("span#error").html("Unknown error! Please try again or apply to Inçnet Team.").css({"font-size":"0.5em"});
				}
			});
		});
		$("#moreLink").hover(function()
		{
			$("#moreMenu").slideDown(200);
		},
		function()
		{
			$("#moreMenu").slideUp(200);
		});
		$("#personalLink").hover(function()
		{
			$("#personalMenu").slideDown(400);
		},
		function()
		{
			$("#personalMenu").slideUp(400);
		});
	});
	</script>
</body>
</html>

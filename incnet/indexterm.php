<?php

require_once "../class/init.class.php";
$init = new init;

$detect = new Mobile_Detect;
if ( $detect->isMobile() ) {
	header("location:../mobile/index.php");
}

$id = $_SESSION["user_id"];

/* get permissions and set more dropown */
$more = array("Movie Library" => "../movie/index.php");
$dbase = new dbase;
/*
*
*
*
*
*
*
*
*
*
*
*
*
*/
$servername = "94.73.170.253";
$username = "Tproject";
$password = "5ge353g5419L8fIEPv0E";
$dbname = "tproject";

$conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn -> exec("SET NAMES utf8;");


$sec = true;
$termsql = $conn->prepare("SELECT * FROM tp WHERE user_id=:user");
$termsql -> execute(array(':user' => $id));
while($row = $termsql -> fetch()){
	$sec = false;
}

$classstmt = "SELECT class FROM coreusers WHERE user_id = :id";
$classarray = array(":id" => $id);
$classes = $dbase -> query($classstmt, $classarray);

foreach ($classes as $classelement)
{
	if(($classelement['class']=="Hz")||($classelement['class']=="9")||($classelement['class']=="10")||($classelement['class']=="11")||($classelement['class']=="12")){
		$secTwo = true;
	}else{
		$secTwo = false;
	}
}

if(($sec)&&($secTwo)){
$_SESSION['user_id'] = $id;
	header("Location: http://incnet.tevitol.org/termproject");
}
if (in_array("101", $permits)||in_array("102", $permits)||in_array("103", $permits)||in_array("901", $permits)||in_array("902", $permits)||in_array("903", $permits)||in_array("904", $permits))
{
	/* more with admin tools */
	$more["Admin Tools"] = "admintools.php";
}

if (in_array("901", $permits))
{
	/* student profiles */
	$more["Edit Student Profiles"] = "../profileBuilder/admin/fullProfile.php";
}

if (in_array("902", $permits))
{
	/* contact and social security */
	$more["Student Contact and Social Security Information"] = "../profileBuilder/admin/emergencySearch.php";
}

if (in_array("903", $permits))
{
	/* devices */
	$more["Student Device Information"] = "../profileBuilder/admin/deviceInfo.php";
}

if (in_array("904", $permits))
{
	/* summer camps */
	$more["Student Summer Camps Information"] = "../profileBuilder/admin/summerInfo.php";
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

$navdiv = "
<div class='linkWord left more' id='moreLink' style='border-right:0px;'>
	<span>
		More
	</span>
	<img src='../img/header-drop.png' alt='drop' class='dropimg'>
	<div class='dropMenu more' id='moreMenu'>
		<a href='../termproject/index.php' class='dropWord left'>
			Term Project
		</a><br>";

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

$today = date("Y-m-d");

$todayQuery = "SELECT picture, link, title FROM coredoodles WHERE date = :date";
$todayArray = array(':date' => $today);

$celebPicture = "../img/incnet.png";
$celebLink = "about.php";
$celebTitle = "";

$todayResult = $dbase -> query($todayQuery, $todayArray);

foreach($todayResult as $celeb){
    $celebPicture = $celeb["picture"];
    $celebLink = $celeb["link"];
    $celebTitle = $celeb["title"];
}


$index = "
<section id='content'>
	<div id='icons'>
	</div>
	<section id='summary'>
		<img src='../img/checkin.png' alt='checkin' class='summaryLogo' id='checkinLogo'>
		<div class='summaryDiv' id='checkinDiv'>
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
		<input type='text' name='username' placeholder='username' size='10' autocomplete='off'>
		<br>
		<input type='password' name='password' placeholder='&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;' size='10' autocomplete='off'>
		<br>
		<span id='remember'>
			<input type='checkbox' name='remember'>
			<label class='fildname' id='rememberme'>Remember Me</label>
		</span>
		<br>
		<a href='forgot.php' id='forgot'>
			Forgot your password?
		</a>
		<br>
		<span id='error'>
		</span>
		<input type='submit' name='signin' value='Sign In' id='signin'>
	</form>
</div>
<a href='$celebLink'><img src='$celebPicture' alt='incnet' title='$celebTitle' id='incnetLogo'></a>
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
  headernw();
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
			<a href='../checkin2/index.php' class='linkWord left' id='checkinLink'>
				Checkin
			</a>
			<a href='../pool/index.php' class='linkWord left' id='poolLink'>
				Pool Reservations
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
					<a href='../incnet/changepass.php' class='dropWord right' id='settingLink'>
						Change Password
					</a>
					<br>
					<a href='../incnet/hiring.php' class='dropWord right' id='hiringLink'>
						Apply to INÇNET
					</a>
					<br>
					<a href='../incnet/about13.php' class='dropWord right' id='aboutLink'>
						About Us
					</a>
					<br>
					<a href='../incnet/logoff.php' class='dropWord right' id='logoffLink'>
						Sign Out
					</a>
					<br>
				</div>
			</div>
		</nav>
	</header>
	<?php

	echo $content;

	?>
	<script src="../js/jquery.min.js"></script>
	<!--<script src="../../jquery.min.js"></script>-->
	<script src='../plugins/jquery.intent.js'></script>
	<script src='../plugins/iCheck/icheck.min.js'></script>
	<script src='../plugins/jquery.cookie.js'></script>
	<script>
	$(document).ready(function()
	{
		/* default focus */
		$("input[name='username']").focus();

		/* define functions */
		function headernw()
		{
			$('a.dropWord, a.linkWord').each(function ()
			{
				$(this).attr("href", "#");
			});
		}

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
			location.reload();
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

			/* make header work */
			$.ajax(
			{
				url:	"header.php",
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

			/* retrieve summary */
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
					$("input[name='username']").focus();
				}
				else if (data == "grad")
				{
					$("input:text, input:password").val("").css({"background-color":"#fcf5de"});
					$("span#error").html("You've already been graduated!");
					$("input[name='username']").focus();
				}
                                else if(data == "old")
                                {
                                        $("input:text, input:password").val("").css({"background-color":"#fcf5de"});
					$("span#error").html("You are not a member of school!");
					$("input[name='username']").focus();
                                }
				else
				{
					/* Unknown error */
					$("input:text, input:password").val("").css({"background-color":"#ffebef"});
					$("span#error").html("Unknown error! Please try again or apply to Inçnet Team.").css({"font-size":"0.5em"});
					$("input[name='username']").focus();
				}
			});
		});
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
	</script>
</body>
</html>

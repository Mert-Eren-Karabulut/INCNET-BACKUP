<?php

require_once "../class/init.class.php";
$init = new init;

$id = $_SESSION["user_id"];
$user_id = $_SESSION["user_id"];
$user = new user;
$user_info = $user -> user_info($id);

include("../db_connect.php");
mysql_select_db("incnet");

foreach ($user_info as $info)
{
	$name = $info['name'] . " " . $info['lastname'];
}


	
	$res = mysql_query("SELECT * FROM coreusers WHERE user_id = $user_id") or die("annen ".mysql_error());
		while($row = mysql_fetch_assoc($res)){
			if(!in_array($row['class'], explode(",","11IB,12IB")) || true){
				//$hahalol =	"<a href='/termproject/index.php' class='linkWord left' id='schLink'> Term Project </a>";
			}
		}
	


$more = array("Movie Library" => "../movies/index.php", "Writeups" => "../writeups/index.php");
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
if (in_array("401", $permits))
{
	/* Public Display */
	$more["Public Display"] = "../tv/admin.php";
}

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

echo "<nav ".(($_SESSION['user_id'] == 1249) ? "style=\"padding-left: 200px;\"" : "") .">
	<a href='#' class='linkPicture left'>
		<img src='../img/incnetWhite.png' alt='incnetWhite' id='headerLogo'>
	</a>
	<a href='../checkin2/index.php' class='linkWord left' id='checkinLink'>
		Checkin
	</a>
	<a href='../pool/index.php' class='linkWord left' id='weekendLink'>
		Pool Reservations
	</a>
	<a href='../etut/index.php' class='linkWord left' id='etutLink'>
		Etut Reservations
	</a>";
	echo "	<a href='../weekend' class='linkWord left' id='schLink'>
		Weekend Departures
	</a>";
	echo($hahalol);
	echo"
	<a href='bulletin.php' class='linkWord left' id='schLink'>
		Weekly Bulletin
	</a>

	$navdiv
	<div href='#' class='linkWord right personal' id='personalLink' style='border-right:0px;'>
		<span id='name'>
			$name
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
			<a href='../incnet/about.php' class='dropWord right' id='aboutLink'>
				About Us
			</a>
			<br>
			<a href='../incnet/logoff.php' class='dropWord right' id='logoffLink'>
				Sign Out
			</a>
			<br>
		</div>
	</div>
</nav>";

?>



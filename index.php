<?php


//Shows RIP page (/rip.php) as landing page.
//Set to true if the administration has killed off INÇNET. The day this variable is set to true is a sad day.
$i_am_dead = false;



/*$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$nokia = strpos($_SERVER['HTTP_USER_AGENT'],"Nokia");
if ($iphone || $android || $palmpre || $ipod || $berry || $nokia == true)
{
header("Location:mobile/incnet/index.php");
} else {
header("location:/incnet/index.php");
}*/


if($i_am_dead){
	header("Location: /rip.php");
	die();
}


session_start();




if(isset($_GET['insult_me'])) $_SESSION['lulz'] = "yes";
header("location:/incnet/index.php");
//header("location:/beback.php");
?>

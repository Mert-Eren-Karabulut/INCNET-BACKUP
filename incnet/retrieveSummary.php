<?php

function str_ends_with($haystack, $needle){
    return strrpos($haystack, $needle) + strlen($needle) ===
        strlen($haystack);
}

require_once "../class/init.class.php";
$init = new init;

$id = $_SESSION['user_id'];
$summaries = new summary;

/* Summary of Checkin */
$summaries -> checkin_sum($id);
$summary = $summaries -> checkin;

/* Summary of Weekend */
$summaries -> weekend_sum($id);
$summary .= "<br>" . $summaries -> weekend;

/* Summary of Pool */
$summaries -> pool_sum($id);
$summary .= "<br>" . $summaries -> pool;


/* Summary of Etut */
$summaries -> etut_sum($id);
$etutSummary = str_replace("coursera", "iMac Room", $summaries -> etut);//Sad...

if(str_ends_with($etutSummary, "0")){
	$etutSummary = substr($etutSummary, 0, strlen($etutSummary) - 10)."<br>&nbsp;";
}

$summary .= "<br>" . $etutSummary;

if($_SESSION['lulz'] == "yes"){
	$summary = str_replace("You don't attend any activity this week.", "You don't attend any activity this week. Sad.", $summary);
	$summary = str_replace("You don't have any pool reservations.", "You don't have any pool reservations. Go work out a little.", $summary);
	$summary = str_replace("you study", "you die a little more inside", $summary);
}

echo $summary;

?>

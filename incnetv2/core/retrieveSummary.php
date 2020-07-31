<?php

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
$summary .= "<br>" . $summaries -> etut;

echo $summary;

?>

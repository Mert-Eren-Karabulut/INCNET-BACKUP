<?php

require_once "../class/init.class.php";
$init = new init;

session_destroy();
setcookie("remember", "", time()-3600);
header("location:login.php");

?>

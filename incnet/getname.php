<?php

require_once "../class/init.class.php";
$init = new init;

$id = $_SESSION['user_id'];

$user = new user;
$user_info = $user -> user_info($id);
foreach ($user_info as $info)
{
	$name = $info['name'] . " " . $info['lastname'];
}

echo $name;

?>

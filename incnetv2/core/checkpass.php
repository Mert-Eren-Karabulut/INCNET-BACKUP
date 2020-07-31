<?php

require_once "../class/init.class.php";
$init = new init;

//define variables for user data
$username = $_POST['username'];
$password = $_POST['password'];

//retrieve user hash
$user = new user;
$hash = $user -> retrieve_hash($username);

//check hash and return
$hasher = new PasswordHash(8, FALSE);

//if ($hasher -> CheckPassword($password, $hash))
if ($hash == md5($password))
{
	echo "true";
	$user_info = $user -> user_info($username);
	foreach ($user_info as $info)
	{
		$id = $info["user_id"];
	}
	session_start();
	$_SESSION['user_id'] = $id;
}
else
{
	echo "false";
}

?>

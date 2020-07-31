<?php

require_once "../class/init.class.php";
$init = new init;

//define variables for user data
$username = $_POST['username'];
$password = $_POST['password'];

//retrieve user hash
$user = new user;
$hash = $user -> retrieve_hash($username);

//retrieve user class
$user_info = $user -> user_info($username);
foreach ($user_info as $info)
{
	$class = $info["class"];
}

//check hash and return
$hasher = new PasswordHash(8, FALSE);

//check if the person is graduated
if ($class == "Grad")
{
	echo "grad";
}
else if ($class == 'Old')
{
        echo "old";
}
//if ($hasher -> CheckPassword($password, $hash))
else if ($hash == md5($password))
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

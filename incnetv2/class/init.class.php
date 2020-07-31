<?php

class init
{
	public function __construct()
	{
		//error_reporting(0);
		session_start();
		require_once "dbase.class.php";
		require_once "PasswordHash.php";
		spl_autoload_register(array("init", "autoload"));
	}
	
	public function autoload($class)
	{
		include_once "$class.class.php";
	}
	
	
}
?>

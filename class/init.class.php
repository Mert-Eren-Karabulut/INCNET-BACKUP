<?php

class init
{
	public function __construct($check = false)
	{
		error_reporting(E_ALL);
		session_start();
		require_once "dbase.class.php";
		require_once "PasswordHash.php";
		spl_autoload_register(array("init", "autoload"));
		require_once "../mobile_detect/Mobile_Detect.php";
		
		//check login sit.
		if (($check)&&(!isset($_SESSION["user_id"])))
		{
			header("location:../incnet/index.php");
		}
		
	}
	
	public function autoload($class)
	{
		include_once "$class.class.php";
		
	}
	
	
}
?>

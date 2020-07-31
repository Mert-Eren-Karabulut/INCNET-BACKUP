<?php

class dbase
{
		protected $con;
		private static $dbhost = "94.73.150.252";
		private static $dbname = "incnet";
		private static $dbuser = "incnetRoot";
		private static $dbpass = "MertEren20";
		
	public function __construct()
	{
		$this -> con = new PDO("mysql:host=" . self::$dbhost . ";dbname=" . self::$dbname, self::$dbuser, self::$dbpass);
		$this -> con -> exec("SET NAMES utf8");
  }
	
	public function query($stmt, $array)
	{
		$query = $this -> con -> prepare($stmt);
		$query -> execute($array);
		return $query -> fetchAll();
	}
  
	public function queryUpdate($stmt, $array)
	{
		//update query...
    $queryUpdate = $this -> con -> prepare($stmt);
		$queryUpdate -> execute($array);
    //check how many data has been updated...
    return $queryUpdate -> rowCount();
	}
	
	public function __destruct()
	{
		$con = NULL;
		$query = NULL;
		$result = NULL;	
	}
}
?>

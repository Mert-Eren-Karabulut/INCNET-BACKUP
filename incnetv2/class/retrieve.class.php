<?php

require_once "dbase.class.php";

class retrieve extends dbase
{
	public function modules
	{
		$moduleq = $this -> con -> prepare("SELECT * FROM core_modules");
		$moduleq -> execute();
		$modules = $moduleq -> fetchAll();
		return $modules;
	}
}

?>

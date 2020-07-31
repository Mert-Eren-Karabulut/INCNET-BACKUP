<?php

class module extends dbase
{

	private $id;
	private $name;
	private $status;
	public $link;
	
	public function __constructor($module_name)
	{
		$infoq = $this -> con -> prepare("SELECT * FROM core_modules WHERE module_name = :name");
		$infoq -> execute(array("name" => $module_name));
		$info_result = $infoq -> fetchAll();
		foreach ($info_result as $info)
		{
			$this -> id = $info["id"];
			$this -> name = $info["name"];
			$this -> status = $info["status"];
			$this -> link = $info["link"];
		} 
	}
	
	public function toggle_status($step)
	{
		$new_status = ($this -> status + 1)%2;
		if ($step == 1)
		{
			return $new_status;
		}
		else if ($step == 2)
		{
			$update_statusq = $this -> con -> prepare("UPDATE core_modules SET status = :status WHERE module_id = :id");
			$update_statusq -> execute(array("status" => $new_status, "id" => $this -> id));
		}
	}
		
	public function link_position($new)
	{
		$update_linkq = $this -> con -> prepare("UPDATE core_modules SET link = :new WHERE module_id = :id");
		$update_linkq -> execute(array("new" => $new, "id" => $this -> id));
	}
	
	public function change_setting()
	{
		//later
	}
}


if (!empty($_POST))
{
	$module_id = $_POST["module_id"];
	$module_name = $_POST["module_name"];
	$module_status = $_POST["module_status"];
	$module_link = $_POST["module_link"];
	$module = new module($module_id);
	
	if (isset($module_status))
	{
		$module -> toggle_status();
	}
	
	if ($module_link != $module -> link)
	{
		$module -> link_position($module_link);
	}
}
?>

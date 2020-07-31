<?php

class season extends dbase
{

	private $user;
	
	public function __construct()
	{
		$this -> user = new user;
	}
	
	public function promote()
	{
		$all = $this -> user -> retrieve_all();
		foreach ($all as $person)
		{
			$user_id = $person["user_id"];
			$user_info = $this -> user -> user_info($user_id);
			foreach ($user_info as $info)
			{
				$student_class = $info["class"];
			}
		
			$class_array = array("prep", "9", "10", "11", "12", "grad");
			$class_index = array_search($student_class, $class_array);
			$class_index++;
			$column = "class";
			$value = $class_array[$class_index];
			$this -> user -> user_update($user_id, $column, $value);
		}
	}
		
	public function update_wlist($list, $column, $value)
	{
		$lines = explode("\n\r", $list);
		foreach ($lines as $user)
		{
			$student_info = explode(" ", $user);
			$student_id = $student_info[0];
			
			$idq = $this -> con -> prepare("SELECT user_id FROM core_users WHERE student_id = :student_id");
			$idq -> execute(array("student_id" => $student_id));
			$id_result = $idq -> fetchAll();
			foreach ($id_result as $id)
			{
				$user_id = $id["user_id"];
			}
			
			$this -> user -> user_update($user_id, $column, $value);
		}
	}
}


if (!empty($_POST))
{
	$season = new season;
	
	if (isset($_POST["promote"]))
	{
		$season -> promote();
	}
	else if (isset($_POST["drag_ndrop"]))
	{
		$user_id = $_POST["user_id"];
		$list_info = $_POST["list_info"];
		$info = $_POST["info"];
		$season -> con -> user_update($user_id, $list_info, $info);
	}	
	else if (isset($_POST["update_wlist"]))
	{
		$user_list = $_POST["user_list"];
		$list_info = $_POST["list_info"];
		$info = $_POST["info"];
		$season -> update_wlist($user_list, $list_info, $info);
	}
	else
	{
		$error = "Sorry, I couldn't understand you. Please try again or apply to system administrators.";
	}
}
?>

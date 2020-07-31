<?php

class user extends dbase
{
/*	public function __construct() 
	{
		
	}
*/	
	public function user_info($info)
	{
	
		$infoq = $this -> con -> prepare("SELECT * FROM coreusers WHERE user_id = :id OR username = :username");
		$infoq -> execute(array("id" => $info, "username" => $info));
		$info_result = $infoq -> fetchAll();
		
		return $info_result;
	}
	
	public function retrieve_all()
	{
		$allq = $this -> con -> prepare("SELECT user_id FROM coreusers");
		$allq -> execute();
		$all_result = $allq -> fetchAll();
		return $all_result;
	}
	
	public function retrieve_hash($username)
	{
		$passq = $this -> con -> prepare("SELECT password FROM coreusers WHERE username = :username");
		$passq -> execute(array("username" => $username));
		$pass_result = $passq -> fetchAll();
		
		foreach ($pass_result as $hashes)
		{
			$hash = $hashes['password'];
		}
		return $hash;
	}
	
	public function permission($user, $permission)
	{
		$upermq = $this -> con -> prepare("SELECT COUNT(1) FROM core_permits WHERE user_id = :user AND permission_id = :permission");
		$upermq -> execute(array("user" => $user, "permission" => $permission));
		$uperm_result = $upermq -> fetchAll();
		
		if ($uperm_result[0] = 0)
		{
			$gpermq = $this -> con -> prepare("SELECT COUNT(1) FROM core_grouppermits WHERE core_users.group = core_grouppermissions.group AND core_grouppermits.permission_id = :permission");
			$gpermq -> execute(array("permission" => $permission));
			$gperm_result = $gpermq -> fetchAll();
			return $gperm_result;
		}
		else
		{
			return $uperm_result;
		}
	}
	
	public function user_update($id, $column, $value)
	{
		$updateq = $this -> con -> prepare("UPDATE coreusers SET $column = :value WHERE user_id = :id");
		$updateq -> execute(array("value" => $value, "id" => $id));
	}
	
	public function add_user($name, $lastname, $username, $password, $student_id, $email, $class, $section, $dorm, $type, $group, $lang)
	{
		$addq = $this -> con -> prepare("INSERT INTO core_users VALUES ('', ':name', ':lastname', ':username', ':password', ':student_id', ':email', ':class', ':section', ':dorm', ':type', ':group', ':lang')");
		$addq -> execute(array("name" => $name, "lastname" => $lastname, "username" => $username, "password" => $password, "student_id" => $student_id, "email" => $email, "class" => $class, "section" => $section, "dorm" => $dorm, "type" => $type, "group" => $group, "lang" => $lang));
	}
}
?>

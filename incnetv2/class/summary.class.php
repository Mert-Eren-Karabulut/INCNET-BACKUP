<?php

class summary extends dbase
{

	private $today;
	private $week_later;
	private $week_days = array("", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
	public $checkin;
	public $etut;
	public $weekend;
	public $pool;
	
	public function __construct()
	{
		parent::__construct();
		$today = date("Y-m-d");
		$week_later = date("Y-m-d", strtotime("+1 week"));
	}
	
	public function checkin_sum($id)
	{
		$checkin_reserved = false;
		$checkin_q = $this -> con -> prepare("SELECT * FROM checkin2events, checkin2joins WHERE checkin2joins.user_id = :id AND checkin2joins.event_id = checkin2events.event_id AND checkin2events.date BETWEEN :today AND :week_later ORDER BY checkin2events.date ASC LIMIT 1");
		$checkin_q -> execute(array(":id" => $id, ":today" => $this -> today, ":week_later" => $this -> week_later));
		$checkin_results = $checkin_q -> fetchAll();
		
		foreach ($checkin_results as $checkin_tweek)
		{
			$checkin_title = $checkin_tweek["title"];
			$checkin_date = $checkin_tweek["date"];
			$checkin_time = $checkin_tweek["departure_time"];
			$checkin_location = $checkin_tweek["location"];
		}
		
		if ($checkin_reserved)
		{
			$this -> checkin = "You are going to $checkin_location for $checkin_title at $checkin_date $checkin_time";
		}
		else
		{
			$this -> checkin = "You don't attend any activity this week.";
		}
	}
	
	public function etut_sum($id)
	{
		$etut_reserved = false;
		$etut_room = "<script> alert($id);</script>";
		$etut_q = $this -> con -> prepare("SELECT * FROM etut_thisperiod WHERE user_id = :id AND date = :today");
		$etut_q -> execute(array(":id" => $id, ":today" => $this -> today));
		$etut_results = $etut_q -> fetchAll();
		
		foreach ($etut_results as $etut_today)
		{
			$etut_room = $etut_today["new_room"];
			$etut_seat = $etut_today["new_seat"];
			$etut_reserved = true;
		}
		
		if (!$etut_reserved)
		{
			$etut_q = $this -> con -> prepare("SELECT * FROM etut_defaultseats WHERE user_id = :id");
			$etut_q -> execute(array(":id" => $id));
			$etut_results = $etut_q -> fetchAll();
			
			foreach ($etut_results as $etut_today)
			{
				$etut_room = $etut_today["room"];
				$etut_seat = $etut_today["seat"];
			}
		}
		
		$this -> etut = "Today, you study in $etut_room at seat $etut_seat";
	}
	
	public function weekend_sum($id)
	{
		$weekend_reserved = false;
		$weekend_q = $this -> con -> prepare("SELECT * FROM weekenddepartures, weekendleaves, weekendbuses WHERE weekenddepartures.user_id = :id AND weekenddepartures.leave_id = weekendleaves.leave_id AND weekendbuses.bus_id = weekenddepartures.dep_bus_id");
		$weekend_q -> execute(array(":id" => $id));
		$weekend_results = $weekend_q -> fetchAll();
		
		foreach ($weekend_results as $weekend_tweek)
		{
			//$weekend_leave = $weekend_tweek["leave_name"];
			$weekend_date = $weekend_tweek["dep_date"];
			$weekend_date = date("l", strtotime($weekend_date));
			$weekend_bus = $weekend_tweek["bus_name"];
			$weekend_reserved = true;
		}
		
		if ($weekend_reserved)
		{
			$this -> weekend = "This week, you are going to $weekend_leave by $weekend_bus at $weekend_date";
		}
		else
		{
			$this -> weekend = "You are at school this weekend.";
		}
	}
	
	public function pool_sum($id)
	{
		$pool_reserved = false;
		$pool_q = $this -> con -> prepare("SELECT poolslots.day FROM poolrecords, poolslots WHERE poolslots.slot_id = poolrecords.slot_id AND poolrecords.user_id = :id AND poolrecord.record_id > :today ORDER BY poolslots.day, poolslots.time_start ASC LIMIT 1");
		$pool_q -> execute(array(":id" => $id, ":today" => $this -> today));
		$pool_results = $pool_q -> fetchAll();
		
		foreach ($pool_results as $pool_tweak)
		{
			$pool_day = $pool_tweek["day"];
			$pool_reserved = true;
		}
		
		if ($pool_reserved)
		{
			$this -> pool = "You will swim at " . $this -> week_days[$pool_day];
		}
		else
		{
			$this -> pool = "You don't swim until the end of the week.";
		}
	}
}

?>

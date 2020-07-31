<?PHP
	
	///////		Autoexec:
	
	checkCoursera();
	
	///////
	
	
	function startWith($string, $query){
		return substr($string, 0, strlen($query)) === $query;
	}
	
	function spacesToCamelCase($str){
		$chars = str_split($str);
		$str = "";
		foreach($chars as $char){
			if($char == " ") $upper = true;
			else{
				if($upper) $str.=strtoupper($char);
				else $str.=$char;
			}
		}
		return $str;
	}
	
	function camelCaseToSpaces($str){
		$chars = str_split($str);
		$str = "";
		$number = false;
		foreach($chars as $char){
			if(is_numeric($char)){
				if($once) $number = true;
				else{
					$number = true;
					$once = false;
				}
			}else{
				$number = false;
				$once = true;
			}
			if(strtolower($char) != $char || $number) $str.=" ".strtolower($char);
			else $str.=$char;
		}
		return $str;
	}

	function humanDate ($date){
		$months = array('','January','February','March','April','May','June','July','August','September','October','November','December');
		$date = explode("-", $date);
		return $date[2] . " " .  $months[((int) $date[1])] . " " . $date[0];
	}
	
	function checkStudent ($user){
		$sql = "SELECT type FROM coreusers WHERE user_id = $user";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$type=$row[0];
		}
		if ($type=='student'){
			return true;
		}
	}

	function checkList ($user){
		$sql = "SELECT user_id FROM corepermits WHERE user_id = $user AND page_id=350";
		//echo $sql;
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$chk=$row[0];
		}
		if ($chk>0){
			return true;
		}
	}

	function checkAdmin ($user){
		$sql = "SELECT user_id FROM corepermits WHERE user_id = $user AND page_id=351";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$chk=$row[0];
		}
		if ($chk>0){
			return true;
		}
	}


  /*
	function getAvalSeat ($room, $date){
		$sql = "SELECT COUNT(*) FROM etut_thisPeriod WHERE new_room='$room' AND date='$date'";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$count=$row[0];
		}
		$count=$count+1;
		return $count;
		//return getNewWeekdaySeat ($room, $date);
	}*/
	
	$seats = array(array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25), array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15));
	
	function getNewWeekdaySeat ($room, $date, $hour){
		$setSeat = -1;
		$sql = "SELECT new_seat FROM etut_thisPeriod WHERE(hour='$hour' and new_room='$room' AND date='$date') OR (hour='$hour' AND date='$date' AND new_seat LIKE 'coursera%') ORDER BY new_seat ASC";
    $query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$takenSeats[] = $row["new_seat"];
		}
		
		$temp_conn = mysqli_connect("94.73.150.252", "incnetRoot", "6eI40i59n22M7f9LIqH9", "incnet");
		$res = mysqli_query($temp_conn, "SELECT * FROM etutVars WHERE name LIKE \"class%quota\"");
		
		$quotas = array();
		
		while($row = mysqli_fetch_assoc($res)){
			$quotas[$row['name']] = $row['value'];
		}
		
		unset($temp_conn);
		
		//var_dump($seats);
		if ($room=='lap'){
			$allSeats = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
		}else if ($room=='comp'){
			$allSeats = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
		}else if ($room == 'coursera'){
			$allSeats = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
		}else if ($room == 'classroom1'){
			for($i = 1; $i <= $quotas['class1_quota']; $i++){
				$allSeats[]=$i;
			}
		}else if ($room == 'classroom2'){
			for($i = 1; $i <= $quotas['class2_quota']; $i++){
				$allSeats[]=$i;
			}
		}
		$i=0;
		while ($i<(count($allSeats))){
			if (($allSeats[$i])==($takenSeats[$i])){
				$i++;
			} else {
				$setSeat = $allSeats[$i];
				break;
			}
		}
		
		//if(courseraCount($date, $hour) && $setSeat == -1) $setSeat = -2;
		
		return $setSeat;
	}

/*
	function getNewWeekdaySeat1 ($room, $date, $hour)
	{
		$sql = "SELECT new_seat FROM etut_thisperiod WHERE date='" . $date . "' AND hour='" . $hour . "' AND new_room='" . $room . "'" ;
        //echo $sql;
		$sqlResult = mysql_query($sql);
		$seat = 1;
        $array= array();
		while ($row = mysql_fetch_array($sqlResult, MYSQL_BOTH))
		{
			array_push($array,$row['new_seat']);
		}

        while(in_array($seat,$array)){
            $seat++;
        }

        //print_r($array);
		return $seat;

	}

	function getSeatArray($room, $date, $hour)
	{
		$sql= "SELECT new_seat FROM etut_thisperiod WHERE date='" . $date . "' AND new_room='" . $room . "' AND hour='" . $hour . "'";
		//echo $sql;
        $sqlResult = mysql_query($sql);
		$seat = 1;
		$arrayOne = array();
        $array= array();
        $while = 30;

        while ($row = mysql_fetch_array($sqlResult, MYSQL_BOTH))
		{
			array_push($arrayOne, $row['new_seat']);
		    //echo $row['new_seat'];
        }
		switch($room){
            case "lap":$while = 30;break;
            case "comp": $while = 15;break;
        }
		while($seat <= $while){
            if(!in_array($seat, $arrayOne)){
                array_push($array, $seat);
             }
            $seat ++;
        }
       // print_r($array);

		return $array;
	}

	function getNewWeekdaySeat2 ($place, $day)
	{
		$arrayOne = getSeatArray($place, $day, "1");
		$arrayTwo = getSeatArray($place, $day, "2");
		$result = array_intersect($arrayTwo, $arrayOne);
        echo ' <br><br>';
       // print_r($result);
		foreach($result as $int){
            return $int;
        }
	}
  */

	function courseraCount($date, $hour){
		$sql = "SELECT new_seat FROM etut_thisPeriod WHERE new_room='coursera' AND date='$date' AND hour='$hour'";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$reserved[] = $row[0];
		}
		//die("Maintenance");
		if(count($reserved)<16){
		  return true;
		}else{
		  return false;
		}
	}
	function getAvalWeekendSeat($room){//get the number of the seat to be booked.
		$setSeat = 100;
		//echo $room;
		$room=explode("_", $room);
		$day = $room[0];//sat or sun
		if ($day=='sat'){
			$day=0;//sat
		} else {
			$day=1;//sun
		}
		$room = $room[1];//lap or comp

		$sql = "SELECT new_seat FROM etut_weekend WHERE new_room='$room' AND day='$day' ORDER BY new_seat ASC";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$takenSeats[] = $row[0];
		}
		//echo("takenSeats: ");
		//var_dump($takenSeats);
		//var_dump($seats);
		if ($room=='lap'){
			$allSeats = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
		}else if ($room=='comp'){
			$allSeats = array(1,2,3,4,6,7,8,9,10,11,12,13,14,15);
		}else if ($room == 'coursera'){
			$allSeats = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
		}
		$i=0;
		while ($i<(count($allSeats))){
			if (($allSeats[$i])==($takenSeats[$i])){
				$i++;
			} else {
				$setSeat = $allSeats[$i];
				break;
			}
		}
		return $setSeat;
	}



	function getDefaultSeat($user){
		$sql = "SELECT seat FROM etut_defaultSeats WHERE user_id='$user'";
			$query = mysql_query($sql);
			while($row=mysql_fetch_array($query)){
				$seat=$row[0];
			}
			return $seat;
	}

	function getDefaultRoom($user){
		$sql = "SELECT room FROM etut_defaultSeats WHERE user_id='$user'";
			$query = mysql_query($sql);
			while($row=mysql_fetch_array($query)){
				$seat=$row[0];
			}
			return $seat;
	}

	function getWeekdayRoom ($user, $date, $hour){
		$sql = "SELECT new_room FROM etut_thisPeriod WHERE user_id='$user' and date='$date' AND hour='$hour'";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$room=$row[0];
		}
		if ($room==''){
			$sql = "SELECT room FROM etut_defaultSeats WHERE user_id='$user'";
			$query = mysql_query($sql);
			while($row=mysql_fetch_array($query)){
				$room=$row[0];
			}
		}else if($room == "coursera"){
			$room = "iMac Room";
		}
		return $room;
	}

	function getWeekdaySeat ($user, $date, $hour){
		$sql = "SELECT new_seat FROM etut_thisPeriod WHERE user_id='$user' and date='$date' AND hour='$hour'";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$seat=$row[0];
		}
		if ($seat==''){
			$seat = getDefaultSeat($user);
		}
		return $seat;
	}

	function getWeekendRoom ($user, $day){
		$today = time();
		$thisThursdayIsh = $today - (3 * 24 * 3600 + 100);
		$formattedThisThursdayIsh = date('Y-m-d H:i:s', $thisThursdayIsh);
		$sql = "SELECT new_room FROM etut_weekend WHERE user=$user AND day=$day AND timestamp > '$formattedThisThursdayIsh'";
		if(isset($_GET['debug']))echo $sql;
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$room=$row[0];
		}
		if ($room==''){
			$sql = "SELECT room FROM etut_defaultSeats WHERE user_id='$user'";
			$query = mysql_query($sql);
			while($row=mysql_fetch_array($query)){
				$room=$row[0];
			}
		}
		//echo('$room = '.$room);
		return $room;
	}

	function getWeekendSeat ($user, $day){
		$today = time();
		$thisThursdayIsh = $today - (3 * 24 * 3600 + 100);
		$formattedThisThursdayIsh = date('Y-m-d H:i:s', $thisThursdayIsh);
		$sql = "SELECT new_seat FROM etut_weekend WHERE user=$user AND day=$day AND timestamp > '$formattedThisThursdayIsh'";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$seat=$row[0];
		}
		if ($seat==''){
			$sql = "SELECT seat FROM etut_defaultSeats WHERE user_id='$user'";
			$query = mysql_query($sql);
			while($row=mysql_fetch_array($query)){
				$seat=$row[0];
			}
		}
		return $seat;
	}



	function bookedHrs ($user){
		$sql = "SELECT COUNT(*) FROM etut_thisPeriod WHERE user_id='$user' AND (new_room!='coursera' OR (date > '2017-12-17' AND new_room='coursera'))";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$count=$row[0];
		}
		return $count;
	}

	function allowedHrs ($user){
		$sql = "SELECT hours FROM etut_extrahours WHERE user_id='$user'";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$hours=$row[0];
		}
		$hours = $hours+6;
		return $hours;
	}

	function checkAllowance ($user){//to see if the user can book more computer hours
		if ((bookedHrs($user))>=(allowedHrs ($user))){
			echo "disabled='disabled'";
		}
	}
	
	function checkAllowanceReturn ($user){//to see if the user can book more computer hours
		if ((bookedHrs($user))>=(allowedHrs ($user))){
			return false;
		}else{
			return true;
		}
	}

	function checkinEvent ($user, $date){
		$sql = "SELECT checkin2events.event_id, checkin2events.title FROM checkin2events, checkin2joins WHERE checkin2events.date='$date' AND checkin2events.event_id = checkin2joins.event_id AND checkin2joins.user_id = $user AND checkin2joins.come='YES'";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$event=$row[1];
		}
		if ($event==''){
			$event ='-';
		}
		return $event;
	}


	function checkHome ($user, $date) {
		//$days = array("", "");
		$sql = mysql_query("SELECT * FROM incnet.weekendDepartures, incnet.weekendLeaves WHERE incnet.weekendDepartures.user_id = '$user' AND (incnet.weekendDepartures.dep_date <= '$date' AND incnet.weekendDepartures.arr_date >= '$date') AND incnet.weekendLeaves.leave_id = incnet.weekendDepartures.leave_id");
		while ($row = mysql_fetch_array($sql)) {
			$leave = $row['leave_name'];
			$dep_date = $row['dep_date'];
			$arr_date = $row['arr_date'];
			if ($date == $dep_date){
				$extra = "departing today";
			} else if ($date == $arr_date){
				$extra = "arriving today";
			}
		}
		return $leave . "-" . $extra;
	}
	
	
	function checkCoursera(){
		$dateTemp = isset($date) ? $date : "";
		$date = date("Y-m-d");
		
		$GLOBALS['iMacSaturdayEnabled'] = (getAvalWeekendSeat("sat_lap") == 100 && getAvalWeekendSeat("sat_comp") == 100);
		$GLOBALS['iMacSundayEnabled'] = (getAvalWeekendSeat("sun_lap") == 100 && getAvalWeekendSeat("sun_comp") == 100);
		$GLOBALS['iMacWeekdayEnabled'] = false;// && (getNewWeekdaySeat("lap", $date, "0") == -1 && getNewWeekdaySeat("lap", $date, "0") == -1);
		
		$date = $dateTemp;
		unset($dateTemp);
	}
?>

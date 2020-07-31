<?PHP

	function humanDate ($date){
		$months = array('','January','February','March','April','May','June','July','August','September','October','November','December');
		$date = explode("-", $date);
		return $months[($date[1])] . " " . $date[2] . ", " . $date[0];
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
	


/*	function getAvalSeat ($room, $date){
		$sql = "SELECT COUNT(*) FROM etut_thisPeriod WHERE new_room='$room' AND date='$date'";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$count=$row[0];
		}
		$count=$count+1;
		return $count;
		//return getNewWeekdaySeat ($room, $date);
	}*/
	
	function getNewWeekdaySeat ($room, $date){
		$setSeat = 100;
		$sql = "SELECT new_seat FROM etut_thisPeriod WHERE new_room='$room' AND date='$date' ORDER BY new_seat ASC";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$takenSeats[] = $row[0];
		}
		if ($room=='lap'){
			$allSeats = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30);
		}else if ($room=='comp'){
			$allSeats = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
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
	
	function courseraCount($date){
		$sql = "SELECT new_seat FROM etut_thisPeriod WHERE new_room='coursera' AND date='$date'";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$reserved[] = $row[0];
		}
		return count($reserved);
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

		if ($room=='lap'){
			$allSeats = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30);
		}else if ($room=='comp'){
			$allSeats = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
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

	function getWeekdayRoom ($user, $date){
		$sql = "SELECT new_room FROM etut_thisPeriod WHERE user_id='$user' and date='$date'";
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
		return $room;
	}
	
	function getWeekdaySeat ($user, $date){
		$sql = "SELECT new_seat FROM etut_thisPeriod WHERE user_id='$user' and date='$date'";
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
		$sql = "SELECT new_room FROM etut_weekend WHERE user=$user AND day=$day";
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
		return $room;
	}
	
	function getWeekendSeat ($user, $day){
		$sql = "SELECT new_seat FROM etut_weekend WHERE user=$user AND day=$day";
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
		$sql = "SELECT COUNT(*) FROM etut_thisPeriod WHERE user_id='$user' AND new_room!='coursera'";
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
		$hours = $hours+5;
		return $hours;
	}
	
	function checkAllowance ($user){//to see if the user can book more computer hours
		if ((bookedHrs($user))>=(allowedHrs ($user))){
			echo "disabled='disabled'";
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
?>






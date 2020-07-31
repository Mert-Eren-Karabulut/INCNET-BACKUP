<?php

/*
 *
 *
 *
 *
 * UTF-8 PROBLEMİMİZ VAR HARİCİ BİTTİ GALİBA ..
 * Sende  bi baksana utf-8 işine olmadı ben 9-10 tekrar bakarım
 *
 *
 *
 *
 */


    include ("db_connect.php");
    $con;
    mysql_select_db("incnet");
    mysql_set_charset("utf8") or die("Cannot set charset");
    if (!$con){
        die('Could not connect: ' . mysql_error());
    }

    $array = array();
    $json = array();
/*
    $friday = date("Y-m-d", strtotime ("next friday"));
    $sunday = date("Y-m-d", strtotime ("next sunday"));
*/
    $sql = "SELECT coreusers.user_id ,coreusers.name, coreusers.lastname, coreusers.class, coreusers.dormroom, coreusers.student_id, etut_defaultseats.room, etut_defaultseats.seat, weekenddepartures.dep_bus_id, weekenddepartures.arr_bus_id, weekenddepartures.leave_id, weekenddepartures.leave_group, weekenddepartures.dep_date, weekenddepartures.arr_date FROM coreusers, etut_defaultseats, weekenddepartures WHERE coreusers.user_id=etut_defaultseats.user_id AND coreusers.user_id=weekenddepartures.user_id AND coreusers.class!='Old' AND coreusers.class!='Grad' AND coreusers.class!='13'";
    
    $result = mysql_query($sql);

    if(!$result)
    {
        die("mysql failed:" . mysql_error());
    }
//echo "before while !!";
    while($row = mysql_fetch_array($result))
    {
        $fri_dorm = 1;
        $sat_etut = 1;
        $sat_dorm = 1;
         
        //echo "in while !!";
        $array["name"] = $row["name"];
        //echo $row["name"];
        $array["lastname"] = $row["lastname"];
        $array["class"] = $row["class"];
        $array["dorm"] = $row["dormroom"];
        $array["id"] = $row["student_id"];
        $array["etutroom"] = $row["room"];
        $array["seat"] = $row["seat"];
        $leave_group = $row["leave_group"];
        $leave_id = $row["leave_id"];
        if(($leave_group == 1) && ($leave_id!= 4))
        {
          ////dep date i bo� tan�mla
            $array["dep_day"]  = "";
            $array["dep_bus"] = "";
            $array["arr_day"] = "";
            $array["arr_bus"] = "";
            
            switch($leave_id)
            {
                case 1: $array["weekend"]  = "Gebze Center Friday"; break;
                case 2: $array["weekend"] = "Gebze Center Saturday"; break;
                case 3: $array["weekend"] = "Gebze Center Sunday"; break;
            } 
        }
        else if(($leave_group==2)&&($leave_id!=4))
        {
            $array["dep_day"] = $row["dep_date"];
            $array["arr_day"] = $row["arr_date"];
            switch($row["arr_bus_id"])
            {
                case 1: $array["arr_bus"] = "Taxi/Cab"; break;
                case 2: $array["arr_bus"] = "Kadıköy"; break;
                case 3: $array["arr_bus"] = "Family"; break;
                case 4: $array["arr_bus"] = "Gebze-Terminal"; break;
                case 5: $array["arr_bus"] = "Gebze Station"; break;
                case 6: $array["arr_bus"] = "Gebze-Eskihisar"; break;
                case 7: $array["arr_bus"] = "Kocaeli"; break;
                case 8: $array["arr_bus"] = "Kartal-Underground"; break;
                case 9: $array["arr_bus"] = "Friend"; break;
                case 10: $array["arr_bus"] = "Dershane"; break;
            }
            switch($row["dep_bus_id"])
            {
                case 1: $array["dep_bus"] = "Taxi/Cab"; break;
                case 2: $array["dep_bus"] = "Kadıköy"; break;
                case 3: $array["dep_bus"] = "Family"; break;
                case 4: $array["dep_bus"] = "Gebze-Terminal"; break;
                case 5: $array["dep_bus"] = "Gebze Station"; break;
                case 6: $array["dep_bus"] = "Gebze-Eskihisar"; break;
                case 7: $array["dep_bus"] = "Kocaeli"; break;
                case 8: $array["dep_bus"] = "Kartal-Underground"; break;
                case 9: $array["dep_bus"] = "Friend"; break;
                case 10: $array["dep_bus"] = "Dershane"; break;
            }
            $array["weekend"] = "Home";
            //echo date("l", strtotime($row["dep_date"])) . "=dep=" . $row["dep_date"] . " ---" . date("l", strtotime($row["arr_date"])) . "=arr=" . $row["arr_date"] . $row["name"] . "-/-/-/-/-/-";
            
            if(date("l", strtotime($row["dep_date"]))=="Friday")
            {
                if($row["arr_date"]!=$row["dep_date"]){
                    $fri_dorm = 0;
                    $sat_etut = 0; 
                }  
                if(date("l", strtotime($row["arr_date"]))=="Sunday")
                {
                    $fri_dorm = 0;
                    $sat_etut = 0;
                    $sat_dorm = 0;
                }
            }
            if((date("l", date("l", strtotime($row["dep_date"])))=="Saturday")&&($row["arr_date"]!=$row["dep_date"]))
            {
                $sat_etut = 0;
                $sat_dorm = 0;   
            }
         }
        else
        {
            $array["weekend"] = "Kadıköy";
            $array["dep_day"] = $row["dep_date"];
            $array["dep_bus"] = $row["dep_bus_id"];
            $array["arr_day"] = $row["arr_date"];
            $array["arr_bus"] = $row["arr_bus_id"];
        }

/*
        $sql2 = "SELECT departure_time, return_time, event_date FROM checkinevents WHERE checkinjoins.user_id ='" . $row["user_id"] . "' AND checkinjoins.event_id = checkinevents.event_id AND checkinevents.event_date > " . $friday . " AND checkinevents.event_date < " . $sunday;
        $result2 = mysql_query($sql2);

        while($row2 = mysql_fetch_array($result2, MYSQL_BOTH))
        {
            if(($row2["event_date"] == $friday)&&($row2["return_time"]>"22:00"))
            {
                //2 mean person's going to be late
                $fri_dorm = 2;
            }
            if($row2["event_date"]== date("Y-m-d" ,strtotime("next saturday"))){
                if(($row2["departure_tiem"]<"11:00")&&($row2["return_time"]>"13:00"))
                {
                    $sat_etut = 0;
                }
                if(($row2["departure_tiem"]<"22:00")&&($row2["return_time"]>"22:00"))
                {
                    $sat_dorm = 2;
                }
            }
        }
*/
        
        $array["fri_dorm"] = $fri_dorm;
        $array["sat_dorm"] = $sat_dorm;
        $array["sat_etut"] = $sat_etut;
       ///// get day 
       array_push($json, $array);
				
        unset($array);
    }

    echo json_encode($json);
?>

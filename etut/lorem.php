<?php $hasReservedOnSaturday = getWeekendRoom($user_id, 0) != ''; ?>
<form method='post' name='reservations'>
  Please choose an option:<br>
  *Weekend reservations are not counted as computer usage hours.<br>
  <select name='weekendSeat' class="etutSelect">
    <option <?PHP if(date("N") == 6 && $hasReservedOnSaturday) echo("disabled=disabled"); ?> value=''> No laptop/computer room</option>
    <option <?PHP if ((getWeekendRoom($user_id, 0))=='lap'){ echo "selected='yes'"; } if(date("N") == 6 || date('G') >= 20) echo("disabled=disabled");?> value='sat_lap'>Laptop on Saturday</option>
    <option <?PHP if ((getWeekendRoom($user_id, 0))=='comp'){ echo "selected='yes'"; }  if(date("N") == 6 || date('G') >= 20) echo("disabled=disabled");?> value='sat_comp'>Computer Room on Saturday</option>
    <option <?PHP if ((getWeekendRoom($user_id, 1))=='coursera'){ echo "selected='yes'"; }  if(date("N") == 6 || date('G') >= 20) echo("disabled=disabled");?> value='sat_coursera'> iMac Room on Saturday </option>
    <option <?PHP if ((getWeekendRoom($user_id, 1))=='lap'){ echo "selected='yes'"; }  if(date("N") == 6 && $hasReservedOnSaturday) echo("disabled=disabled");?> value='sun_lap'>Laptop on Sunday</option>
    <option <?PHP if ((getWeekendRoom($user_id, 1))=='comp'){ echo "selected='yes'"; } if(date("N") == 6 && $hasReservedOnSaturday) echo("disabled=disabled");?> value='sun_comp'>Computer Room on Sunday</option>
    <option <?PHP if ((getWeekendRoom($user_id, 1))=='coursera'){ echo "selected='yes'"; }  if(date("N") == 6 && $hasReservedOnSaturday) echo("disabled=disabled");?> value='sun_coursera'> iMac Room on Sunday </option>
  </select>
  <input type='submit' name='saveFriday' value='Save' class="etutButton">
</form>
<!-- /friday.php -->

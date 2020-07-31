<form method='post' name='reservations'>
  Please choose an option:<br>
  *Weekend reservations are not counted as computer usage hours.<br>
  <select name='weekendSeat' class="etutSelect">
    <option value=''>No laptop/computer room</option>
    <option <?PHP if ((getWeekendRoom($user_id, 0))=='lap'){ echo "selected='yes'"; } ?> value='sat_lap'>Laptop on Saturday</option>
    <option <?PHP if ((getWeekendRoom($user_id, 0))=='comp'){ echo "selected='yes'"; } ?> value='sat_comp'>Computer Room on Saturday</option>
    <option <?PHP if ((getWeekendRoom($user_id, 1))=='lap'){ echo "selected='yes'"; } ?> value='sun_lap'>Laptop on Sunday</option>
    <option <?PHP if ((getWeekendRoom($user_id, 1))=='comp'){ echo "selected='yes'"; } ?> value='sun_comp'>Computer Room on Sunday</option>
  </select>
  <input type='submit' name='saveFriday' value='Save' class="etutButton">
</form>



<form method='post' name='reservations'>
  Please choose your seat for today:<br>
  <select name='seat' class="etutSelect">
    <option value=''>Default</option>
    <option <?PHP if ((getWeekdayRoom($user_id, $today))=='lap'){ echo "selected='yes'"; } checkAllowance ($user_id); ?> value='lap'>Laptop</option>
    <option <?PHP if ((getWeekdayRoom($user_id, $today))=='comp'){ echo "selected='yes'"; } checkAllowance ($user_id); ?> value='comp'>Computer Room</option>
    <?PHP
      if (date("N")==4){
        echo"<option ";
        if ((getWeekdayRoom($user_id, $today))=='coursera'){
          echo "selected='yes'";
        }
        if (courseraCount(date("Y-m-d"))>=8){
          echo "disabled='disabled'";
        }
        echo "value='coursera'>Coursera</option>";
      }
    ?>
  </select>
  <input type='submit' name='saveWeekday' value='Save' class="etutButton">
</form>

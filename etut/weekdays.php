<form method='post' name='reservations'>

  Please choose your seat for today<br><br>

  <select name='seat' class="etutSelect">
    <option value=''>Default</option>
    <option <?PHP if ((getWeekdayRoom($user_id, $today, "1"))=='lap'){ echo "selected='yes'"; } checkAllowance($user_id); ?> value='lap'>Laptop</option>
    <option <?PHP if ((getWeekdayRoom($user_id, $today, "1"))=='comp'){ echo "selected='yes'"; } checkAllowance($user_id); ?> value='comp'>Computer Room</option>
    
	<?PHP
	$temp_conn = mysqli_connect("94.73.150.252", "incnetRoot", "6eI40i59n22M7f9LIqH9", "incnet");
		$res = mysqli_query($temp_conn, "SELECT * FROM etutVars WHERE name LIKE \"class%enabled\"");
		
		$enableds = array();
		
		while($row = mysqli_fetch_assoc($res)){
			$enableds[$row['name']] = $row['value'];
		}
		
		unset($temp_conn);
	
	$iMacWeekdayEnabled = $GLOBALS['iMacWeekdayEnabled'];
	$classOneWeekdayEnabled = $enableds['class1_enabled'] == "yes";
	$classTwoWeekdayEnabled = $enableds['class2_enabled'] == "yes";
      if ((/*date("N")==2 || */getWeekdayRoom($user_id, $today, "1") == "coursera" || true) && $iMacWeekdayEnabled){
        echo"<option ";
        if ((getWeekdayRoom($user_id, $today, "1"))=='coursera'){
          echo "selected='yes'";
        }
        if (!courseraCount($today, "1")){
          echo "disabled='disabled'";
        }
        echo "value='coursera'>iMac Room</option>";
      }?>
	  <?php
      if ($classOneWeekdayEnabled){
        echo"<option ";
        if ((getWeekdayRoom($user_id, $today, "1"))=='classroom1'){
          echo "selected='yes'";
        }
		checkAllowance($user_id);
        echo "value='classroom1'>Clasroom 1</option>";
      }
	  ?>
	  <?php
      if ($classTwoWeekdayEnabled){
        echo"<option ";
        if ((getWeekdayRoom($user_id, $today, "1"))=='classroom2'){
          echo "selected='yes'";
        }
		checkAllowance($user_id);
        echo "value='classroom2'>Clasroom 2	</option>";
      }
    ?>
  </select>
  <input type='submit' name='saveWeekday' value='Save' class="etutButton">
  <?php if(isset($msg)) echo $msg; ?>
</form>
<?php //if($_SESSION['user_id'] == 1282) include("studyGroup.php");?>
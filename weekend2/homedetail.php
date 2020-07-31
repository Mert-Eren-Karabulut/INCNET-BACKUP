<?php
	/*
	
		Oh, this turned into a mess way faster that I expected... I sincerely feel bad for anyone who will have to add features to/troubleshoot this after I graduate.
		--Efeyzi '19
		
		Well, fuck. I turned out to be the person to add features to this...
		--Efeyzi '19
		
	*/
	
	
	
	
	
	$thisFriday = date("Y-m-d", strtotime("friday this week"));
	$thisSaturday = date("Y-m-d", strtotime("saturday this week"));
	$thisSunday = date("Y-m-d", strtotime("sunday this week"));
	$nextMonday = date("Y-m-d", strtotime("monday next week"));
	$daysDate = explode(",","$thisFriday,$thisSaturday,$thisSunday,$nextMonday");
	$daysHuman = explode(",","Friday,Saturday,Sunday,Monday");
	
	$sql = "SELECT * FROM weekend2busses";
	$res = mysql_query($sql);
	
	while($row = mysql_fetch_assoc($res)){
		$buses[] = array($row['bus_id'], $row['bus_name'], $row['direction']);
	}	
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	var normalBusses = [
		"Kadıköy",
		"Kocaeli",
		"Family",
		"Taxi"
	]
	
	function checkBusses(direction){
		if(direction == "arrival"){
			if($('#arrDate')[0].value != "<?php /*echo $thisSunday*/ ?>2018-04-23"){
				$('select[name=arrBus] option:contains("Kadıköy")').hide();
				$('select[name=arrBus] option:contains("Kocaeli")').hide();
				$('select[name=arrBus] option:contains("Dersane")').hide();
			}else{
				$('select[name=arrBus] option:contains("Kadıköy")').show();
				$('select[name=arrBus] option:contains("Kocaeli")').show();
				$('select[name=arrBus] option:contains("Dersane")').show();
			}
			
			if($('#arrDate')[0].value != "<?php echo $thisFriday ?>"){
				$('select[name=arrBus] option:contains("Yelken")').hide();
			}else{
				$('select[name=arrBus] option:contains("Yelken")').show();
			}
		}else if(direction == "departure"){
			if($('#depDate')[0].value != "<?php echo $thisFriday ?>"){
				$('select[name=depBus] option:contains("Kadıköy")').hide();
				$('select[name=depBus] option:contains("Kocaeli")').hide();
				$('select[name=depBus] option:contains("Dersane")').hide();
				$('select[name=depBus] option:contains("Yelken")').hide();
			}else{
				$('select[name=depBus] option:contains("Kadıköy")').show();
				$('select[name=depBus] option:contains("Kocaeli")').show();
				$('select[name=depBus] option:contains("Dersane")').show();
				$('select[name=depBus] option:contains("Yelken")').show();
			}
			if($('#depDate')[0].value != "<?php echo $thisSaturday ?>"){
				$('select[name=depBus] option:contains("Kurs")').hide();
				$('select[name=depBus] option:contains("Terminal")').show();
			}else{
				$('select[name=depBus] option:contains("Kurs")').show();
				$('select[name=depBus] option:contains("Terminal")').hide();
			}
		}else{
			confirm("Wait wait wait wait hold on a second. How the fu*cough*k did you manage to do that?! That shouldn't ever happen! Contact me (efeyzi '19, or any INÇNET dev if I have graduated [but do also message me: 0fivethreeseven8504018]) and I'll give you a prize or something (and also fix the bug you've found.) (The confirm box is only so that you read this btw, it doesn't actually matter if you click ok or cancel)");
			if(confirm("Be honest. Have you been trying to break the site?")) alert("Welcome to the INÇNET Family! (not really) Contact me to notify me that you've found INÇNET Foobar (totally not ripped off of Google)");
			else alert("That's even odder... Sorry for the inconvinience. As I said, contact me and I'll try to fix your issue");
		}
	}
	
	$(function(){$('select[name=arrDate] option:contains("Sunday")').attr('selected', true);checkBusses("arrival"); checkBusses("departure");});
</script>


<h3>Home Departure Details</h3>

<form method=POST action=#>
	<input type=hidden name=homedetail value=yes />
	<table>
		<tr>
			<td>
				<label for=depDate>Departure Date</label>
			</td>
			<td>
				<select id=depDate name=depDate onchange="checkBusses('departure');">
				<?php
					for($i = 0; $i < count($daysDate); $i++){
						if($daysHuman[$i] != "Monday Morning" || true /*23 April*/) echo("\t\t\t\t\t<option value=$daysDate[$i]>$daysHuman[$i]</option>\n");
					}
?>				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label for=arrDate>Arrival Date</label>
			</td>
			<td>
				<select id=arrDate name=arrDate onchange="checkBusses('arrival');">
				<?php
					for($i = 0; $i < count($daysDate); $i++){
						echo("\t\t\t\t\t<option value=$daysDate[$i]>$daysHuman[$i]</option>\n");
					}
?>				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label for=depBus>Departure Bus</label>
			</td>
			<td>
				<select name=depBus id=depBus onchange="if(normalBusses.indexOf($('#depBus').value) == -1) $('#warning').show();">
				<?php
					foreach($buses as $bus){
						if($bus[2] != 1) echo("\t\t\t\t\t<option value=$bus[0]>$bus[1]</option>\n");
					}
?>				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label for=arrBus>Arrival Bus</label>
			</td>
			<td>
				<select name=arrBus id=arrBus onchange="if(normalBusses.indexOf($('#depBus').value) == -1) $('#warning').show();">
				<?php
					foreach($buses as $bus){
						if($bus[2] != 0) echo("\t\t\t\t\t<option value=$bus[0]>$bus[1]</option>\n");
					}
?>				</select>
			</td>
		</tr>
	</table>
	<span id=warning style="color: grey; margin: 10px; display: none;"><i>Warning: Do not select a bus you are normally not allowed to use. You will not be let on a bus you normally are not allowed to use, unless you get permission from the administration first.</i></span><br/>
	<input type=Submit value=Save name=saveDeparture>
</form>

<form method=POST style="margin-top: 15px;" action=#> <input type=Submit value=Back> </form>





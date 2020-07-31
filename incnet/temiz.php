<?php
$dbname="incnet";
$dbuser="incnetRoot";
$dbpass="6eI40i59n22M7f9LIqH9";
mysql_connect('94.73.150.252',$dbuser, $dbpass);
mysql_select_db($dbname) or die('unable to select db');
mysql_set_charset('utf8');
$sql = "SELECT * FROM checkin2bans";
							$query = mysql_query($sql);
							while($row = mysql_fetch_row($query)){
								echo "
									<tr>
										<td>$row[1]</td> 
									</tr>
								";
							}
?>
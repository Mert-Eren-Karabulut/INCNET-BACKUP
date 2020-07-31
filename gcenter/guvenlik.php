<? 
	session_start();
	if($_SESSION['checked']!=true)
	{
		echo "<meta http-equiv=\"refresh\" content=\"0; URL='http://incnet.tevitol.org/gcenter/index.php'\" />";
	}
	$today = date("m-d-y");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gebze Center</title>
	<meta charset="UTF-8">
</head>
<body>

<form method="post">
<input type="text" name="count" value="1" id="count">
<input type="text" name="name" placeholder="Çıkanın Adı">
<input type><br>
<input type="submit" value="Çıkış Yaptı" name="submit">
</form>

<table>
	<?
		$sql = "SELECT * FROM gcenter WHERE date=$today ORDER BY name";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
			if($row['returned']==1)
			{
				$checked = "checked";
			}else
			{
				$checked = "";
			}
			echo "<tr>
					<td>
						" . $row['name'] . "
					</td>
					<td>
						" . $row['time'] . "
					</td>
					<td>
						<form method=\"post\">
							<input type=\"checkbox\" name=\"returned\" value=\"" . $row['name'] . "\"  " . $checked . ">
						</form>
					</td>
				  </tr>";
		} 
	?>
</table>

</body>
</html>
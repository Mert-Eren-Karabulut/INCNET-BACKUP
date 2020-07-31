<?PHP
	error_reporting(0);
	
	
	//connect to mysql server
	include ("../db_connect.php");
	include ("functions.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
  
	session_start();
	if (!(isset($_SESSION['user_id']))){
		$newPage = "<meta http-equiv='refresh' content='0; url=../incnet/login.php'>";
	}
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$lang = $_SESSION['lang'];
	
	if (isset($_POST['logoff'])){
		session_destroy();
		$newPage = "<meta http-equiv='refresh' content='0; url=../incnet/index.php'>";
	}
	
	mysql_select_db("incnet");
	
	if (checkAdmin($user_id)==0){
		$newPage = "<meta http-equiv='refresh' content='0; url=index.php'>";
	}

	if (isset($_POST['period_submit'])){
		$startDate = $_POST['startDate'];
		$endDate = $_POST['endDate'];
		
		mysql_query("UPDATE etutvars SET value='$startDate' WHERE name='startDate'");
		mysql_query("UPDATE etutvars SET value='$endDate' WHERE name='endDate'");
	}
	
		
	$sql = mysql_query("SELECT value FROM etutvars WHERE var_id=1");
	while ($row=mysql_fetch_array($sql)){
		$startDate = $row[0];
	}
	
	if(isset($_POST['toggle1'])){
		$lol = "UPDATE etutvars SET `value` = \"".(($_POST['toggle1'] == "true") ? "yes" : "no") . "\" WHERE name LIKE \"class1_enabled\"";
		mysql_query($lol) or die(mysql_error()."\n<br/>$lol");
	}
	
	if(isset($_POST['toggle2'])){
		$lol = "UPDATE etutvars SET `value` = \"".(($_POST['toggle2'] == "true") ? "yes" : "no") . "\" WHERE name LIKE \"class2_enabled\"";
		mysql_query($lol) or die(mysql_error()."\n<br/>$lol");
	}
	
	if(isset($_POST['quota1_go'])){
		$lol = "UPDATE etutvars SET value=\"".mysql_real_escape_string($_POST['quota1'])."\" WHERE name LIKE \"class1_quota\"";
		mysql_query($lol);
	}
	
	if(isset($_POST['quota2_go'])){
		mysql_query("UPDATE etutvars SET value=\"".mysql_real_escape_string($_POST['quota2'])."\" WHERE name LIKE \"class2_quota\"");
	}
	
	$sql = mysql_query("SELECT value FROM etutvars WHERE var_id=2");
	while ($row=mysql_fetch_array($sql)){
		$endDate = $row[0];
	}
	
	$sql = mysql_query("SELECT value FROM etutvars WHERE name LIKE \"class1_enabled\"");
	while ($row=mysql_fetch_array($sql)){
		$enabled1 = $row[0] == "yes";
	}
	
	$sql = mysql_query("SELECT value FROM etutvars WHERE name LIKE \"class1_quota\"");
	while ($row=mysql_fetch_array($sql)){
		$quota1 = $row[0];
	}
	
	$sql = mysql_query("SELECT value FROM etutvars WHERE name LIKE \"class2_enabled\"");
	while ($row=mysql_fetch_array($sql)){
		$enabled2 = $row[0] == "yes";
	}
	
	$sql = mysql_query("SELECT value FROM etutvars WHERE name LIKE \"class2_quota\"");
	while ($row=mysql_fetch_array($sql)){
		$quota2 = $row[0];
	}
	
?>

<!doctype html>
<HTML>
	<head>
		<?PHP
			if ($newPage!=''){
				echo $newPage;
			}
		?>
		<link rel="shortcut icon" href="../../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	</head>
	
	<body>
		<div class="header">
			<?PHP echo $fullname; ?>
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='index.php'><img style='position: relative; top:20px;' src='../../incnet/incnet.png' width='140px'></a>
				</td>
				<div style='position:absolute; bottom:30px; z-index:2;' >
					<form name="logoff" method="POST">
						<input type ="submit" name="logoff" value="Log Off">
					</form>
				</div>

				<td valign='top'>
				<br><br>
				<div class='titleDiv'><br>Page Variables<br></div><br>
				These values do not affect when the period is reset. It should still be reset manually.<br><br>
				<form method='POST'>
					Period starts:<br>
					<input onClick='this.select();' type='text' name='startDate' value='<? echo $startDate; ?>' autofocus><br><br>
					Period ends:<br>
					<input onClick='this.select();' type='text' name='endDate' value='<? echo $endDate; ?>' ><br>
					<input type='submit' name='period_submit' value='Save'>
				</form>
				
				<?php
					
				?>
				
				<form method=POST>
					<br/><div class=titleDiv>Extra Rooms</div><br/><br/>
					<h2 class=titleDiv style="font-size: 10pt;">Classroom 1 (<?php echo($enabled1 ? "Enabled" : "Disabled"); ?>)</h2><br/>
					<button type=submit name=toggle1 value="<?php echo(!$enabled1 ? "true" : "false"); ?>"> <?php echo($enabled1 ? "Disable" : "Enable"); ?></button><br/><br/>
					<label for=quota1>Quota</label>&nbsp;&nbsp;<input type=number name=quota1 value=<?php echo($quota1); ?>><input type=submit name=quota1_go value="Save"/>
					<h2 class=titleDiv style="font-size: 10pt;">Classroom 2 (<?php echo($enabled2 ? "Enabled" : "Disabled"); ?>)</h2><br/>
					<button type=submit name=toggle2 value="<?php echo(!$enabled2 ? "true" : "false"); ?>"> <?php echo($enabled2 ? "Disable" : "Enable"); ?></button><br/><br/>
					<label for=quota2>Quota</label>&nbsp;&nbsp;<input type=number name=quota2 value=<?php echo($quota2); ?>><input type=submit name=quota2_go value="Save"/>
				</form>
				</td>

			</tr>
		</table>
		
		<div class="copyright">&nbsp © INCNET</div>
	</body>
</HTML>









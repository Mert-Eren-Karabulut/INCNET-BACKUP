<?PHP
	error_reporting(0);
	
	function insertBr ($text){
		$text = explode ("
", $text);
		$text = implode ("<br>" , $text);
		return trim($text);
	}
	
	function safeText ($text){
		$text = explode ("-", $text);
		$text = implode ("&#45;" , $text);
		return $text;
	}
	
	//connect to mysql server
	include ("../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
  mysql_select_db("incnet");
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:login.php");
	}
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$lang = $_SESSION['lang'];
	
	//permissions
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:../../incnet/login.php");
	}
	$user_id = $_SESSION['user_id'];
	
	$sql="SELECT class FROM coreusers WHERE user_id = $user_id";
	$sql = mysql_query($sql);
	while ($row = mysql_fetch_array($sql)){
		$userClass = $row[0];
	}
	
	if (isset($_POST['delNow'])){
		$delUpId = $_POST['delUp'];
		$sql = ("DELETE from writeups WHERE writeup_id='$delUpId'");
		mysql_query($sql);
	}
	
	$query = mysql_query("SELECT user_id, name, lastname, class FROM incnet.coreUsers WHERE class LIKE '12IB' OR class LIKE '12MEB' ");
	//echo $query;
	while($row = mysql_fetch_array($query)){
		$user = $row[0];
		$name = $row[1];
		$lastname = $row[2];
		$class = $row[3];
		$studentRow = $studentRow . "
								<option value='$user'>$name $lastname</option>";
	}
	
	if (isset($_POST['send'])){
		$text = $_POST['writeUpText'];
		$writeTo = $_POST['writeTo'];
		if (($writeTo=='')||($text=='')){
			$msg = "Please complete all fields";
		}else{
			$text = insertBr($text);
			$sql="INSERT INTO writeups VALUES(NULL, $user_id, $writeTo, '$text')";
			mysql_query($sql);
			$msg = "Message posted!";
		}
	}

?>

<!doctype html>
<HTML>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../checkin2/style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<link rel="stylesheet" href="chosen.css">
	</head>
	
	<body>
		<div class='header'>
			<?PHP echo $fullname;?>
			&nbsp&nbsp
		</div>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<br><a href='../incnet'><image src='../incnet/incnet14.png' width='135px'></a><br>
					<br>

				<td valign='top' style='padding:7px; padding-top:35px;'>
						<div style='color: #c1272d; font-size:16pt'>Write for people:</div>
						<form method='POST'><br>
							<select name='writeTo' data-placeholder="Select student..." class="chosen-select">
								<option value=''>Select Student</option>
								<? echo $studentRow; ?>
							</select><br>
							<textarea placeholder='Enter text here!' name='writeUpText' rows='10' cols='55' autofocus><? if ($msg != "Message posted!"){ echo $text; } ?></textarea><br>
							<input type='submit' name='send' value='Save'>
							<br><span style='color:#c1272d'><? echo $msg; ?></span>
						</form>
						<br><br>
						<?
							if ($userClass=="11IB" || $userClass=="11MEB"){
								echo "<div style='color: #c1272d; font-size:16pt'>Write-ups for you</div>";
								$sql = "SELECT writeups.written_by, writeups.text, coreusers.name, coreusers.lastname FROM writeups, coreusers WHERE writeups.written_by=coreusers.user_id AND writeups.written_for = $user_id ORDER BY writeup_id DESC";
								//echo $sql;
								$sql = mysql_query($sql);
								while ($row=mysql_fetch_array($sql)){
									$by = $row[2] . " " . $row[3];
									$text = $row[1];
									echo "<div style='width:450px; border:1px solid black; padding:5px;'><span style='color:#c1272d; font-weight:bold'>$by</span> wrote:<br>$text</div><br>";
								}
							}
						?>
					<br><br>
					<div style='color: #c1272d; font-size:16pt'>Write-ups you wrote</div>
					<?
						$sql = "SELECT writeups.written_for, writeups.text, coreusers.name, coreusers.lastname, writeups.writeup_id FROM writeups, coreusers WHERE writeups.written_by=$user_id AND writeups.written_for = coreusers.user_id ORDER BY writeup_id DESC";
						//echo $sql;
						$sql = mysql_query($sql);
						while ($row=mysql_fetch_array($sql)){
							$by = $row[2] . " " . $row[3];
							$text = $row[1];
							$delId = $row[4];
							echo "<div style='width:450px; border:1px solid black; padding:5px;'>You wrote for: <span style='color:#c1272d; font-weight:bold'>$by</span><br>$text<br><form method='POST'><input type='hidden' name='delUp' value='$delId'><input type='submit' name='delNow' value='Delete!'></form></div><br>";
						}

					?>
					<br><br><br>
				</td>
			</tr>
		</table>
		
		<div class="copyright">&nbsp © INÇNET</div>
		<script src="jquery_min.js" type="text/javascript"></script>
		  <script src="chosen.jquery.js" type="text/javascript"></script>
		  <script type="text/javascript">
		    var config = {
		      '.chosen-select'           : {},
		      '.chosen-select-no-single' : {disable_search_threshold:10},
		      '.chosen-select-no-results': {no_results_text:'No records found!'},
		      '.chosen-select-width'     : {width:"95%"}
		    }
		    for (var selector in config) {
		      $(selector).chosen(config[selector]);
		    }
		  </script>
	</body>
</HTML>





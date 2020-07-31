<?php
	session_start();
	
	if(!isset($_SESSION['user_id'])){
		header("Location: /index.php");
	}
	$link = mysql_connect('94.73.150.252', 'incnetRoot', '6eI40i59n22M7f9LIqH9');
	if (!$link) {
		die('Bağlanamadı: ' . mysql_error());
	}

	$db_selected = mysql_select_db('incnet', $link);
	if (!$db_selected) {
		die ('Can\'t use incnet : ' . mysql_error());
	}
	
	
	$id = $_SESSION['user_id'];
	$permission_sql = "SELECT permit_id FROM corepermits WHERE user_id = '$id' AND page_id = '101'";
	$res = mysql_query($permission_sql);
	if($res = mysql_fetch_assoc($res)){
		$permitted = true;
	}
	
	if(!$permitted){
		die("What are you doing here? This page is strcitly for Admins. Click <a href=/index.php>here</a>. (Your user id is $id .)");
	}

		echo("This will irreversibly advance all students a year. Are you sure?<br/>\n");
		if(isset($_POST['yesiamabsolutelycertain'])){
			$sql = "UPDATE coreusers SET class='Grad' WHERE (class='12IB' OR class='12MEB')";
			mysql_query($sql);
			$sql = "UPDATE coreusers SET class='12MEB' WHERE class='11MEB'";
			mysql_query($sql);
			$sql = "UPDATE coreusers SET class='12IB' WHERE class='11IB'";
			mysql_query($sql);
			$sql = "UPDATE coreusers SET class='11' WHERE class='10'";
			mysql_query($sql);
			$sql = "UPDATE coreusers SET class='10' WHERE class='9'";
			mysql_query($sql);
			$sql = "UPDATE coreusers SET class='9' WHERE class='Prep'";
			mysql_query($sql);
			echo("Advanced age. Manually update MEB/IB for 11th graders. Manually add Preps/9th graders (whichever is the first year of education nowadays.)");
			die();
		}else if(isset($_POST['yesiamcertain'])){
			echo("<form method=POST><input name=yesiamabsolutelycertain type=submit value=\"Yes I Am Absolutely Certain (Last Chance)\"><button type=button onClick=\"window.location.href='/'\">No</button></form>");
			die();
		}else if(isset($_POST['advance_age'])){
			echo("<form method=POST><input id=yes type=hidden name=yesiamcertain value=yes><input type=submit value=\"Yes I Am Certain\"><button type=button onClick=\"window.location.href='/'\">No</button></form>");
			die();
		}else{
			echo("<form method=POST><input id=yes type=hidden name=advance_age value=yes><input type=submit value=\"Advance Age\"><button type=button onClick=\"window.location.href='/'\">No</button></form>");
			die();
		}
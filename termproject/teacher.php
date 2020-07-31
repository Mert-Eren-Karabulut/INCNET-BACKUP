<table>
<tr>
	<th>Ögretmen Adý</th><th>Öðrenci Adý</th> <th>Soyadý</th> <th>Ders</th>
</tr><?php
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:http://incnet.tevitol.org/incnet/index.php?continue=termproject/teacher.php");
	}	$user_id = $_SESSION['user_id'];	session_start();	if (!(isset($_SESSION['user_id']))){		header("location:http://incnet.tevitol.org/incnet/index.php?continue=termproject");	}	$user_id = $_SESSION['user_id'];	$incnetserver = "94.73.150.252";	$incnetuser = "incnetRoot";	$incnetpass = "6eI40i59n22M7f9LIqH9";	$incnetdb = "incnet";    $incnet = new PDO("mysql:host=$incnetserver;dbname=$incnetdb;", $incnetuser, $incnetpass);    // set the PDO error mode to exception    $incnet->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    $incnet -> exec("SET NAMES utf8;");		$areyouateachersql = $incnet -> prepare("SELECT type FROM coreusers WHERE user_id=:user");	$areyouateachersql -> execute(array(':user' => $user_id));		while ($row = $areyouateachersql -> fetch()) {    	if($row['type'] != "teacher" && !$permitted){			header("Location: ./teacher.php");		}    }		////////////
	$servername = "94.73.170.253";
	$username = "Tproject";
	$password = "5ge353g5419L8fIEPv0E";
	$dbname = "tproject";
	$link = mysqli_connect($servername, $username, $password, $dbname);
	$res = mysqli_query($link, "SELECT * FROM tp");
	$tps = array();
	while($res = mysqli_fetch_assoc($res)){
		$tps[] = array("teacher"=> $row['teacher'], "lesson" => $row['class_id'], "student_id" => $row['student_id']);
	}
	$incnetsql = $incnet->prepare("SELECT * FROM coreusers WHERE user_id=:user");
	foreach($tps as $tp){
		$incnetsql -> execute(array(':user' => $tp['student_id']));
		while ($row = $incnetsql -> fetch()) {
			echo("<tr><td>$tp[teacher]</td><td>$row[name]</td><td>$row[lastname]</td><td>$tp[class_id]</td></tr>");
		}
	}
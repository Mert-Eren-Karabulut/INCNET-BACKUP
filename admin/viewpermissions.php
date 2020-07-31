<?php
	
	function check_permission(){
		$servername = "94.73.150.252";
		$username = "incnetRoot";
		$password = "6eI40i59n22M7f9LIqH9";
		$dbname = "incnet";
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$result = $conn->query("SELECT * FROM corepermits WHERE user_id=".$_SESSION[0]." AND page_id=103");
		if(!($result->num_rows > 0))
			return false;
		else return true;
	}
?>
<html>
<head>
	<link rel="shortcut icon" href="/img/favicon.ico" >
	<meta charset=UTF-8>
	<title>İnçnet | Permission Viewer</title>
</head>
<body>
<?php
	echo(isset($_SESSION[0]));	
	$servername = "94.73.150.252";
	$username = "incnetRoot";
	$password = "6eI40i59n22M7f9LIqH9";
	$dbname = "incnet";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
if(!isset($_POST['go'])){
		echo("<form action=viewpermissions.php method=POST><h1>Permission Viewer</h1><label for=pages>Page ID's to be looked for (seperated by spaces)&nbsp&nbsp</label><input type=text id=pages name=pages value=\"201 230 232\"><br/><input type=Submit id=go name=go></form>");
		$sql = "SELECT * FROM corepage_ids";
		$result = $conn->query($sql);
		echo("<table><tr><th>Page ID</th><th>Meaning</th></tr>");
		while($row = $result->fetch_assoc()){
			echo("<tr><td>".$row["page_id"]."</td><td>".$row["meaning"]."</td></tr>\n");
		}
		echo("</table>\n<br/><br/>\n");
}else{
	$pages = explode(" ", $_POST['pages']);
	if(!isset($_POST['pages']) || $_POST['pages'] == "" || $_POST['pages'] == " ")
		$pages = explode(" ", "201 230 232");
	$pages_text = "";
	foreach($pages as $page)
		$pages_text = $pages_text." ".$page." ";
	$sql = "SELECT * FROM corepermits WHERE FALSE";
	foreach($pages as $page)
		$sql = $sql." OR page_id=".$page;
	$sql = $sql." ORDER BY user_id ASC";
	$result = $conn->query($sql);

	echo "<h1>Looking for users with access to page";
	if(count($pages) > 1)
		echo "s ";
	else
		echo " ";
	echo $pages_text;

	if ($result->num_rows > 0) {
		echo "<h2>".$result->num_rows." records found</h2><table><tr><th>Permit ID</th><th>Page ID</th><th>User ID</th><th>Username</th></tr>";
		while($row = $result->fetch_assoc()) {
			$permit_id = $row["permit_id"];
			$page_id = $row["page_id"];
			$user_id = $row["user_id"];
			$user_name_result = $conn->query("SELECT * FROM coreusers WHERE user_id=".$user_id);
			$user_name_row = $user_name_result->fetch_assoc();
			$user_name = $user_name_row["username"];
			if($user_name == " " || $user_name == "")
				$user_name = $user_name_row["name"]." ".$user_name_row["lastname"];
			if($user_name_result->num_rows == 0)
				$user_name = "NOT REGISTERED";
			echo "<tr><td>" . $permit_id. "</td><td>" . $page_id. "</td><td>" . $user_id. "</td><td>" . $user_name . "</td></tr>\n";
		}
		echo "</table>";
	} else {
		echo "0 records found";
	}
	$conn->close();
	echo("<h3><a href=viewpermissions.php>Back to form</a></h3>");
}
?>
<h3><a href=/>Back to home</a></h3>
</body>
</html>
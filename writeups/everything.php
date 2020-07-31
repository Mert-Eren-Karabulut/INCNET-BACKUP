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

  function getUser($user_id){
    $query = mysql_query("SELECT name, lastname, class FROM incnet.coreUsers WHERE user_id='$user_id'");
    while($row = mysql_fetch_array($query)){
      $fullName = $row[0] . " " . $row[1];
      return $fullName;
    }
    
  }
	
	$query = mysql_query("SELECT written_for, written_by, text FROM incnet.writeups order by written_for");
	while($row = mysql_fetch_array($query)){
		$tableRow = $tableRow . "<tr><td>" . getUser($row[0]) . "</td><td>" . getUser($row[1]) . "</td><td>" . $row[2] . "</td></tr>";
	}                                                 
	


?>

<!doctype html>
<HTML>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../checkin2/style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	</head>
	
	<body>
    <table border = 1>
      <tr>
        <td>For</td>
        <td>By</td>
        <td>text</td>
      </tr>
      <? echo $tableRow; ?>
    </table>
  </body>
</HTML>





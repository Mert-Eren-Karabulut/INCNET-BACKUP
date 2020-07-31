<?
	function techerToHuman($id){
		if($row = mysql_fetch_assoc(mysql_query("SELECT teacher_name FROM teachers WHERE teacher=".$id)))
			return $row['teacher_name'];
		else
			return "";
	}
	
	function strtolowerturkish($str){
		$str = strtolower($str);
		$str = str_replace("Ç", "ç", $str); 
		$str = str_replace("Ğ", "ğ", $str); 
		$str = str_replace("İ", "i", $str); 
		$str = str_replace("Ö", "ö", $str); 
		$str = str_replace("Ş", "ş", $str); 
		$str = str_replace("Ü", "ü", $str);
		
		return $str;
	}
	
	function classtohuman($str){
		if($str == "0a") $str = "Hazırlık A";
		else if($str == "0b") $str = "Hazırlık B";
		else if($str == "0c") $str = "Hazırlık C";
		else if($str == "0d") $str = "Hazırlık D";
		else $str = strtoupper($str);
		return $str;
	}
	
?>

<html>
	<head>
		<meta charset="UTF8">
		<style>
			td, tr, th{
				border: 1pt solid black;
			}
		</style>
	</head>
	<body>
		<table>
			<tr><th>School No</th><th>Name</th><th>Class</th><th>Project 1</th><th>Teacher 1</th><th>Project 2</th><th>Teacher 2</th><th>Project 3</th><th>Project 4</th><th>Project 5</th></tr>
			<?
				mysql_connect("94.73.170.253", "Tproject", "5ge353g5419L8fIEPv0E");
				mysql_select_db("tproject");
				mysql_query("SET NAMES utf8");
				$result = mysql_query("SELECT * FROM  `tp` ORDER BY  `tp`.`name` ASC, id ASC ");
				
				$allStudents = array();
				
				while($row = mysql_fetch_assoc($result)){
					$allStudents[$row['user_id']][] = $row;
				}
				
				foreach($allStudents as $student){
					$i = 0;
					echo "<tr><td>".$student[0]['stud_no']."</td><td>".$student[0]['name']."</td><td>".classtohuman($student[0]['class'])."</td>";
					foreach($student as $row){
						$i++;
						if($row['real'] == 1) echo "<td><b>".($row['lesson'])."</b></td><td><b>".ucwords(strtolowerturkish(techerToHuman($row['teacher'])))."</b></td>";
						else if($row['no'] == 2) echo "<td>".($row['lesson'])."</td><td></td>";
						else echo "<td>".($row['lesson'])."</td>";
					}
					for($i; $i < 2; $i++){
						echo "<td></td><td></td>";
					}
					echo "</tr>";
				}
			?>
		</table>
	</body>
</html>
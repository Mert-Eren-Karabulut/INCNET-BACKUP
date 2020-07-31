<?PHP
	error_reporting(0);
	
	//connect to mysql server
	include ("../../db_connect.php");
	if (!$con){
	  die('Could not connect: ' . mysql_error());
  }
  
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:login.php");
	}
	$fullname = $_SESSION['fullname'];
	$user_id = $_SESSION['user_id'];
	$lang = $_SESSION['lang'];
	
	//permissions  
	$page_id = "902";
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:../../incnet/login.php");
	}
	$user_id = $_SESSION['user_id'];
	
	$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id' AND page_id='$page_id'");
	while($permit_row = mysql_fetch_array($permit_query)){
		$allowance = "1";
	}
	if ($allowance != "1"){
		header ("location:../../incnet/login.php");
	}


		
	if (isset($_POST['search'])){
		$searchKey = $_POST['searchKey'];
		$query = mysql_query("SELECT registerId, name, lastname, class FROM incnet.profilesMain WHERE lastname LIKE '%$searchKey%'");
		//echo $query;
		while($row = mysql_fetch_array($query)){
			$registerId = $row['registerId'];
			$name = $row['name'];
			$lastname = $row['lastname'];
			$class = $row['class'];
			$studentRow[] = "<form method='get' action='emergencySearch.php'><input type='hidden' name='selectStudent' value='$registerId'><input type='submit' name='select' value='Detay' style='width:60px; height:20px; background-color: transparent; border:1px solid black'>  $name $lastname (sınıfı: $class)</form>";
		}
		$recordCount = count($studentRow);

	}


	if (isset($_GET['selectStudent'])){
		$selectStudent = $_GET['selectStudent'];
		//echo $selectStudent;
		
		$sql = "SELECT * FROM incnet.profilesMain WHERE registerId = '$selectStudent'";
		//echo $sql;
		$query=mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$student_name = $row['name'];
			$student_lastname = $row['lastname'];
			$student_DOB = $row['DOB'];
			$student_tckn = $row['tckn'];
			$class = $row['class'];
			$student_ilce = $row['ilce'];
			$student_il = $row['il'];
			$student_homePhone = $row['homePhone'];
			$student_cellPhone = $row['cellPhone'];
			$student_socialSecurity = $row['socialSecurity'];
			$parent = $row['parentName'];
			$student_table = "
			<table>
				<tr><td>Sınıf:</td><td>$class</td></tr>
				<tr><td>Doğum tarihi:</td><td>$student_DOB</td></tr>
				<tr><td>TC Kimlik no:</td><td>$student_tckn</td></tr>
				<tr><td>Ev:</td><td>$student_ilce, $student_il</td></tr>
				<tr><td>Ev telefonu:</td><td>$student_homePhone</td></tr>
				<tr><td>Bağlı olduğu SGK:</td><td>$student_socialSecurity</td></tr>
				<tr><td>Velisi:</td><td>$parent</td></tr>
			</table>";
		}
			
		$sql = "SELECT * FROM incnet.profilesMotherinfo WHERE registerId = '$selectStudent'";
		//echo $sql;
		$query=mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$mother_name = $row['name'];
			$mother_lastname = $row['lastname'];
			$mother_ilce = $row['ilce'];
			$mother_il = $row['il'];
			$mother_homePhone = $row['homePhone'];
			$mother_cellPhone = $row['cellPhone'];
			$mother_workPhone = $row['workPhone'];
			$mother_work = $row['work'];
			$mother_workCity = $row['workCity'];
			$mother_table = "<br>
			<table>
				<tr><td><b>Anne:</b></td><td>$mother_name $mother_lastname</td></tr>
				<tr><td>Ev:</td><td>$mother_ilce, $mother_il</td></tr>
				<tr><td>Ev telefonu:</td><td>$mother_homePhone</td></tr>
				<tr><td>Çalışma durumu:</td><td>$mother_work</td></tr>
				<tr><td>İşyeri:</td><td>$mother_workCity</td></tr>
			</table>";
		}
		
		$sql = "SELECT * FROM incnet.profilesFatherinfo WHERE registerId = '$selectStudent'";
		//echo $sql;
		$query=mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$father_name = $row['name'];
			$father_lastname = $row['lastname'];
			$father_ilce = $row['ilce'];
			$father_il = $row['il'];
			$father_homePhone = $row['homePhone'];
			$father_cellPhone = $row['cellPhone'];
			$father_workPhone = $row['workPhone'];
			$father_work = $row['work'];
			$father_workAddress = $row['workAddress'];
			$father_workCity = $row['workCity'];
			$father_table = "<br>
			<table>
				<tr><td><b>Baba:</b></td><td>$father_name $father_lastname</td></tr>
				<tr><td>Ev:</td><td>$father_ilce, $father_il</td></tr>
				<tr><td>Ev telefonu:</td><td>$father_homePhone</td></tr>
				<tr><td>Çalışma durumu:</td><td>$father_work</td></tr>
				<tr><td>İşyeri:</td><td>$father_workCity</td></tr>
			</table>";
		}
	
	
	$sql = "SELECT * FROM incnet.profilesRelatives WHERE registerId = '$selectStudent' ORDER BY relativeId DESC";
	//echo $sql;
	$query=mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		$rel1_name = $row['name'];
		$rel1_lastname = $row['lastname'];
		$rel1_relation = $row['relation'];
		$rel1_ilce = $row['ilce'];
		$rel1_il = $row['il'];
		$rel1_homePhone = $row['homePhone'];
		$rel1_cellPhone = $row['cellPhone'];
		$rel1_workPhone = $row['workPhone'];
		if (($rel1_name!='')||($rel1_lastname!='')){
			$rel1_table = "<br>
				<table>
					<tr><td><b>Akraba/yakın:</b></td><td>$rel1_name $rel1_lastname</td></tr>
					<tr><td>İlişki:</td><td>$rel1_relation</td></tr>
					<tr><td>Ev:</td><td>$rel1_ilce, $rel1_il</td></tr>
					<tr><td>Ev telefonu:</td><td>$rel1_homePhone</td></tr>
					<tr><td>Cep telefonu:</td><td>$rel1_cellPhone</td></tr>
					<tr><td>İş telefonu:</td><td>$rel1_workPhone</td></tr>
				</table>";
		}
	}

		$sql = "SELECT * FROM incnet.profilesRelatives WHERE registerId = '$selectStudent' ORDER BY relativeId ASC";
		//echo $sql;
		$query=mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$rel2_name = $row['name'];
			$rel2_lastname = $row['lastname'];
			$rel2_relation = $row['relation'];
			$rel2_ilce = $row['ilce'];
			$rel2_il = $row['il'];
			$rel2_homePhone = $row['homePhone'];
			$rel2_cellPhone = $row['cellPhone'];
			$rel2_workPhone = $row['workPhone'];
					if (($rel2_name!='')||($rel2_lastname!='')){
			$rel2_table = "<br>
				<table>
					<tr><td><b>Akraba/yakın:</b></td><td>$rel2_name $rel2_lastname</td></tr>
					<tr><td>İlişki:</td><td>$rel2_relation</td></tr>
					<tr><td>Ev:</td><td>$rel2_ilce, $rel2_il</td></tr>
					<tr><td>Ev telefonu:</td><td>$rel2_homePhone</td></tr>
					<tr><td>Cep telefonu:</td><td>$rel2_cellPhone</td></tr>
					<tr><td>İş telefonu:</td><td>$rel2_workPhone</td></tr>
				</table>";
		}

		}
	}
	
?>

<!doctype html>
<HTML>
	<head>
		<link rel="shortcut icon" href="../../incnet/favicon.ico" >
		<meta charset="utf-8">
		<link rel="stylesheet" href="../style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<body OnLoad="document.selectSearch.searchKey.focus();">
	</head>
	
	<body>
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<a href='../../incnet'><img src='../../incnet/incnet.png' width='140px'></a>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
				<div class='titleDiv'>
					<br>Aile ve yakın iletişim bilgileri<br><br>
				</div>
					<form method='POST' name='selectSearch' autocomplete='off'>
						<c style='color:#c1272d'>Soyada göre ara:</c><br>
						<input type='text' name='searchKey' style='border:1px solid black; width:150px'>&nbsp<input type='submit' name='search' value='Ara' style='width:60px; background-color: transparent; border:1px solid black'>
						</form>
						<br>
						<?PHP
							if ((isset($_POST['search']))&&($recordCount>0)){
								echo $recordCount . " kayıt bulundu!<br><br>";
								$student_table='';
								$mother_table='';
								$father_table='';
								$rel1_table='';
								$rel2_table='';
								$student_name = '';
								$student_lastname = '';
								
							} else if ((isset($_POST['search']))&&($recordCount==0)){
								echo "Kayıt bulunamadı!<br><br>";
							}
							for ($i=0; $i<$recordCount; $i++){
								echo $studentRow[$i];
							}
							
							if (isset($_GET['selectStudent'])){
								echo "<c style='color:#c1272d'>$student_name $student_lastname</c><br>";
								echo $student_table;
								echo "<table><tr><td>$mother_table</td><td style='width:80px'></td><td>$father_table</td></tr><tr><td>$rel1_table</td><td></td><td>$rel2_table</td></tr></table>";
							}
							

						?><br><br><br><br>
				</td>
			</tr>
		</table>
		
		<div class="copyright">&nbsp © INÇNET</div>
	</body>
</HTML>









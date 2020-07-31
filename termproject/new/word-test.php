<?php
	
	header("Content-type: application/vnd.ms-word");
	header("Content-Disposition: attachment;Filename=petitions.doc"); 
	
	
	
	//My own code makes me want to puke :/ --Efeyzi

	error_reporting(0);//I mean, this alone... :/
	
	//connect to mysql server
	
	function camelCaseToSpaceTitle($s){
		$arr = str_split($s);
		$str = "";
		foreach($arr as $c){
			if(ctype_upper($c)){
				$str.=" ";
			}
			$str.=$c;
		}
		return ucfirst($str);
	}
	
	
	
	
	  include("../db_connect.php");
	  if(!$con) die("Can't connect:".$con -> error);
	  $sql = "SELECT * FROM coreusers WHERE type LIKE 'student' AND (class='Hz' OR class='9' OR class='10' OR class='11IB' OR class='11MEB' OR class='12IB' or class='12MEB')";
	  $result = mysql_query($sql);
	  	  $blin = "<html>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF8\">
			<body>";
	while($row = mysql_fetch_assoc($result)){
		echo("annen");
	  
		  $student_class = $row['class'];
		  $student_num = $row['student_id'];
		  $student_name = $row['name']." ".$row['lastname'];
		  
		  $sql2 = "SELECT * FROM tp WHERE user_id=".$row['user_id'];
		  echo sql2;
		  mysql_connect("94.73.170.253", "Tproject", "5ge353g5419L8fIEPv0E");
		  mysql_select_db("tproject");
		  $result2 = mysql_query($sql2);
		  
		  $dersler = array();
		  
		  $da = false;
		  
		  while($row2 = mysql_fetch_assoc($result2)){
			$dersler[] = camelCaseToSpaceTitle($row2['lesson']);
			$two = true;
			$da = true;
		  }
		  
		  //if(!$da) continue;
		  
		  $blin.= "
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>TEV ÖZEL İNANÇ TÜRKEŞ LİSESİ MÜDÜRLÜĞÜ’NE</b><br/><br/>
			Okulunuz ". (($student_class == "Hz") ? "Hazırlık Sınıfı" : $student_class.". sınıf, ")."$student_num numaralı öğrencisiyim. 2017-2018 Eğitim-Öğretim yılında aşağıda belirttiğim tercih sırasına göre uygun görülen ".($two ? "iki" : "bir")." dersten proje ödevi almak istiyorum.<br/><br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Gereğini bilgilerinize arz ederim.<br/><br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			";
			$blin.=date("d/m/Y");
			$blin.="<br/>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			$student_name<br/><br/>
			<span style=\"text-decoration: underline;\">DERS TERCİH SIRALAMASI:</span><br/>
			<ol>";
					foreach($dersler as $ders){
						$blin.="<li>$ders</li>";
					}
			$blin.="</ol>
			<br/>
";
			$student_class = "Sınıf";
			$student_num = "numara";
			$student_name = "Ad Soyad";
			  
			$dersler = array("Ders 1", "Ders 2", "Ders 3", "Ders 4", "Ders 5");
			$two = true;

			if($odd){
				$blin.= "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
				$odd = false;
			}else $odd = true;
			
			
	}	
	$blin.="</body></html>";
	echo $blin;
?>
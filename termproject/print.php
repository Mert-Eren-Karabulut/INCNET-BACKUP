<?

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=petitions.doc"); 

function class_to_human($s){
	$class_db = array("turkish", "math", "english", "second", "physics", "chemistry", "biology", "cs", "itgs", "history", "geography", "religion", "philosophy", "music", "art", "econ", "ess", "engprep");
	$class_human = array("Türkçe", "Matematik", "İngilizce", "İkinci Yabancı Dil", "Fizik", "Kimya", "Biyoloji", "Bilgisayar", "ITGS", "Tarih", "Coğrafya", "Din Kültürü ve Ahlak Bilgisi", "Felsefe", "Müzik", "Görsel Sanatlar", "Ekonomi", "ESS", "İngilizce");
	$ret = array_search($s, $class_db);
	if($ret === false) return "";
	return $class_human[$ret];
}


mysql_connect("94.73.170.253","Tproject", "5ge353g5419L8fIEPv0E");
mysql_select_db("tproject");
mysql_query("SET NAMES utf8");

$sql = "SELECT * FROM tp ORDER BY user_id DESC, no ASC";
$result = mysql_query($sql);

$things = array();

while($row = mysql_fetch_assoc($result)){
	$things[$row['user_id']][] = $row;
}

$blin = "<html>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF8\">
			<body>";

$even = false;
foreach($things as $thing){
	$abc = 0;
	foreach($thing as $ders){
		if($ders['real']) $abc++;
	}
	$two = ($abc > 1);
	$blin.= "
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>TEV ÖZEL İNANÇ TÜRKEŞ LİSESİ MÜDÜRLÜĞÜ’NE</b><br/><br/>
			Okulunuz ".((substr(strtoupper($thing[0]['class']), 0, 1) == 0) ? ("Hazırlık ".strtoupper(substr($thing[0]['class'], 1))) : strtoupper($thing[0]['class']))." sınıfı, ".$thing[0]['stud_no']." numaralı öğrencisiyim. 2017-2018 Eğitim-Öğretim yılında aşağıda belirttiğim tercih sırasına göre uygun görülen ".($two ? "iki" : "bir")." dersten proje ödevi almak istiyorum.<br/><br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Gereğini bilgilerinize arz ederim.<br/><br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			".$thing[0]['name']."<br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			";
			$blin.=date("d/m/Y");
			$blin.="<br><br/>	";
			//for($i = 0; $i < ((128 - 13) - count(str_split($student_name))); $i++) $blin.="&nbsp;";
			$blin.="
			<br/><br>$student_name<br/><br/>
			<span style=\"text-decoration: underline;\">DERS TERCİH SIRALAMASI:</span><br/>
			<ol>";
					foreach($thing as $ders){
						$blin.="<li>".class_to_human($ders['lesson'])."</li>";
					}
			$blin.="</ol>
			<br/>
";
if($even){
	$blin.="<br clear=\"all\" style=\"page-break-before:always\" />";
	$even = false;
}else{
	$even = true;
}
}
$blin.="</body></html>";
echo $blin;
?>
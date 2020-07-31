<!DOCTYPE html>
<html>
<head>
	<title>Term Project</title>
	<meta charset="UTF-8"/>

    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Term Projects</title>
</head>
<style>
select{
  display: inherit;
}
</style>
<body>
  <div class="container">
    <div class="row">
      <div class="input-field">
<select id="classes" class="col s4" onchange="classChange()">
	<option value="0a">Prep A</option>
	<option value="0b">Prep B</option>
	<option value="0c">Prep C</option>
	<option value="0d">Prep D</option>
	<option value="9a">9A</option>
	<option value="9b">9B</option>
	<option value="9c">9C</option>
	<option value="9d">9D</option>
	<option value="10a">10A</option>
	<option value="10b">10B</option>
	<option value="10c">10C</option>
	<option value="10d">10D</option>
	<option value="11a">11A</option>
	<option value="11b">11B</option>
	<option value="11c">11C</option>
	<option value="11d">11D</option>
	<option value="11e">11E</option>
	<option value="12a">12A</option>
	<option value="12b">12B</option>
	<option value="12c">12C</option>
	<option value="12d">12D</option>
	<option value="12e">12E</option>
</select>
</div>
<div class="input-field">
<select id="teachers"  class="col s4" onchange="teacherChange()">
	<option value="1">MEHTAP ÇAKMAK NESİPOĞLU</option>
	<option value="2">ARZU AYAR SALMAN</option>
	<option value="3">DİLARA ÇARŞANLI TEKE</option>
	<option value="4">ESİN BİNGÖL</option>
	<option value="5">NALAN DİLAVER</option>
	<option value="6">ERGUN KORBEK</option>
	<option value="7">CAFER ELİTOĞ</option>
	<option value="8">ŞABAN AYTAŞ</option>
	<option value="9">ÇİĞDEM KORBEK</option>
	<option value="10">İSMAİL HAKKI ERGÜVEN</option>
	<option value="11">MUSTAFA AYDOS</option>
	<option value="12">DAVID HELLIWELL</option>
	<option value="13">HULUSİ GÜRAY TUNCA</option>
	<option value="14">ALİ ÜNLÜ</option>
	<option value="15">BAHAR ÖZKAN</option>
	<option value="16">KÜBRA KÖROĞLU AYDOS</option>
	<option value="17">CEREN ÖZBAY</option>
	<option value="18">ELÇİN ÜNAL</option>
	<option value="19">BOĞAÇ KARÇIKA</option>
	<option value="20">İREM SAK</option>
	<option value="21">YALÇIN TAŞDELEN</option>
	<option value="22">AYŞE GÜLER TUNCA</option>
	<option value="23">EVREN TOY</option>
	<option value="24">ÖNDER KARABULUT</option>
	<option value="25">FATİH METİN</option>
	<option value="26">ERSİN TOY</option>
	<option value="27">SEMA BAKİOĞLU KARAYAĞMURLAR</option>
	<option value="28">FATMA BİRAY HAŞLAMAN</option>
	<option value="29">EBRU ARICI</option>
	<option value="30">ALAN KEARIN</option>
	<option value="31">NALAN HELLIWELL</option>
	<option value="32">NİHAL ŞEMİN</option>
	<option value="33">BAŞAK BELİZ KEARIN</option>
	<option value="34">SANDRİNE BELİKIRIK</option>
	<option value="35">HURİYE NURDAN ÖNDER</option>
	<option value="36">HÜLYA AKGÜN</option>
	<option value="37">ASLI ÜNLÜ</option>
	<option value="38">DAKOTA DWAİN DUECY</option>
	<option value="39">BRİTTANY MARİE REDD</option>
	<option value="40">JOSHUA J.LİSİ</option>
	<option value="41">LYNSEY JILL HAUGHT</option>
	<option value="42">MELISSA ÖZTÜRKYILMAZ</option>
	<option value="43">SAYGIN GÜCÜM</option>
	<option value="44">BERNA SEVGEN</option>
	<option value="45">AYPER SOLEY AKALIN YAZ</option>
	<option value="46">YUNUS GENCER</option>
	<option value="47">KAMBER CEYLAN</option>
</select>
</div>
<div class="input-field">
<!-- <input type="submit" class="col s2" onclick="reset()" value="Reset"> -->
<a class="waves-effect waves-light btn col s2" onclick="reset()">Reset</a>
</div>
<div class="input-field">
<!-- <input type="submit" class="col s2" onclick="reset()" value="Reset"> -->
<a class="waves-effect waves-light btn col s2" href="http://incnet.tevitol.org/termproject/print.php">Print Requests</a>
</div>
</div>
<div class="divider"></div>

<table class="responsive-table striped">
<?php
//header("Content-type: text/html; charset=utf-8");
if($_GET['token']=="596a96cc7bf9108cd896f33c44aedc8a"){
$servername = "94.73.170.253";
$username = "Tproject";
$password = "5ge353g5419L8fIEPv0E";
$dbname = "tproject";
$conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn -> exec("SET NAMES utf8;");
$class = $_GET['class'];
$boolean =false;
if($class!=""){
	$sqlextra = "AND tp.class=:class";
	$sqlarray =array(":class" => $class);
	$boolean = true;
}
$teacher = $_GET['teacher'];
if($teacher!=""){
	$sqlextra = "AND tp.teacher=:teacher";
	$sqlarray = array(":teacher" => $teacher);
	$boolean = true;
}
if($boolean){
	$sql = $conn->prepare("SELECT tp.name, tp.stud_no, tp.class, teachers.teacher_name FROM tp,teachers WHERE tp.teacher=teachers.teacher " . $sqlextra);
	$sql -> execute($sqlarray);
}else{
	$sql = $conn->prepare("SELECT tp.name, tp.stud_no, tp.class, teachers.teacher_name FROM tp,teachers WHERE tp.teacher=teachers.teacher ");
	$sql -> execute();
}
$array = array();
while($row=$sql->fetch()){
	echo "<tr><td>" . $row['name'] . "</td><td>" . $row['stud_no'] . "</td><td>" . $row['class'] . "</td><td>" . $row['teacher_name'] . "</td></tr>";
}
}else{
	//header("location:index.php");
}
?>
</table>
</div>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>

</body>
<script type="text/javascript">
	function classChange(){
		var e = document.getElementById("classes");
		var strUser = e.options[e.selectedIndex].value;
		var text = "http://incnet.tevitol.org/termproject/report.php?token=596a96cc7bf9108cd896f33c44aedc8a&class="+strUser;
		window.location = text;
	}
	function teacherChange(){
		var e = document.getElementById("teachers");
		var strUser = e.options[e.selectedIndex].value;
		var text = "http://incnet.tevitol.org/termproject/report.php?token=596a96cc7bf9108cd896f33c44aedc8a&teacher="+strUser;
		window.location = text;
	}
	function reset(){
		var text = "http://incnet.tevitol.org/termproject/report.php?token=596a96cc7bf9108cd896f33c44aedc8a";
		window.location = text;
	}
</script>
</html>

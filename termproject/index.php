<?
if(false && !isset($_GET["debug"])&&(time() < 2545637500) && ( true || !isset($_GET['debug'])))die("<h1>This page is under maintenance.</h1>This means wait. Don't come to me for help. Don't go to the administration for help. Just wait.");

	//if($_GET['token'] != "nA9ryVi9j8") die("Dönem ödevi seçimleri kapanmıştır. Henüz almadıysanız veya değişirmek istiyorsanız lütfen idareyle iletişime geçin. <br/> <a href=../>Geri</a>");

	/*
	* HAVE TO USE THIS FUNCTION TO JSON ENCODE UTF8
	* FUCK NATRO!!!
	*/
	
	session_start();
	if (!(isset($_SESSION['user_id']))){
		header("location:http://incnet.tevitol.org/incnet/index.php?continue=termproject");
	}
	$user_id = $_SESSION['user_id'];
	$incnetserver = "94.73.150.252";
	$incnetuser = "incnetRoot";
	$incnetpass = "6eI40i59n22M7f9LIqH9";
	$incnetdb = "incnet";
    $incnet = new PDO("mysql:host=$incnetserver;dbname=$incnetdb;", $incnetuser, $incnetpass);
    // set the PDO error mode to exception
    $incnet->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $incnet -> exec("SET NAMES utf8;");
	
	$areyouateachersql = $incnet -> prepare("SELECT type FROM coreusers WHERE user_id=:user");
	$areyouateachersql -> execute(array(':user' => $user_id));
	
	while ($row = $areyouateachersql -> fetch()) {
    	if($row['type'] == "teacher" && false){
			header("Location: ./teacher.php");
		}
    }
	
	$permitted = false;
	
	
	$incnetsql = $incnet->prepare("SELECT * FROM corepermits WHERE user_id=:user AND page_id=1101");
    $incnetsql -> execute(array(':user' => $user_id));

    while ($row = $incnetsql -> fetch()) {
		$permitted = true;
    }
	
	
    $incnetsql = $incnet->prepare("SELECT name, lastname FROM coreusers WHERE user_id=:user");
    $incnetsql -> execute(array(':user' => $user_id));

    while ($row = $incnetsql -> fetch()) {
    	$fullname = $row['name'] . " " . $row['lastname'];
    }


	if($_GET['return']=="0"){
		echo "<script>alert('Biraz geç kaldın galiba :/ Başka bir öğretmen dene.')</script>";
	}elseif ($_GET['return']=="1") {
		echo "<script>alert('İşlem başarıyla gerçekleşti.')</script>";
	}elseif ($_GET['return']=="3") {
		echo "<script>alert('Lütfen bütün yerleri doldurun.')</script>";
	}elseif ($_GET['return']=="2") {
		echo "<script>alert('Hazırlıklar 1. dönem ödevi olarak İngilizce almak zorundadırlar.')</script>";
	}

	function my_json_encode($arr){
	        //convmap since 0x80 char codes so it takes all multibyte codes (above ASCII 127). So many characters are being "hidden" from normal json_encoding
	        array_walk_recursive($arr, function (&$item, $key) { if (is_string($item)) $item = mb_encode_numericentity($item, array (0x80, 0xffff, 0, 0xffff), 'UTF-8'); });
	        return mb_decode_numericentity(json_encode($arr), array (0x80, 0xffff, 0, 0xffff), 'UTF-8');

	}

	header("Content-type: text/html; charset=utf-8");
	$servername = "94.73.170.253";
	$username = "Tproject";
	$password = "5ge353g5419L8fIEPv0E";
	$dbname = "tproject";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn -> exec("SET NAMES utf8;");

    $sql = "SELECT * FROM teachers";
    $result = $conn->query($sql);
	
	$worldhistory = array();
    $math = array();
    $turkish = array();
    $history = array();
    $geography = array();
    $religion = array();
    /*$philosophy = array();*/
    $cs = array();
    $physics = array();
    $biology = array();
    $chemistry = array();
    $english = array();
    $music = array();
    $art = array();
    $pe = array();
    $second = array();
    $ess = array();
    $econ = array();
   /* $itgs = array();*/
    $engprep = array();
    foreach ($result as $teacher) {

	    //$sqlcount = "SELECT COUNT(tp.teacher) as total FROM tp,teachers WHERE tp.ee LIKE 'no' AND teachers.teacher=tp.teacher AND teachers.teacher='" . $teacher['teacher'] . "' AND tp.real LIKE '1'";
	    
		$sqlcount = "SELECT * FROM tp,teachers WHERE tp.ee LIKE 'no' AND (tp.teacher = teachers.teacher AND `tp`.`real` LIKE '1' AND tp.teacher = '".$teacher['teacher']."')";
		$known_user_ids = array();
		$i = 0;
		try{
			$resultcount = $conn->query($sqlcount);
		}catch(Exception $e){
			var_dump($e);
		}
	    foreach ($resultcount as $countobject) {
			if(in_array($countobject['user_id'], $known_user_ids)){
				continue;
			}else{
				$known_user_ids[] = $countobject['user_id'];
				$i++;
			}
			//var_dump($teacher['teacher_name'], $countobject['total']);
	    }
	    $count = $teacher['quota'] - $i;
		
		$sqlee = "SELECT COUNT(extended_record_id) as cnt FROM `extended` as cnt WHERE teacher_id=$teacher[teacher]";
		$resultee = $conn->query($sqlee);
		
		foreach ($resultee as $eeobject) {
	    	$count = $count -  $eeobject['cnt'];
	    }

	    /*if(($teacher['teacher']=='40')||($teacher['teacher']=='38')||($teacher['teacher']=='23')||($teacher['teacher']=='16')||($teacher['teacher']=='55')){
	    	$count = $count/2;
	    }*/

    	switch($teacher['subject']){
			case "World History":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($worldhistory, $arrayy);
    			break;
				
    		case "Türkçe":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($turkish, $arrayy);
    			break;

    		case "Matematik":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($math, $arrayy);
    			break;

    		case "Tarih":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($history, $arrayy);
    			break;

    		case "Coğrafya":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($geography, $arrayy);
    			break;

    		case "Din Kültürü ve Ahlak Bilgisi":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($religion, $arrayy);
    			break;

    		/*case "Felsefe":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($philosophy, $arrayy);
    			break;*/

    		case "Bilgisayar":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($cs, $arrayy);
    			break;

    		case "Fizik":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($physics, $arrayy);
    			break;

    		case "Kimya":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($chemistry, $arrayy);
    			break;

    		case "Biyoloji":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($biology, $arrayy);
    			break;

    		case "İngilizce":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($english, $arrayy);
    			break;

    		case "Almanca":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($second, $arrayy);
    			break;

    		case "Fransızca":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($second, $arrayy);
    			break;

    		case "Beden Eğitimi":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($pe, $arrayy);
    			break;

    		case "Müzik":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($music, $arrayy);
    			break;

    		case "Resim":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($art, $arrayy);
    			break;

    		case "Ekonomi":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($econ, $arrayy);
    			break;

    		case "ESS":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($ess, $arrayy);
    			break;

    		/*case "ITGS":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($itgs, $arrayy);
    			break;*/
			case "İngilizce-Prep":
    			$arrayy = array('id' => $teacher['teacher'], 'name' => $teacher['teacher_name'], 'quota' => $count);
    			array_push($engprep, $arrayy);
    			break;
    	}
    }

    $json_array = array('turkish' => $turkish, 'math' => $math, 'history' => $history, 'geography' => $geography, 'religion' => $religion,
    			/*'philosophy' => $philosophy,*/ 'cs' => $cs, 'physics' => $physics, 'chemistry' => $chemistry, 'biology' => $biology,
    			 'english' => $english, 'second' => $second, 'pe' => $pe, 'music' => $music, 'art' => $art, 'econ' => $econ, 'ess' => $ess, /*'itgs' => $itgs,*/ 'engprep' => $engprep, 'worldhistory' => $worldhistory);
    //echo phpversion();
    //var_dump($json_array);

?>
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
</head>
<style>
body{
	/*background-color: rgba(181, 158, 159, 0.5) /* çok kötü oluyo böyle fyi */
}
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0;
}
::-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color:    #009688;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
   color:    #009688;
   opacity:  1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
   color:    #009688;
   opacity:  1;
}
:-ms-input-placeholder { /* Internet Explorer 10-11 */
   color:    #009688;
}
.dontshowthisnow{
	display: none;
}
</style>
<body style="/*background-image: url('background.jpg');background-size: cover;background-repeat: no-repeat;*/" onload="onLoadBody()">
<a href="../incnet/index.php">
	<div style="display:absolute;float:left; top:50px;" class="teal-text">
		<h5>&lt;- Back to INCNET</h5>
		<? if($permitted) echo("<a href=didndoit.php>Proje seçmeyenleri göster</a>");?>
		<? if($permitted) echo("<br/><a href=print.php>Dilekçeleri indir</a>");?>
	</div>
</a>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>

<script>
  $(document).ready(function() {
    $('select').material_select();
  });
</script>
<div class="container">
<form method="post" action="post.php">
<input type="text" style="display:none;" name="id" value="<? echo $user_id?>">
<div class="container center valign-wrapper ">
<div class="input-field col s4 container center valign center-align"> <br><br>
<img src="logo.png" style="max-width:150px; margin-left: 5%;" class="center center-align"><img src="../img/incnetWhite.png" style="max-width: 150px; margin-left: 5%;" class="center center-align"><br>
        <div class="input-field col s6 ">
          <input value="<? echo $fullname;?>" id="first_name" type="text" name="name" class="teal-text validate">
        </div>
        <div class="input-field col s6">
          <input placeholder="Öğrenci Numaranız" id="last_name" type="number" name="stud_no" class="teal-text validate">
        </div>
			<div class="input-field col s12">
		    <select name="class" id="selectBox" onchange="selectEnglish()" required class="teal-text">
		      <option value="" disabled selected>Sınfınız</option>
		      <option value="0">Prep</option>
		      <option value="9">9</option>
		      <option value="10">10</option>
		      <option value="11">11</option>
		      <option value="12">12</option>
		    </select>
		  </div>
			<div class="input-field col s12">
		    <select name="branch" id="branchBox" required class="teal-text">
		      <option value="" disabled selected>Şubeniz</option>
		      <option value="a">A</option>
		      <option value="b">B</option>
		      <option value="c">C</option>
		      <option value="d">D</option>
		      <option value="e">E</option>
		    </select>
		  </div>
			<div class="input-field col s12">
			<?php
				$sql_ee = "SELECT * FROM extended WHERE user_id = ".$user_id;
				$res = $conn -> query($sql_ee) or die("extended essay err");
				foreach($res as $row){
					$ee_lesson = $row['lesson_id'];
					$ee_teacher_id = $row['teacher_id'];
				}
				
			?>
		    <select id="lessons" name="lesson" onchange="classFunc()" required class="teal-text">
		      <option value="" disabled=disabled selected>1. Tercihiniz</option>
			  <option value="worldhistory" <?php if(isset($ee_lesson)) if($ee_lesson != "worldhistory") echo("disabled");?>>World History</option>
		      <option value="turkish" <?php if(isset($ee_lesson)) if($ee_lesson != "turkish") echo("disabled");?>>Türkçe</option>
		      <option value="math" <?php if(isset($ee_lesson)) if($ee_lesson != "math") echo("disabled");?>>Matematik</option>
		      <option value="english" <?php if(isset($ee_lesson)) if($ee_lesson != "english") echo("disabled");?>>İngilizce</option>
		      <option value="second" <?php if(isset($ee_lesson)) if($ee_lesson != "second") echo("disabled");?>>Almanca/Fransızca</option>
		      <option value="physics" <?php if(isset($ee_lesson)) if($ee_lesson != "physics") echo("disabled");?>>Fizik</option>
		      <option value="chemistry" <?php if(isset($ee_lesson)) if($ee_lesson != "chemistry") echo("disabled");?>>Kimya</option>
		      <option value="biology" <?php if(isset($ee_lesson)) if($ee_lesson != "biology") echo("disabled");?>>Biyoloji</option>
		      <option value="cs" <?php if(isset($ee_lesson)) if($ee_lesson != "cs") echo("disabled");?>>Bilgisayar</option>
		      <!--<option value="itgs" <?php if(isset($ee_lesson)) if($ee_lesson != "itgs") echo("disabled");?>>ITGS</option>-->
		      <option value="history" <?php if(isset($ee_lesson)) if($ee_lesson != "history") echo("disabled");?>>Tarih</option>
		      <option value="geography" <?php if(isset($ee_lesson)) if($ee_lesson != "geography") echo("disabled");?>>Coğrafya</option>
		      <option value="religion" <?php if(isset($ee_lesson)) if($ee_lesson != "religion") echo("disabled");?>>Din Kültürü ve Ahlak Bilgisi</option>
		      <!--<option value="philosophy" <?php if(isset($ee_lesson)) if($ee_lesson != "philosophy") echo("disabled");?>>Felsefe</option>-->
		      <option value="music" <?php if(isset($ee_lesson)) if($ee_lesson != "music") echo("disabled");?>>Müzik</option>
		      <option value="art" <?php if(isset($ee_lesson)) if($ee_lesson != "art") echo("disabled");?>>Resim</option>
		      <option value="econ" <?php if(isset($ee_lesson)) if($ee_lesson != "econ") echo("disabled");?>>Ekonomi</option>
		<!--  <option value="ess" <?php if(isset($ee_lesson)) if($ee_lesson != "ess") echo("disabled");?>>ESS</option>
		      <option value="engprep" <?php if(isset($ee_lesson)) if($ee_lesson != "engprep") echo("disabled");?>>İngilizce-Prep</option> -->
		    </select>
		  </div>
			<div class="input-field col s12">
		    <select id="teachers" name="teacher" required class="teal-text">
		      <option value="" disabled selected>Öğretmeniniz</option>
		    </select>
		  </div>
		  <div class="input-field col s12">
		    <select id="lessons2" name="lesson2" onchange="classFunc2()" required class="teal-text">
		      <option value="" disabled selected>2. Tercihiniz</option>
			  <option value="worldhistory">World History</option>
		      <option value="turkish">Türkçe</option>
		      <option value="math">Matematik</option>
		      <option value="english">İngilizce</option>
		      <option value="second">Almanca/Fransızca</option>
		      <option value="physics">Fizik</option>
		      <option value="chemistry">Kimya</option>
		      <option value="biology">Biyoloji</option>
		      <option value="cs">Bilgisayar</option>
		      <!--<option value="itgs">ITGS</option>-->
		      <option value="history">Tarih</option>
		      <option value="geography">Coğrafya</option>
		      <option value="religion">Din Kültürü ve Ahlak Bilgisi</option>
		      <!--<option value="philosophy">Felsefe</option>-->
		      <option value="music">Müzik</option>
		      <option value="art">Resim</option>
		      <option value="econ">Ekonomi</option>
		<!--  <option value="ess">ESS</option> -->
		    </select>
		  </div>
			<div class="input-field col s12" style="display:none" id=findMe>
		    <select id="teachers2" name="teacher2" class="teal-text">
		      <option value="" disabled selected>Öğretmeniniz</option>
		    </select>
		  </div>
		  <div class="input-field col s12">
		    <select id="lessons3" name="lesson3" required class="teal-text">
		      <option value="" disabled selected>3. Tercihiniz</option>
			  <option value="worldhistory">World History</option>
		      <option value="turkish">Türkçe</option>
		      <option value="math">Matematik</option>
		      <option value="english">İngilizce</option>
		      <option value="second">Almanca/Fransızca</option>
		      <option value="physics">Fizik</option>
		      <option value="chemistry">Kimya</option>
		      <option value="biology">Biyoloji</option>
		      <option value="cs">Bilgisayar</option>
		      <!--<option value="itgs">ITGS</option>-->
		      <option value="history">Tarih</option>
		      <option value="geography">Coğrafya</option>
		      <option value="religion">Din Kültürü ve Ahlak Bilgisi</option>
		       <!--<option value="philosophy">Felsefe</option>-->
		      <option value="music">Müzik</option>
		      <option value="art">Resim</option>
		      <option value="econ">Ekonomi</option>
		     <!--  <option value="ess">ESS</option> -->
		    </select>
		  </div><div class="input-field col s12">
		    <select id="lessons4" name="lesson4" required class="teal-text">
		      <option value="" disabled selected>4. Tercihiniz</option>
			  <option value="worldhistory">World History</option>
		      <option value="turkish">Türkçe</option>
		      <option value="math">Matematik</option>
		      <option value="english">İngilizce</option>
		      <option value="second">Almanca/Fransızca</option>
		      <option value="physics">Fizik</option>
		      <option value="chemistry">Kimya</option>
		      <option value="biology">Biyoloji</option>
		      <option value="cs">Bilgisayar</option>
		     <!--<option value="itgs">ITGS</option>-->
		      <option value="history">Tarih</option>
		      <option value="geography">Coğrafya</option>
		      <option value="religion">Din Kültürü ve Ahlak Bilgisi</option>
		       <!--<option value="philosophy">Felsefe</option>-->
		      <option value="music">Müzik</option>
		      <option value="art">Resim</option>
		      <option value="econ">Ekonomi</option>
		    <!--  <option value="ess">ESS</option> -->
		    </select>
		  </div><div class="input-field col s12">
		    <select id="lessons5" name="lesson5" required class="teal-text">
		      <option value="" disabled selected>5. Tercihiniz</option>
			  <option value="worldhistory">World History</option>
		      <option value="turkish">Türkçe</option>
		      <option value="math">Matematik</option>
		      <option value="english">İngilizce</option>
		      <option value="second">Almanca/Fransızca</option>
		      <option value="physics">Fizik</option>
		      <option value="chemistry">Kimya</option>
		      <option value="biology">Biyoloji</option>
		      <option value="cs">Bilgisayar</option>
		      <!--<option value="itgs">ITGS</option>-->
		      <option value="history">Tarih</option>
		      <option value="geography">Coğrafya</option>
		      <option value="religion">Din Kültürü ve Ahlak Bilgisi</option>
		       <!--<option value="philosophy">Felsefe</option>-->
		      <option value="music">Müzik</option>
		      <option value="art">Resim</option>
		      <option value="econ">Ekonomi</option>
		    <!--  <option value="ess">ESS</option> -->
		    </select>
		  </div>
		  <input type=hidden name=user-id value=<? echo $user_id; ?>>
		  <div class="col s12" style="text-align: left;">
			<input type=checkbox name=second id=second onchange="iwanttwo();"><label for=second>İkinci proje ödevi istiyorum</label>
		  </div><br/><br/>
<button class="btn waves-effect waves-light" type="submit" name="lesson_submit" id="lesson_submit" onclick="submit()" >Submit
    <i class="material-icons right">send</i>
  </button>

</form><br><br>
<h5 class="teal-text">*Lütfen Sadece Kendi Öğretmenlerinizi Seçiniz.</h5>
</div>  ,
</div>
<div class=dontshowthisnow><h5>Seçiminizi değiştirmek istiyorsanız lütfen önce eski seçimlerinizi silin.</h5></div><br/><br/>
<div>
	<table class="teal-text">
		<thead>
		<tr>
			<td>Aldığın Ders</td>
			<td>Öğretmenin</td>
		</tr>
		</thead>
		<tbody>
			<?php
				$tablesql = $conn -> prepare("SELECT * FROM tp, teachers WHERE tp.user_id = :user AND tp.teacher = teachers.teacher GROUP BY tp.lesson");
				$tablesql -> execute(array(':user' => $user_id));
				$lastid = "";
				while($tablerow = $tablesql->fetch()){
					if(isset($_GET['debug'])){var_dump($tablerow);echo "<br/><br/><br/>";}
					if(($tablerow['real'] == 1 || $tablerow['teacher_name'] == "TBD") && ($lastid != $tablerow['id'])){echo "<tr><form method=\"post\" action=\"remove.php\">
							<td>
								<input type=\"text\" value=\"" . $tablerow['id'] . "\" name=\"taken_id\"style=\"display:none;\"><input type=hidden name=user_id value=$user_id>
								" . strtoupper($tablerow['lesson']) . "
						    </td>
							<td>
								" . $tablerow['teacher_name'] . "
						    </td>
						    <td>
								<button class=\"btn waves-effect waves-light\" type=\"submit\" name=\"lesson_submit\" id=\"lesson_submit\" onclick=\"submit()\" >Remove
								    <i class=\"material-icons right\">send</i>
								</button>
						    </td>
						</tr>";
						$lastid = $tablerow['id'];
					}
				}

			?>
		</tbody>
	</table>
</div>
</body>
<script type="text/javascript">
	var abcdef = true;
	var ee_teacher_id = <?php if(isset($ee_teacher_id)){echo("$ee_teacher_id"); }else{ echo("''");} ?>;
	function iwanttwo(){
		if(abcdef){
			$('#findMe').show();
			abcdef = false;
		}else{
			$('#findMe').hide();
			abcdef = true;
		}
	}

	function generateOptions(x){
		debugger;
		var newSelect = document.getElementById("teachers");
		while(newSelect.length>0){
			newSelect.remove(0);
		}
		for(var i = 0; i<Object.keys(x).length;i++){
			var opt = x[i].id;
			var textt = x[i].name + " (" + x[i].quota + ")";
			var el = document.createElement("option");
			el.textContent = textt;
			el.value = opt;
			if(x[i].quota<1){
				el.disabled = true;
			}
			newSelect.appendChild(el);
			if(opt != ee_teacher_id && ee_teacher_id != ''){
				el.disabled = true;
			}else if (ee_teacher_id == ''){
				el.selected = true;
			}
		}

     $(document).ready(function() {
    $('select').material_select();
  });
	}

	$(document).ready(
		function(){
			if($('table.teal-text tr').length > 1){
				$('.input-field div').hide();
				$('.input-field button').hide();
				$('.input-field h5').hide();
				$('.dontshowthisnow').show();
			}
		}
	);

	function classFunc(){
		//if(blin) return;
		//alert("asd");
		var json_str = '<? echo my_json_encode($json_array); ?>';
		//alert(json_str);
		var obj = JSON.parse(json_str);

		var e = document.getElementById("lessons");
		var strUser = e.options[e.selectedIndex].value;

		//alert(strUser);
	console.log(obj);
		switch(strUser){
			case "worldhistory":
				generateOptions(obj.worldhistory);
				break;
			case "turkish":
				generateOptions(obj.turkish);
				break;
			case "math":
				generateOptions(obj.math);
				break;
			case "english":
				generateOptions(obj.english);
				break;
			case "second":
				generateOptions(obj.second);
				break;
			case "physics":
				generateOptions(obj.physics);
				break;
			case "chemistry":
				generateOptions(obj.chemistry);
				break;
			case "biology":
				generateOptions(obj.biology);
				break;
			case "cs":
				generateOptions(obj.cs);
				break;
			case "history":
				generateOptions(obj.history);
				break;
			case "geography":
				generateOptions(obj.geography);
				break;
			case "religion":
				generateOptions(obj.religion);
				break;
			/*case "philosophy":
				generateOptions(obj.philosophy);
				break;*/
			case "music":
				generateOptions(obj.music);
				break;
			case "art":
				generateOptions(obj.art);
				break;
			case "ess":
				generateOptions(obj.ess);
				break;
			case "econ":
				generateOptions(obj.econ);
				break;
			/*case "itgs":
				generateOptions(obj.itgs);
				break;*/
			case "engprep":
				generateOptions(obj.engprep);
				break;
		}

	}
	/////////////////////////////////////////
	function generateOptions2(x){
		var newSelect = document.getElementById("teachers2");
		while(newSelect.length>0){
			newSelect.remove(0);
		}
		for(var i = 0; i<Object.keys(x).length;i++){
			var opt = x[i].id;
			var textt = x[i].name + " (" + x[i].quota + ")";
			var el = document.createElement("option");
			el.textContent = textt;
			el.value = opt;
			if(x[i].quota<1){
				el.disabled = true;
			}
			newSelect.appendChild(el);
		}

     $(document).ready(function() {
    $('select').material_select();
  });
	}
	function classFunc2(){
		//alert("asd");
		var json_str = '<? echo my_json_encode($json_array); ?>';
		//alert(json_str);
		var obj = JSON.parse(json_str);

		var e = document.getElementById("lessons2");
		var strUser = e.options[e.selectedIndex].value;

		//alert(strUser);

		switch(strUser){
			case "worldhistory":
				generateOptions(obj.worldhistory);
				break;
			case "turkish":
				generateOptions2(obj.turkish);
				break;
			case "math":
				generateOptions2(obj.math);
				break;
			case "english":
				generateOptions2(obj.english);
				break;
			case "second":
				generateOptions2(obj.second);
				break;
			case "physics":
				generateOptions2(obj.physics);
				break;
			case "chemistry":
				generateOptions2(obj.chemistry);
				break;
			case "biology":
				generateOptions2(obj.biology);
				break;
			case "cs":
				generateOptions2(obj.cs);
				break;
			case "history":
				generateOptions2(obj.history);
				break;
			case "geography":
				generateOptions2(obj.geography);
				break;
			case "religion":
				generateOptions2(obj.religion);
				break;
			/*case "philosophy":
				generateOptions2(obj.philosophy);
				break;*/
			case "music":
				generateOptions2(obj.music);
				break;
			case "art":
				generateOptions2(obj.art);
				break;
			case "ess":
				generateOptions2(obj.ess);
				break;
			case "econ":
				generateOptions2(obj.econ);
				break;
			/*case "itgs":
				generateOptions2(obj.itgs);
				break;*/
		}

	}
	/////////////////////////////////////////


	function submit(){
		alert("submitted");
	}
	//var a = true;
	function selectEnglish(){
		return; ////////////// Remove this if we ever deal with Preps again ///////////////////////
		if($('table.teal-text tr').length > 1) return;
		

		var e = document.getElementById("selectBox");
		var strUser = e.options[e.selectedIndex].value;

		var op = document.getElementById("lessons").getElementsByTagName("option");
		for (var i = 0; i < op.length; i++) {
		  // lowercase comparison for case-insensitivity
		  if (op[i].value.toLowerCase() == "turkish") {
		    if(strUser=="0"){
		    	op[i].disabled = true;
			}else{
		    	op[i].disabled = false;
			}
		  }
		  if(strUser=="0"){
	//if(a){alert("Hazırlıklar lütfen bir süre (14/11/2017 saat 13.00'a kadar) sistemi kullanmasın."); a=false;}
	$('#teachers').html("<option value=999>TBD</option>");
	var blin = true;
		  	op[i].disabled = true;
		  	if (op[i].value.toLowerCase() == "engprep") {
		  		op[i].disabled = false;
		  	}
		debugger;
		  }else{
		  		op[i].disabled = false;
		  }
		}
     $(document).ready(function() {
    $('select').material_select();
  });
	}

</script>
<script type="text/javascript">
  function onLoadBody() {
    document.getElementById('first_name').readOnly = true;
  }
</script>
</html>

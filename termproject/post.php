<?
/**
 * Replaces any parameter placeholders in a query with the value of that
 * parameter. Useful for debugging. Assumes anonymous parameters from 
 * $params are are in the same order as specified in $query
 *
 * @param string $query The sql query with parameter placeholders
 * @param array $params The array of substitution parameters
 * @return string The interpolated query
 */
function interpolateQuery($query, $params) {
    $keys = array();

    # build a regular expression for each parameter
    foreach ($params as $key => $value) {
        if (is_string($key)) {
            $keys[] = '/:'.$key.'/';
        } else {
            $keys[] = '/[?]/';
        }
    }

    $query = preg_replace($keys, $params, $query, 1, $count);

    #trigger_error('replaced '.$count.' keys');

    return $query;
}


$name = $_POST['name'];
$stud_no = $_POST['stud_no'];
$class = $_POST['class'];
$teacher = $_POST['teacher'];
$teacher2 = $_POST['teacher2'];
$branch = $_POST['branch'];
$lesson = $_POST['lesson'];
$lesson2 = $_POST['lesson2'];
$lesson3 = $_POST['lesson3'];
$lesson4 = $_POST['lesson4'];
$lesson5 = $_POST['lesson5'];
$id = $_POST['id'];
$two = $_POST['second'];
$user_id = $_POST['user-id'];

$boolean = false;

header("Content-type: text/html; charset=utf-8");
$servername = "94.73.170.253";
$username = "Tproject";
$password = "5ge353g5419L8fIEPv0E";
$dbname = "tproject";

mysql_connect("94.73.150.252", "incnetRoot", "6eI40i59n22M7f9LIqH9");
mysql_select_db("incnet");

$res = mysql_query("SELECT class FROM coreusers WHERE user_id = $user_id") or die(mysql_error());
$row = mysql_fetch_array($res);

$incnet_class = $row[0];
$is_ee = in_array($incnet_class, explode(",", "12IB, 11IB")) ? "yes" : "no";

echo "<!--<script>-->alert('" . $name . "-" . $stud_no . "-" . $class . "-" . $branch . "-" . $teacher . "-" . $lesson . "')<!--</script>-->";

if(!(isset($_POST['branch']) && isset($_POST['class']) && isset($_POST['lesson']) && isset($_POST['lesson2']) && isset($_POST['lesson3']) && isset($_POST['lesson4']) && isset($_POST['lesson5']) && isset($_POST['teacher']))){
	header('location:index.php?return=3');
}elseif (($lesson=="")) {
	header('location:index.php?return=2');
}else{
echo $class;

$classes_dict = array('turkish' => "Türkçe", 'math' => "Matematik", 'history' => "Tarih", 'geography' => "Coğrafya", 'religion' => "Din Kültürü ve Ahlak Bilgisi",
    			/*'philosophy' => $philosophy,*/ 'cs' => "Bilgisayar", 'physics' => "Fizik", 'chemistry' => "Kimya", 'biology' => "Biyoloji",
    			 'english' => "İngilizce", 'second' => "Almanca' OR subject like 'Fransızca", 'pe' => "Beden Eğitimi", 'music' => "Müzik", 'art' => "Resim", 'econ' => "Ekonomi", 'ess' => "ESS", /*'itgs' => $itgs,*/ 'engprep' => "İngilizce", 'worldhistory' => "World History");

$class = $class . $branch;
$conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn -> exec("SET NAMES utf8;");
$sql = $conn->prepare("SELECT * FROM teachers WHERE (SELECT COUNT(tp.teacher) FROM tp,teachers WHERE teachers.teacher_id=tp.teacher AND teachers.teacher_id=:teacher AND tp.ee LIKE 'no')<(SELECT quota FROM teachers WHERE teachers.teacher=:teacher AND (subject LIKE '".$classes_dict[$lesson]."' ))");
echo("errorInfo1 ");var_dump(($conn -> errorInfo()));	

$sql -> execute(array(':teacher' => $teacher));
echo("errorInfo2 ");var_dump(($conn -> errorInfo()));	
echo "1";
$sql2 = $conn->prepare("SELECT * FROM teachers WHERE (SELECT COUNT(tp.teacher) FROM tp,teachers WHERE teachers.teacher_id=tp.teacher AND teachers.teacher_id=:teacher AND tp.ee LIKE 'no')<(SELECT quota FROM teachers WHERE teachers.teacher=:teacher AND (subject LIKE '".$classes_dict[$lesson2]."' ))");
echo("SELECT * FROM teachers WHERE (SELECT COUNT(tp.teacher) FROM tp,teachers WHERE teachers.teacher_id=tp.teacher AND teachers.teacher_id=:teacher AND tp.ee LIKE 'no')<(SELECT quota FROM teachers WHERE teachers.teacher=:teacher AND (subject LIKE '".$classes_dict[$lesson2]."' ))");
var_dump("heyhey",$lesson, $classes_dict[$lesson]);
echo("errorInfo3 ");var_dump(($conn -> errorInfo()));
try{	
	$sql2 -> execute(array(':teacher' => $teacher2));
}catch(Exception $e){
	var_dump($e);
}echo("POINT ONE");
echo(interpolateQuery("SELECT * FROM teachers WHERE (SELECT COUNT(tp.teacher) FROM tp,teachers WHERE teachers.teacher_id=tp.teacher AND teachers.teacher_id=:teacher AND tp.ee LIKE 'no')<(SELECT quota FROM teachers WHERE teachers.teacher=:teacher AND subject LIKE '".$classes_dict[$lesson]."' )", array(':teacher' => $teacher2)));
echo("errorInfo4");var_dump(($conn -> errorInfo()));	
echo "2";
echo $teacher;
echo("<br/>teacher2: $teacher2 <br/>lesson2: $lesson2");

$stmt2 = $conn->prepare("SELECT * FROM tp WHERE user_id=$user_id");

//if($row = $sql -> fetch()) header("location:index.php?return=1");

$queryOne = $sql -> fetch();
$queryTwo = $sql2 -> fetch();
echo("POINT TWO");
var_dump("bir", $queryOne, "iki", $queryTwo);
echo("POINT THREE");

if($queryOne != false && ($queryTwo != false || !$two)) {
	$stmt = $conn->prepare("INSERT INTO `tp`(`id`, `name`, `stud_no`, `user_id`, `class`, `teacher`, `lesson`, `real`, `no`, ee) VALUES (0, :name, :stud_no, $user_id, :class, :teacher, :lesson, :real, :no, :ee) ");
	echo interpolateQuery("INSERT INTO `tp`(`id`, `name`, `stud_no`, `user_id`, `class`, `teacher`, `lesson`, `real`, `no`) VALUES (0, :name, :stud_no, $user_id, :class, :teacher, :lesson, :real, :no) ", array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => $teacher, ':lesson' => $lesson, ':real' => 1, ':no' => 1));
	
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => $teacher, ':lesson' => $lesson, ':real' => 1, ':no' => 1, ':ee' => $is_ee));
	echo("1");
	try{
		$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => $teacher2, ':lesson' => $lesson2, ':real' => ($two ? 1 : 0), ':no' => 2, ':ee' =>  "no"));
	}catch(Exception $e){
		echo("exception at 2");
		if($two)
			die("FATAL ERROR: Couldn't  execute insert query two. Contact me with a screenshot.");
	}
	echo("2");
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => "", ':lesson' => $lesson3, ':real' => 0, ':no' => 3, ':ee' =>  "no"));
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => "", ':lesson' => $lesson4, ':real' => 0, ':no' => 4, ':ee' =>  "no"));
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => "", ':lesson' => $lesson5, ':real' => 0, ':no' => 5, ':ee' =>  "no"));
	$boolean = true;
}else{
	echo "GG LOL";
}


if($teacher == "999") {
	$stmt = $conn->prepare("INSERT INTO `tp`(`id`, `name`, `stud_no`, `user_id`, `class`, `teacher`, `lesson`, `real`, `no`, 'ee') VALUES (0, :name, :stud_no, $user_id, :class, :teacher, :lesson, :real, :no, no) ");
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => $teacher, ':lesson' => $lesson, ':real' => 1, ':no' => 1))	;
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => $teacher2, ':lesson' => $lesson2, ':real' => ($two ? 1 : 0), ':no' => 2));
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => "", ':lesson' => $lesson3, ':real' => 0, ':no' => 3));
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => "", ':lesson' => $lesson4, ':real' => 0, ':no' => 4));
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => "", ':lesson' => $lesson5, ':real' => 0, ':no' => 5));
	$boolean = true;
}
	if($boolean){
		header('location:index.php?return=1');
	}else{
		echo('$boolean is false');
		echo("<br/><br/>This shouldn't happen but is usually not a big problem. Take a screenshot and return to the previous page. If you appear to have taken a term project, it's fine, you don't need to do anything. If it appears you couldn't register the term project, send the screenshot to me.");
		//header('location:index.php?return=0');
	}
}
?>
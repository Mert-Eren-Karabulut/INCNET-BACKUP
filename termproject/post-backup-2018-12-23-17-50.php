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
$boolean = false;
header("Content-type: text/html; charset=utf-8");
$servername = "94.73.170.253";
$username = "Tproject";
$password = "5ge353g5419L8fIEPv0E";
$dbname = "tproject";

$is_ee = in_array($class, explode("12A,12B,11A", ",")) ? "yes" : "no";

echo "<script>alert('" . $name . "-" . $stud_no . "-" . $class . "-" . $branch . "-" . $teacher . "-" . $lesson . "')</script>";

if(!(isset($_POST['branch']) && isset($_POST['class']) && isset($_POST['lesson']) && isset($_POST['lesson2']) && isset($_POST['lesson3']) && isset($_POST['lesson4']) && isset($_POST['lesson5']) && isset($_POST['teacher']))){
	header('location:index.php?return=3');
}elseif (($lesson=="")) {
	header('location:index.php?return=2');
}else{
echo $class;

$class = $class . $branch;
$conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn -> exec("SET NAMES utf8;");
$sql = $conn->prepare("SELECT * FROM teachers WHERE (SELECT COUNT(tp.teacher) FROM tp,teachers WHERE teachers.teacher_id=tp.teacher AND teachers.teacher_id=:teacher)<((SELECT quota FROM teachers WHERE teachers.teacher_id=:teacher) - (SELECT COUNT(extended.extended_record_id) FROM extended WHERE extended.teacher_id=:teacher AND teachers.teacher_id=:teacher))"); //BOZUK
$sql -> execute(array(':teacher' => $teacher));
$sql2 = $conn->prepare("SELECT * FROM teachers WHERE (SELECT COUNT(tp.teacher) FROM tp,teachers WHERE teachers.teacher_id=tp.teacher AND teachers.teacher_id=:teacher)<((SELECT quota FROM teachers WHERE teachers.teacher_id=:teacher) - (SELECT COUNT(extended.extended_record_id) FROM extended WHERE extended.teacher_id=:teacher AND teachers.teacher_id=:teacher))");
$sql2 -> execute(array(':teacher' => $teacher2));

$user_id = $_POST['user-id'];
echo $teacher;

$stmt2 = $conn->prepare("SELECT * FROM tp WHERE user_id=$user_id");

//if($row = $sql -> fetch()) header("location:index.php?return=1");


if($row = $sql -> fetch() && (($row2 = $sql2 -> fetch()) || !$two)) {
	$stmt = $conn->prepare("INSERT INTO `tp`(`id`, `name`, `stud_no`, `user_id`, `class`, `teacher`, `lesson`, `real`, `no`, ee) VALUES (0, :name, :stud_no, $user_id, :class, :teacher, :lesson, :real, :no, :ee) ");
	echo interpolateQuery("INSERT INTO `tp`(`id`, `name`, `stud_no`, `user_id`, `class`, `teacher`, `lesson`, `real`, `no`) VALUES (0, :name, :stud_no, $user_id, :class, :teacher, :lesson, :real, :no) ", array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => $teacher, ':lesson' => $lesson, ':real' => 1, ':no' => 1));
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => $teacher, ':lesson' => $lesson, ':real' => 1, ':no' => 1, ':ee' => $is_ee));
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => $teacher2, ':lesson' => $lesson2, ':real' => ($two ? 1 : 0), ':no' => 2, ':ee' =>  "no"));
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => "", ':lesson' => $lesson3, ':real' => 0, ':no' => 3, ':ee' =>  "no"));
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => "", ':lesson' => $lesson4, ':real' => 0, ':no' => 4, ':ee' =>  "no"));
	$stmt -> execute(array(':name' => $name, ':stud_no' => $stud_no, ':class' => $class, ':teacher' => "", ':lesson' => $lesson5, ':real' => 0, ':no' => 5, ':ee' =>  "no"));
	$boolean = true;
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
		//header('location:index.php?return=0');
	}
}
?>
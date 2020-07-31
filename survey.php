<?php
session_start();
$link = mysql_connect('94.73.150.252', 'incnetRoot', '6eI40i59n22M7f9LIqH9');
if (!$link) {
    die('Bağlanamadı: ' . mysql_error());
}

$db_selected = mysql_select_db('incnet', $link);
if (!$db_selected) {
    die ('Can\'t use incnet : ' . mysql_error());
}

$id = $_SESSION['id'];


$stmt1 = "SELECT class FROM coreusers WHERE user_id=" . $id;
$result = mysql_query($stmt1);
$sec =1;
while ($class = mysql_fetch_array($result)) {
  if(($class['class']=="12")||($class['class']=="11")||($class['class']=="10")||($class['class']=="Hz")||($class['class']=="9")){

		$stmt2 = "SELECT answer FROM survey WHERE user_id =" . $id;
    $result2 = mysql_query($stmt2);
    $sec = 2;
    while($row = mysql_fetch_array($result2)) {
      $sec = 3;
    }
  }
}

switch ($sec) {
  case 1:
    header('Location: http://incnet.tevitol.org');
    break;
  case 2:
    break;
  case 3:
    header('Location: http://incnet.tevitol.org/answers.php');
    break;
  default:
    # code...
    break;
}

if(isset($_POST['submit']))
{
  $answer_sql = "INSERT INTO survey VALUES (" . $id . ", " . $_POST['group1'] . ")";
  mysql_query($answer_sql);
  header('Location:http://incnet.tevitol.org/answers.php');
}
?>

 <html>
<head>
  <!--Import Google Icon Font-->
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="materialize/css/materialize.min.css"  media="screen,projection"/>

<!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta charset="utf-8"/>
</head>
<body style="background-image: url('http://basvuru.tevitol.org/background.jpg')">
  <!-- Modal Structure -->
    <div id="modal1" class="modal">
      <div class="modal-content">
        <h4>Bildiriyi Destekliyor Musunuz?</h4>
        <form method="post" action="">
          <p>
            <input name="group1" type="radio" value="1" id="test1" />
            <label for="test1">Evet</label>
          </p>
          <p>
            <input name="group1" type="radio" value="0" id="test2" />
            <label for="test2">Hayır</label>
          </p>
          <input type="submit" name="submit" value="Gönder">
        </form>
      </div>
    </div>

      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
      <script>
      $(document).ready(function(){
   // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
   $('.modal-trigger').leanModal();
 });

      $(document).ready(function() {
    $('input#input_text, textarea#textarea1').characterCounter();
  });
  $('#modal1').openModal();
      </script>
</body>
 </html>

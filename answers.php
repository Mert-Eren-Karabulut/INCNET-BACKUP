<?
session_start();
$link = mysql_connect('94.73.150.252', 'incnetRoot', '6eI40i59n22M7f9LIqH9');
if (!$link) {
    die('Bağlanamadı: ' . mysql_error());
}

$db_selected = mysql_select_db('incnet', $link);
if (!$db_selected) {
    die ('Can\'t use incnet : ' . mysql_error());
}

$sql = "SELECT COUNT(*) AS yes FROM survey WHERE answer=1";
$sql2 = "SELECT COUNT(*) AS total FROM survey";
$result = mysql_query($sql);
$yes = mysql_fetch_assoc($result);
$yes = $yes['yes'];
$resultt = mysql_query($sql2);
$all = mysql_fetch_assoc($resultt);
$all = $all['total'];
$yes = ($yes/$all)*100;
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
  <meta http-equiv="refresh" content="3; url=http://incnet.tevitol.org/" />
 <!-- Modal Structure -->
   <div id="modal1" class="modal">
     <div class="modal-content">
       <h4>Evet : <? echo $yes; ?>%</h4>
       <div class="progress">
         <div class="determinate" style="width: <? echo $yes; ?>%"></div>
       </div>

        <h4>Hayır : <? echo 100-$yes; ?>%</h4>
        <div class="progress">
          <div class="determinate" style="width: <? echo 100-$yes; ?>%"></div>
        </div>
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

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>

<?php

echo 'Current PHP version: ' . phpversion() . '<br><br>';
     
require_once "../class/init.class.php";
$init = new init;
$dbase = new dbase;
                         
error_reporting(E_ALL);	
//HEADER('Content-Type:application/json;charset=utf8');
$userInfo = array();
$userList = array();
$users_query = 'SELECT username, name, lastname FROM coreusers WHERE class != "old"';
$users_array = array();

$getUsers = $dbase -> query($users_query, $users_array);

foreach($getUsers as $user){

$userInfo['character'] = $user['username'];
$userInfo['name'] = $user['name'] . ' ' . $user['lastname'];

echo $user['username'] . '  ' . $user['name'] . ' ' . $user['lastname'] . '------------';

array_push($userList, $userInfo);

}

echo '<br><br><br><hr><br><br><br>' . 'JSON' . '<br><br><br><hr><br><br><br>';

$encoded = json_encode($userList) . ';';


$unescaped = preg_replace_callback('/\\\u(\w{4})/', function ($matches) {
    return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
}, $encoded);
var_dump($unescaped);
?>
</body>
</html>
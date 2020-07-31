<html>
<body>
<?php
    /*	require_once '../class/init.class.php';
	
	$init = new init(true);
error_reporting(E_ALL);	
	$id = $_SESSION['user_id'];
  $user = new profileBuilder($id, 'Murat Kaan Meral');
  	$userInf = new user;
	  $user_info = $userInf -> user_info($_SESSION["user_id"]);
    $db_connect = new dbase;
    
    $stmt = 'SELECT tckn, name, lastname FROM profilesmain';
    $array = array();
		$checkTCKN_Results = $db_connect -> query($stmt, $array);

		foreach($checkTCKN_Results as $checkTCKNQuery){
		
			$tckn = $checkTCKNQuery['tckn'];
      
      
  if(($tckn[0] == 0)||(($tckn[10]%2)==1)||(!(((((($tckn[0]+$tckn[2]+$tckn[4]+$tckn[6]+$tckn[8])*7)-($tckn[1]+$tckn[3]+$tckn[5]+$tckn[7]))%10)==$tckn[9])&&((($tckn[0]+$tckn[1]+$tckn[2]+$tckn[3]+$tckn[4]+$tckn[5]+$tckn[6]+$tckn[7]+$tckn[8]+$tckn[9])%10)==$tckn[10])))){
    echo $checkTCKNQuery['name'] . ' ' . $checkTCKNQuery['lastname'] . '    -    ' . $checkTCKNQuery['tckn'];
  }else{
  } 
		}
    
    
    
    
    
    
      
    
$tckn = '41092244736';
  if(($tckn[0] == 0)||(($tckn[10]%2)==1)||(!(((((($tckn[0]+$tckn[2]+$tckn[4]+$tckn[6]+$tckn[8])*7)-($tckn[1]+$tckn[3]+$tckn[5]+$tckn[7]))%10)==$tckn[9])&&((($tckn[0]+$tckn[1]+$tckn[2]+$tckn[3]+$tckn[4]+$tckn[5]+$tckn[6]+$tckn[7]+$tckn[8]+$tckn[9])%10)==$tckn[10])))){
    echo 'yanlş biliyon zaaaa xDé';
  }else{
    echo 'helal kerata senden adam olur .s .s';
  } */
 if(isset($_POST['b'])){               
    echo $_POST['cb'];
 } 
  
?>

<form method="POST">
    <input type="checkbox" name="cb" value ="anan" checked />
    <input type="submit" name="b" value="click">
</form>

</body>
</html>
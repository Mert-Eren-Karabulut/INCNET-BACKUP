<?


?>
<!DOCTYPE html>    
<html>
<head>                                 
  <meta charset="UTF-8">   	
  <link rel='stylesheet' type='text/css' href='../css/header.css'>           
  <link rel='stylesheet' type='text/css' href='../css/input.css'>
</head>
  <body>
 <?   
	require_once '../class/init.class.php';
	
	$init = new init(true);
error_reporting(E_ALL);	
	$id = $_SESSION['user_id'];
  	$userInf = new user;
	  $user_info = $userInf -> user_info($_SESSION["user_id"]);
    $dbase = new dbase;
    
	foreach ($user_info as $info)
	{
		$name = $info["name"] . " " . $info["lastname"];
	}   
/* get permissions and set more dropown */
$more = array("Pool Reservations" => "../pool/index.php", "Movie Library" => "../movie/index.php");
$dbase = new dbase;
$stmt = "SELECT page_id FROM corepermits WHERE user_id = :id";
$array = array(":id" => $id);
$permissions = $dbase -> query($stmt, $array);
foreach ($permissions as $userInf)
{
	$permits[] = $userInf["page_id"];
}
if (in_array("101", $permits)||in_array("102", $permits)||in_array("103", $permits)||in_array("901", $permits)||in_array("902", $permits)||in_array("903", $permits)||in_array("904", $permits))
{
	/* more with admin tools */
	$more["Admin Tools"] = "admintools.php";
}
if (in_array("901", $permits))
{
	/* student profiles */
	$more["Edit Student Profiles"] = "../profileBuilder/admin/fullProfile.php";
}
if (in_array("902", $permits))
{
	/* contact and social security */
	$more["Student Contact and Social Security Information"] = "../profileBuilder/admin/emergencySearch.php";
}
if (in_array("903", $permits))
{
	/* devices */
	$more["Student Device Information"] = "../profileBuilder/admin/deviceInfo.php";
}
if (in_array("904", $permits))
{
	/* summer camps */
	$more["Student Summer Camps Information"] = "../profileBuilder/admin/summerInfo.php";
}
if (in_array("150", $permits))
{
	/* webCam */
	$more["webCam"] = "../webCam/take.php";
}
if (in_array("160", $permits))
{
	/* Hiring */
	$more["Hiring Applications"] = "hiringadmin.php";
}
if (in_array("501", $permits))
{
	/* tevitolkayit */
	$more["tevitolkayıt"] = "../tevitolkayit/admin/index.php";
}
$navdiv = "
<div class='linkWord left more' id='moreLink' style='border-right:0px;'>
	<span>
		More
	</span>
	<img src='../img/header-drop.png' alt='drop' class='dropimg'>
	<div class='dropMenu more' id='moreMenu'>";
foreach ($more as $link => $href)
{
	$navdiv .= "
		<a href='$href' class='dropWord left'>
			$link
		</a><br>";
}
$navdiv .= "
	</div>
</div>";
      ?>   	
    <header>		
      <nav>			
        <a href='#' class='linkPicture left'>				
          <img src='../img/incnetWhite.png' alt='incnetWhite' id='headerLogo'>			</a>			
        <a href='../checkin2/index.php' class='linkWord left' id='checkinLink'>				Checkin 			</a>			
        <a href='../weekend/index.php' class='linkWord left' id='weekendLink'>				Weekend Departures 			</a>			
        <a href='../etut/index.php' class='linkWord left' id='etutLink'>				Etut Reservations 			</a>			
<?php
			
				echo $navdiv;
				
        			?>			
        <div href='#' class='linkWord right personal' id='personalLink' style='border-right:0px;'>				
          <span id='name'>					
<?php
			
					echo $name;
			
            					?>				
          </span>				
          <img src='../img/header-drop.png' alt='drop' class='dropimg'>				
          <div class='dropMenu personal' id='personalMenu'>					
            <a href='../incnet/changepass.php' class='dropWord right' id='settingLink'>						Change Password 					</a>					
            <br>					
            <a href='../incnet/hiring.php' class='dropWord right' id='hiringLink'>						Apply to INÇNET 					</a>					
            <br>					
            <a href='../incnet/about13.php' class='dropWord right' id='aboutLink'>						About Us 					</a>					
            <br>					
            <a href='../incnet/logoff.php' class='dropWord right' id='logoffLink'>						Sign Out 					</a>					
            <br>				
          </div>			
        </div>		
      </nav>	
    </header>  
    <div id="content" style="box-sizing:border-box;padding:60px 100px 10px;background-color:rgba(181, 158, 159, 0.5);width:60%;height:100%;margin-left:auto;margin-right:auto;padding-top:5%;padding-left:2%;padding-right:2%;font-size:14pt;" ng-app="myApp">
      <div ng-controllers="profileEditCtrl">
         
         <table>
            <tr ng-repeat="user in profileedit.cast">
                <td> {{user.name}} </td>           
                <td> {{user.character}} </td>
            </tr>
         </table>
         
         
             
    
    
        </div>
    </div>  

  <body>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
  <script type="text/javascript" src="profileEdit.js"></script>
	<script type="text/javascript" src='../plugins/jquery.intent.js'></script>
</html>

















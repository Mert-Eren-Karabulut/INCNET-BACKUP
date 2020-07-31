<?
    require_once '../class/init.class.php';
	
	$init = new init(true);
       // error_reporting(E_ALL);	
	$id = $_SESSION['user_id'];
  $user = new profileBuilder($id, 'Murat Kaan Meral');
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
if(!(in_array("901", $permits)||in_array("902", $permits)||in_array("903", $permits)||in_array("904", $permits)))
{
    header("location:index.php");
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

//Get Info ...
$user -> getStudentInfo();
$user -> getRelativeInfo();
$user -> getDeviceInfo();
$user -> getSummerCamp();


//update everything
  if(isset($_POST['save'])){
  if(!($user -> checkTCKN($_POST['sttckn']))){
    $userTckn = $user -> userInfo[0];
    echo '<script>alert("ID is not correct!\nPlease check it again.")</script>';
  }
  else{
    $userTckn = $_POST['sttckn'];
  }

    // Update student Information ...  
  	  
  
                                                                                            
/*            case 1:$postCheckbox = $_POST['stmomabio'];
            case 2:$postCheckbox = $_POST['stdadbio'];
            case 3:$postCheckbox = $_POST['stmomalive'];
            case 4:$postCheckbox = $_POST['stdadalive'];
            case 5:$postCheckbox = $_POST['stparent'];
  */  
    $updateStudent_query = 'UPDATE profilesmain SET tckn= :tckn, class= :class, address = :address, semt= :semt, ilce= :ilce, il= :il, zipcode= :zipcode, homePhone = :hp, cellPhone= :cp, email= :email, socialSecurity= :socsec, parentsUnity= :parunit, motherBio= :momb, fatherBio= :dadb, motherLive= :momlive, fatherLive= :dadlive, parent= :parent  WHERE registerId= :registerId';
		$updateStudent_queryArray = array(':registerId' => $user -> registerId ,    ':tckn'=> $userTckn ,           ':class'=> $_POST['stclass'] ,
                                          ':address'=> $_POST['stadress'] ,      ':semt'=> $_POST['stsemt'] ,           ':ilce'=> $_POST['stilce'] ,
                                          ':il'=> $_POST['stil'] ,               ':zipcode' => $_POST['stzipcode'] ,    ':hp'=> $_POST['sthomephone'] ,
                                          ':cp'=> $_POST['stcellphone'] ,        ':email'=> $_POST['stemail'] ,         ':socsec'=> $_POST['stsocsec'] ,
                                          ':parunit'=> $_POST['stparunity'] ,    ':momb'=> $_POST['stmomabio'] ,        ':dadb'=> $_POST['stdadbio'] ,
                                          ':momlive'=> $_POST['stmomalive'] ,    ':dadlive'=> $_POST['stdadalive'] ,    ':parent'=> $_POST['stparent']);
                                          
    if(($dbase -> queryUpdate($updateStudent_query, $updateStudent_queryArray))>0){
    
        $updateString = ' Student is updated ';
    
    }else{
    
        $updateString = 'Student is NOT updated ' . '\n\n\n' . $_POST['stmomabio'] . '\n\n\n';
       
    }
    
                                                           
    //echo '<script>alert("' . $updateString . '")</script>';
                  
    // Update mother Information ...  
      
        //check if birth date is earlier than 20 years ago...
      if($_POST['momdob'] < date('Y-m-d', mktime(0, 0, 0, date("m") , date("d"), date("Y") - 20))){
          
          $momdob = $_POST['momdob'];
    
      }else{
          
          $momdob = $user -> motherInfo[2];
          echo '<script>alert("You\'ve entered wrong birth date for mother.\nPlease, check it.")</script>';
          
      }
  	                                                                                        
		$updateMother_query = 'UPDATE profilesmotherinfo SET name= :name, fax= :fax, lastname= :lastname, tckn= :tckn, DOB= :dob, address = :address, semt= :semt, ilce= :ilce, il= :il, zipcode= :zipcode, homePhone = :hp, cellPhone= :cp, email= :email, socialSecurity= :socsec,  profession= :prof, work= :work, company= :comp, workAddress= :workaddress, workCity= :workcity, workPhone= :wp WHERE registerId= :registerId';
		$updateMother_array = array(':registerId' => $user -> registerId ,                  ':tckn'=> $_POST['momtckn'] ,           ':dob'=> $momdob ,
                                              ':address'=> $_POST['momadress'] ,            ':semt'=> $_POST['momsemt'] ,           ':ilce'=> $_POST['momilce'] ,
                                              ':il'=> $_POST['momil'] ,                     ':zipcode' => $_POST['momzipcode'] ,    ':hp'=> $_POST['momhomephone'] ,
                                              ':cp'=> $_POST['momcellphone'] ,              ':email'=> $_POST['momemail'] ,         ':socsec'=> $_POST['momsocsec'] ,
                                              ':prof'=> $_POST['momprofession'] ,           ':work'=> $_POST['momwork'] ,           ':comp'=> $_POST['momworkplace'] ,
                                              ':workaddress'=> $_POST['momworkadress'] ,    ':workcity'=> $_POST['momworkcity'] ,   ':wp'=> $_POST['momworkphone'], 
                                              ':fax'=> $_POST['momfax'],                    ':name' => $_POST['momname'],           ':lastname' => $_POST['momlastname']);

                                          

     if(($dbase -> queryUpdate($updateMother_query, $updateMother_array))>0){
        $updateString = $updateString . '\nMother Updated!';
     }else{
        $updateString = $updateString . '\nMother did Not Updated!';
     }
    
    
    //echo '<script>alert("' . $user -> registerId . ' ' . $_POST['momtckn'] . ' ' . $_POST['momdob'] . ' ' . $_POST['momadress'] . ' ' . $_POST['momsemt'] . ' ' . $_POST['momilce'] . ' ' . $_POST['momil'] . ' ' . $_POST['momzipcode'] . ' ' . $_POST['momhomephone']  . ' ' . $_POST['momcellphone'] . ' ' . $_POST['momemail'] . ' ' . $_POST['momsocsec'] . ' ' . $_POST['momprofession'] . ' ' . $_POST['momwork'] . ' ' . $_POST['momworkplace'] . ' ' . $_POST['momworkadress'] . ' ' . $_POST['momworkcity'] . ' ' . $_POST['momworkphone'] . ' ' . $_POST['momfax'] . ' ' . $_POST['momname'] . ' ' . $_POST['momlastname'] . '")</script>';
     
                                                                           
                  
    // Update father Information ...  
  	  
        //check if birth date is earlier than 20 years ago...
      if($_POST['daddob'] < date('Y-m-d', mktime(0, 0, 0, date("m") , date("d"), date("Y") - 20))){
          
          $daddob = $_POST['daddob'];
    
      }else{
          
          $daddob = $user -> fatherInfo[2];
          echo '<script>alert("You\'ve entered wrong birth date for father.\nPlease, check it.")</script>';
          
      } 
      
      
		$updateFather_query = 'UPDATE profilesfatherinfo SET name= :name, lastname= :lastname, tckn= :tckn, DOB= :dob, address = :address, semt= :semt, ilce= :ilce, il= :il, zipcode= :zipcode, homePhone = :hp, cellPhone= :cp, email= :email, socialSecurity= :socsec, profession= :prof, fax= :fax, work= :work, company= :comp, workAddress= :workaddress, workCity= :workcity, workPhone= :wp WHERE registerId= :registerId';
		$updateFather_array = array(':registerId' => $user -> registerId ,                  ':tckn'=> $_POST['dadtckn'] ,           ':dob'=> $daddob ,
                                              ':address'=> $_POST['dadadress'] ,            ':semt'=> $_POST['dadsemt'] ,           ':ilce'=> $_POST['dadilce'] ,
                                              ':il'=> $_POST['dadil'] ,                     ':zipcode' => $_POST['dadzipcode'] ,    ':hp'=> $_POST['dadhomephone'] ,
                                              ':cp'=> $_POST['dadcellphone'] ,              ':email'=> $_POST['dademail'] ,         ':socsec'=> $_POST['dadsocsec'] ,
                                              ':prof'=> $_POST['dadprofession'] ,           ':work'=> $_POST['dadwork'] ,           ':comp'=> $_POST['dadworkplace'] ,
                                              ':workaddress'=> $_POST['dadworkadress'] ,    ':workcity'=> $_POST['dadcity'] ,       ':wp'=> $_POST['dadworkphone'] ,      
                                              ':fax'=> $_POST['dadfax'],                    ':name'=> $_POST['dadname'],            ':lastname'=> $_POST['dadlastname']);
                          
    //echo '<script>alert("' . $user -> registerId . ' ' . $_POST['dadtckn'] . ' ' . $_POST['daddob'] . ' ' . $_POST['dadadress'] . ' ' . $_POST['dadsemt'] . ' ' . $_POST['dadilce'] . ' ' . $_POST['dadil'] . ' ' . $_POST['dadzipcode'] . ' ' . $_POST['dadhomephone'] . ' ' . $_POST['dadcellphone'] . ' ' . $_POST['dademail'] . ' ' . $_POST['dadsocsec'] . ' ' . $_POST['dadprofession'] . ' ' . $_POST['dadwork'] . ' ' . $_POST['dadworkplace'] . ' ' . $_POST['dadworkadress'] . ' ' . $_POST['dadcity'] . ' ' . $_POST['dadworkphone'] . ' ' . $_POST['dadfax'] . ' ' . $_POST['dadname'] . ' ' . $_POST['dadlastname'] . '")</script>';
                          
    if(($dbase -> queryUpdate($updateFather_query, $updateFather_array))>0){
    
        $updateString = $updateString . '\nFather Updated!';    
    
    }else{
    
        $updateString = $updateString . '\nFather NOT Updated!';
    
    }                          
                         
    //echo '<script>alert("' . $updateString . '")</script>';                                                   
                                                                
    // Update Relative Information ...                             
                                       
     for($rel = 1; $rel <= $relno; $rel++){  
     
     $relId = $user -> relativeInfo[(($rel*15)-1)];    
     
     
                                       
    $updateRelative_query = 'UPDATE profilesrelatives SET name= :name, lastname= :lastname, relation= :relation, address= :address, semt= :semt, ilce= :ilce, il= :il, zipcode= :zipcode, homePhone= :hp, cellPhone= :cp, workPhone= :wp, fax= :fax, email= :email, profession= :pro  WHERE registerId= :registerId AND relativeId= :relativeId';
		$updateRelative_array = array(':registerId' => $user -> registerId ,            ':relativeId' => $relId , 
                                          ':name' => $_POST[$rel . 'relname'],              ':lastname' => $_POST[$rel . 'rellastname'],    ':relation' => $_POST[$rel . 'relrelation'],
                                           ':address' => $_POST[$rel . 'reladress'],        ':semt' => $_POST[$rel . 'relsemt'],            ':ilce' => $_POST[$rel . 'relilce'],
                                            ':il' => $_POST[$rel . 'relil'],                ':zipcode' => $_POST[$rel . 'relzipcode'],      ':hp' => $_POST[$rel . 'relhomephone'],
                                             ':cp' => $_POST[$rel . 'relcellphone'],        ':wp' => $_POST[$rel . 'relworkphone'],         ':fax' => $_POST[$rel . 'relfax'],
                                              ':email' => $_POST[$rel . 'relemail'],        ':pro' => $_POST[$rel . 'relprofession']);
    
    //$updateString = $updateString . '\n' . $relId . ' ' . $_POST[$rel . 'relname'] . ' ' . $_POST[$rel . 'rellastname'] . ' ' . $_POST[$rel . 'relrelation'] . ' ' . $_POST[$rel . 'reladress'] . ' ' . $_POST[$rel . 'relsemt'] . ' ' . $_POST[$rel . 'relilce'] . ' ' . $_POST[$rel . 'relil'] . ' ' . $_POST[$rel . 'relzipcode'] . ' ' . $_POST[$rel . 'relhomephone'] . ' ' . $_POST[$rel . 'relcellphone'] . ' ' . $_POST[$rel . 'relworkphone'] . ' ' . $_POST[$rel . 'relfax'] . ' ' . $_POST[$rel . 'relemail'] . ' ' . $_POST[$rel . 'relprofession'] . '\n\n';
                           
                          
    if(($dbase -> queryUpdate($updateRelative_query, $updateRelative_array))>0){
    
        $updateString = $updateString . '\nRelative ' . $rel . ' Updated!';    
    
    }else{
    
        $updateString = $updateString . '\nRelative ' . $rel . ' NOT Updated!';
    
    }    
    
    }                                                                
          
   
    // Update Device Information ...                             
                                       
     for($dev = 1; $dev <= $devno; $dev++){  
         
         $devId = $user -> deviceInfo[(($dev*5)-1)];    
         
         if($_POST[$dev . 'devaddate']> date('Y-m-d', mktime(0, 0, 0, date("m") , date("d"), date("Y")))){
             
             $devAddate = $user -> deviceInfo[0];
         }else{
             
             $devAddate = $_POST[$dev . 'devaddate'];
         }
            
         
         
         
                                           
       $updateDevice_query = 'UPDATE profilesdevices SET registerDate = :rd, type= :type, make= :make, identifier= :id  WHERE registerId= :registerId AND deviceId= :deviceId';
    	 $updateDevice_array = array(':registerId' => $user -> registerId ,            ':deviceId' => $devId , 
                                    ':rd' => $_POST[$dev . 'devadddate'],              ':type' => $_POST[$dev . 'devtype'],
                                    ':make' => $_POST[$dev . 'devmake'],              ':id' => $_POST[$dev . 'devidentifier'],);
        
                              
                              
                              
        if(($dbase -> queryUpdate($updateDevice_query, $updateDevice_array))>0){
        
            $updateString = $updateString . '\nDevice ' . $dev . ' Updated!' . '\n' . $_POST[$dev . 'devaddate'] . ' ' . $_POST[$dev . 'devtype'] . ' ' . $_POST[$dev . 'devmake'] . ' ' . $_POST[$dev . 'devidentifier'];    
        
        }else{
        
            $updateString = $updateString . '\nDevice ' . $dev . ' NOT Updated!' . '\n' . $_POST[$dev . 'devaddate'] . ' ' . $_POST[$dev . 'devtype'] . ' ' . $_POST[$dev . 'devmake'] . ' ' . $_POST[$dev . 'devidentifier'];
        
        }    
             
       
      }                                                                  
          
   
    // Update Summer Camps Information ...                             
                                       
     for($camp = 1; $camp <= $campno; $camp++){  
         
         $campId = $user -> summerCamp[(($camp*6)-1)]; 
         
         if($_POST[$camp . 'campadddate']>date('Y-m-d', mktime(0, 0, 0, date("m") , date("d"), date("Y") - 20))){
             
             $campAdd = $user -> summerCamp[4];
             
         }else{
             
             $campAdd = $_POST[$camp . 'campadddate'];
         }
         
         
                                           
       $updateCamp_query = 'UPDATE profilessummercamps SET registerId = :rid, institution = :inst, program = :pr, country = :cnt, city = :ct, dateAdded = :da WHERE registerId= :rid AND campId= :cid';
    	 $updateCamp_array = array(':rid' => $user -> registerId ,            ':cid' => $campId , 
                                    ':inst' => $_POST[$camp . 'campinstitution'],              ':pr' => $_POST[$camp . 'campprogram'],
                                    ':cnt' => $_POST[$camp . 'campcountry'],              ':ct' => $_POST[$camp . 'campcity'],
                                    ':da' => $_POST[$camp . 'campadddate']);
                                                     
                              
        if(($dbase -> queryUpdate($updateCamp_query, $updateCamp_array))>0){
        
            $updateString = $updateString . '\nCamp ' . $camp . ' Updated!' . '\n' . $_POST[$camp . 'campinstitution'] . ' ' . $_POST[$camp . 'campprogram'] . ' ' . $_POST[$camp . 'campcountry'] . ' ' . $_POST[$camp . 'campcity'] . ' ' . $_POST[$camp . 'campadddate'];    
        
        }else{
        
            $updateString = $updateString . '\nCamp ' . $camp . ' NOT Updated!' . '\n' . $_POST[$camp . 'campinstitution'] . ' ' . $_POST[$camp . 'campprogram'] . ' ' . $_POST[$camp . 'campcountry'] . ' ' . $_POST[$camp . 'campcity'] . ' ' . $_POST[$camp . 'campadddate'] ;
        
        }    
             
       
      }
                         
    echo '<script>alert("' . $updateString . '")</script>';     
}     

?>
<!DOCTYPE html>
<html>  
    <head>  
        <meta charset="UTF-8">   	
        <link rel='stylesheet' type='text/css' href='../css/header.css'>           
        <link rel='stylesheet' type='text/css' href='../css/input.css'>
        <title>INCNET</title>
    </head>

    <body>
    <style>input {   padding:0px 10px;   width:250px;   font-size:2pt;   text-align:rigth;   float:right;   margin-top:-8px;   }.check{   margin-top:0px; } 
    </style>  	
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
    <div id="content" style="box-sizing:border-box;padding:60px 100px 10px;background-color:rgba(181, 158, 159, 0.5);width:60%;height:100%;margin-left:auto;margin-right:auto;padding-top:5%;padding-left:2%;padding-right:2%;font-size:14pt;">  
      <form method="POST">	      
<?
	//getting user info  
  echo'<table border="0" style="width:100%;">';
	for($x = 0; $x<17; $x++){
  echo'<tr>';
  switch($x){
      case 0: echo '<td>TC Kimlik No ';             $inf = 'sttckn';                        $type = 'number';      $checkbox = '';             break;
      case 1: echo '<td>Sinif';                     $inf = 'stclass';                       $type = 'text';        $checkbox = '';             break;
      case 2: echo '<td>Adres';                     $inf = 'stadress';                      $type = 'text';        $checkbox = '';             break;
      case 3: echo '<td>Semt ';                     $inf = 'stsemt';                        $type = 'text';        $checkbox = '';             break;
      case 4: echo '<td>Ilce ';                     $inf = 'stilce';                        $type = 'text';        $checkbox = '';             break;
      case 5: echo '<td>Il ';                       $inf = 'stil';                          $type = 'text';        $checkbox = '';             break;
      case 6: echo '<td>Zipcode ';                  $inf = 'stzipcode';                     $type = 'number';      $checkbox = '';             break;
      case 7: echo '<td>Ev Telefonu';               $inf = 'sthomephone';                   $type = 'number';      $checkbox = '';             break;
      case 8: echo '<td>Cep Telefonu';              $inf = 'stcellphone';                   $type = 'number';      $checkbox = '';             break;
      case 9: echo '<td>Email ';                    $inf = 'stemail';                       $type = 'email';       $checkbox = '';             break;
      case 10: echo '<td>Sosyal Guvenlik Kurumu';   $inf = 'stsocsec';                      $type = 'text';        $checkbox = '';             break; 
      case 11: echo '<td>Kanuni velisi';            $inf = 'stparent';                      $type = 'text';        $checkbox = '';             break;
      case 12: echo '<td>Anne-Baba Beraber ';       $inf = 'stparunity';                    $type = 'checkbox';    $checkbox = 'checked';      break;
      case 13: echo '<td>Oz anne';                  $inf = 'stmomabio';                     $type = 'checkbox';    $checkbox = 'checked';      break;
      case 14: echo '<td>Oz baba';                  $inf = 'stdadbio';                      $type = 'checkbox';    $checkbox = 'checked';      break;
      case 15: echo '<td>Anne Hayatta';             $inf = 'stmomalive';                    $type = 'checkbox';    $checkbox = 'checked';      break;
      case 16: echo '<td>Baba Hayatta';             $inf = 'stdadalive';                    $type = 'checkbox';    $checkbox = 'checked';      break;
  }
		
		//echo $user -> userInfo[$x] . '<br>';
    
		echo  '<input type="' . $type . '" name="' . $inf . '" value="' . $user -> userInfo[$x] . '"  ' . $checkbox . '><hr></td>';
    
    echo'</tr>';   
	}          
  echo '</table>';
	
	echo '<br><br><br><br><br><br>';

echo'<table border="0" style="width:100%;">';
	//get Mother Info
	for($x = 0; $x<19; $x++){
  
        echo '<tr>';      
  
        switch($x){
            
              case 0: echo '<td>Adi:';                      $mominf = 'momname';            $type = 'text';         break;  
              case 1: echo '<td>Soyadi:';                   $mominf = 'momlastname';        $type = 'text';         break;
              case 2: echo '<td>Dogum Tarihi';              $mominf = 'momdob';             $type = 'date';         break;
              case 3: echo '<td>TC Kimlik Numarasi';        $mominf = 'momtckn';            $type = 'number';       break;
              case 4: echo '<td>Adres';                     $mominf = 'momadress';          $type = 'text';         break;
              case 5: echo '<td>Semt';                      $mominf = 'momsemt';            $type = 'text';         break;
              case 6: echo '<td>Ilce';                      $mominf = 'momilce';            $type = 'text';         break;
              case 7: echo '<td>Il';                        $mominf = 'momil';              $type = 'text';         break;
              case 8: echo '<td>Zipcode';                   $mominf = 'momzipcode';         $type = 'number';       break;
              case 9: echo '<td>Ev Telefonu';               $mominf = 'momhomephone';       $type = 'number';       break;
              case 10: echo '<td>Cep Telefonu';             $mominf = 'momcellphone';       $type = 'number';       break;
              case 11: echo '<td>Fax';                      $mominf = 'momfax';             $type = 'number';       break;
              case 12: echo '<td>Email';                    $mominf = 'momemail';           $type = 'email';        break;
              case 13: echo '<td>Sosyal Guvenlik Kurumu';   $mominf = 'momsocsec';          $type = 'text';         break;
              case 14: echo '<td>Meslek';                   $mominf = 'momprofession';      $type = 'text';         break;
              case 15: echo '<td>Calisma Durumu ';          $mominf = 'momwork';            $type = 'text';         break;
              case 16: echo '<td>Is Yeri  ';                $mominf = 'momworkplace';       $type = 'text';         break;
              case 17: echo '<td>Is Adresi  ';              $mominf = 'momworkadress';      $type = 'text';         break;
              case 18: echo '<td>Calistigi Sehir  ';        $mominf = 'momworkcity';        $type = 'text';         break;
              case 19: echo '<td>Is Telefonu  ';            $mominf = 'momworkphone';       $type = 'number';       break;

  }
		echo '<input type="' . $type . '" name="' . $mominf . '" value="' . $user -> motherInfo[$x] . '"><hr></td></tr>';
	}
  echo '</table>';
	echo '<br><br><br><br><br><br>';
	//get Father Info
  echo'<table border="0" style="width:100%;">';
	for($x = 0; $x<19; $x++){
   echo '<tr>';
		                                
  switch($x){
      case 0: echo '<td>Adi';                       $dadinf = 'dadname';            $type = 'text';         break;  
      case 1: echo '<td>Soyadi';                    $dadinf = 'dadlastname';        $type = 'text';         break;
      case 2: echo '<td>Dogum Tarihi';              $dadinf = 'daddob';             $type = 'date';         break;
      case 3: echo '<td>TC Kimlik Numarasi';        $dadinf = 'dadtckn';            $type = 'number';       break;
      case 4: echo '<td>Adres';                     $dadinf = 'dadadress';          $type = 'text';         break;
      case 5: echo '<td>Semt';                      $dadinf = 'dadsemt';            $type = 'text';         break;
      case 6: echo '<td>Ilce';                      $dadinf = 'dadilce';            $type = 'text';         break;
      case 7: echo '<td>Il';                        $dadinf = 'dadil';              $type = 'text';         break;
      case 8: echo '<td>Zipcode';                   $dadinf = 'dadzipcode';         $type = 'number';       break;
      case 9: echo '<td>Ev Telefonu';               $dadinf = 'dadhomephone';       $type = 'number';       break;
      case 10: echo '<td>Cep Telefonu';             $dadinf = 'dadcellphone';       $type = 'number';       break;
      case 11: echo '<td>Fax';                      $dadinf = 'dadfax';             $type = 'number';       break;
      case 12: echo '<td>Email';                    $dadinf = 'dademail';           $type = 'email';        break;
      case 13: echo '<td>Sosyal Guvenlik Kurumu';   $dadinf = 'dadsocsec';          $type = 'text';         break;
      case 14: echo '<td>Meslek';                   $dadinf = 'dadprofession';      $type = 'text';         break;
      case 15: echo '<td>Calisma Durumu ';          $dadinf = 'dadwork';            $type = 'text';         break;
      case 16: echo '<td>Is Yeri';                  $dadinf = 'dadworkplace';       $type = 'text';         break;
      case 17: echo '<td>Is Adresi';                $dadinf = 'dadworkadress';      $type = 'text';         break;
      case 18: echo '<td>Calistigi Sehir';          $dadinf = 'dadcity';            $type = 'text';         break;
      case 19: echo '<td>Is Telefonu';              $dadinf = 'dadworkphone';       $type = 'text';         break;
      
  }
		
		echo '<input type="' . $type . '" name="' . $dadinf . '" value="' . $user -> fatherInfo[$x] . '"><hr></td></tr>';
	}                
  echo '</table>';                    
	echo '<br><br><br><br><br><br>';
	//get Relative Info                            
  echo'<table border="0" style="width:100%;">';
	for($x = 0; $x<sizeof($user -> relativeInfo); $x++){
  if($x == 0){ 
  $relno = 1;
  }                                               
                                                       
		if((($x % 15) == 0)&&($x != 0)){
			echo '</table><br><br><table border="0" style="width:100%;">';	
      $relno++;
		}
  switch(($x % 15)){
      case 0: echo '<td>Adi';               $relinf = $relno . 'relname';           $type = 'text';         break; 
      case 1: echo '<td>Soyadi';            $relinf = $relno . 'rellastname';       $type = 'text';         break;
      case 2: echo '<td>Yakinlik';          $relinf = $relno . 'relrelation';       $type = 'text';         break;
      case 3: echo '<td>Adres';             $relinf = $relno . 'reladress';         $type = 'text';         break;
      case 4: echo '<td>Semt';              $relinf = $relno . 'relsemt';           $type = 'text';         break;
      case 5: echo '<td>Ilce';              $relinf = $relno . 'relilce';           $type = 'text';         break;
      case 6: echo '<td>Il';                $relinf = $relno . 'relil';             $type = 'text';         break;
      case 7: echo '<td>Zipcode';           $relinf = $relno . 'relzipcode';        $type = 'number';       break;
      case 8: echo '<td>Ev Telefonu';       $relinf = $relno . 'relhomephone';      $type = 'number';       break;
      case 9: echo '<td>Cep Telefonu';      $relinf = $relno . 'relcellphone';      $type = 'number';       break;
      case 10: echo '<td>Fax';              $relinf = $relno . 'relfax';            $type = 'number';       break;
      case 11: echo '<td>Email';            $relinf = $relno . 'relemail';          $type = 'email';        break;
      case 12: echo '<td>Meslek';           $relinf = $relno . 'relprofession';     $type = 'text';         break;
      case 13: echo '<td>Is Telefonu';      $relinf = $relno . 'relworkphone';      $type = 'number';       break;
  }
   if(!(($x % 15) == 14)){ 
	     	echo '<input type="' . $type . '" name="' . $relinf . '" value="' . $user -> relativeInfo[$x] . '"><hr></td></tr>';
   }
	}
  echo '</table>';
	echo '<br><br><br><br><br><br>';

//get Device Info
  echo'<table border="0" style="width:100%;">';
	for($x = 0; $x<sizeof($user -> deviceInfo); $x++){    
  if($x == 0){ $devno = 1; }                  
		if((($x % 5) == 0)&&($x != 0)){
			echo '</table><br><br><table border="0" style="width:100%;">';
      $devno ++;	
		}
		                    
  switch(($x % 5)){
      case 0: echo '<td>Kayit Tarihi';      $devinf = $devno . 'devadddate';        $type = 'date';     break;
      case 1: echo '<td>Tipi';              $devinf = $devno . 'devtype';           $type = 'text';     break;
      case 2: echo '<td>Modeli';            $devinf = $devno . 'devmake';           $type = 'text';     break;
      case 3: echo '<td>MAC Adresi';        $devinf = $devno . 'devidentifier';     $type = 'text';     break;
  }
    if(!(($x % 5) == 4)){
		echo '<input type="' . $type . '" name="' . $devinf . '" value="' . $user -> deviceInfo[$x] . '"><hr></td></tr>';
	}                      }
  echo '</table>';
	echo '<br><br><br><br><br><br>';

	//get Summer Camp Info  
  echo'<table border="0" style="width:100%;">';
	for($x = 0; $x<sizeof($user -> summerCamp); $x++){
  if($x == 0){ $campno = 1; }                                               
		if((($x % 6) == 0)&&($x != 0)){
			echo '</table><br><br><table border="0" style="width:100%;">';	
		  $campno ++;
    }                                                                
  switch(($x % 6)){
      case 0: echo '<td>Kurum';                 $campinf = $campno . 'campinstitution';     $type = 'text';     break;
      case 1: echo '<td>Program Adi';           $campinf = $campno . 'campprogram';         $type = 'text';     break;
      case 2: echo '<td>Ulke';                  $campinf = $campno . 'campcountry';         $type = 'text';     break;
      case 3: echo '<td>Sehir';                 $campinf = $campno . 'campcity';            $type = 'text';     break; 
      case 4: echo '<td>Eklendiği Tarih';       $campinf = $campno . 'campadddate';         $type = 'date';     break;
  }
	if(!(($x % 6) == 5)){	
		echo '<input type="' . $type . '" name="' . $campinf . '" value="' . $user -> summerCamp[$x] . '"><hr></td></tr>';
	}                     }
  echo '</table>';
                
        ?>
        <input type="submit" value="Save" name="save">
      </form>
    </div>
  </body>
  
	<script src='../plugins/jquery.intent.js'></script>
</html>
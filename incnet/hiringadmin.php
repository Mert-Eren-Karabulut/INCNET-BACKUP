<?PHP
	error_reporting(0);

session_start();
if ((!(isset($_SESSION['user_id'])))||(!($_SESSION['user_id'])>0)){
	session_destroy;
	$newPage = "<meta http-equiv='refresh' content='0; url=login.php'>";
}

if ($_SESSION['passchange']=="must"){
	header("location:must_change_pass.php");
}

$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];
$lang = $_SESSION['lang'];

if (isset($_POST['logoff'])){
	session_destroy();
	setcookie("remember", "", time()-3600);
	//header("location:login.php");
	$newPage = "<meta http-equiv='refresh' content='0; url=login.php'>";
}

include ("db_connect.php");
$con;
if (!$con){
  die('Could not connect: ' . mysql_error());
}

$permit_query = mysql_query("SELECT * FROM incnet.corePermits WHERE user_id='$user_id'");
while($permit_row = mysql_fetch_array($permit_query)){
	$allowed_pages[] = $permit_row['page_id'];
}

$teacher_query = mysql_query("SELECT student_id FROM incnet.coreUsers WHERE user_id='$user_id'");
while($teacher_row = mysql_fetch_array($teacher_query)){
	$student_id = $teacher_row['student_id'];
}

$type_query = mysql_query("SELECT student_id, type FROM incnet.coreUsers WHERE user_id='$user_id'");
while($type_row = mysql_fetch_array($type_query)){
	$student_id = $type_row['student_id'];
	$user_type = $type_row['type'];
}

if (!(in_array("160", $allowed_pages))){
	//$newPage = "<meta http-equiv='refresh' content='0; url=index.php'>";
}
?>
<!DOCTYPE html>
<html>
  <head>
  <!--Inçnet's Head Part! -->
  <?PHP
		if ($newPage!=''){
			echo $newPage;
		}
	?>
	<title>Inçnet | Hiring!</title>
	<link rel="shortcut icon" href="favicon.ico" >
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
  <style>
		tr.red:hover
	  {
	    background-color:#c1272d;
		  color:white;
	  } 
		tr.refused:hover
	  {
  	  background-color:black;
  		color:white;
   	}
	</style>
	<style>
		#mask {
			display: none;
			background: #000;
			position: fixed;
			left: 0;
			top: 0;
			z-index: 10;
			width: 100%;
			height: 100%;
			opacity: 0.8;
			z-index: 999;
		}

		/* You can customize to your needs  */
		.login-popup {
			display: none;
			background: #c1272d;
			padding: 10px;
			border: 2px solid #ddd;
			float: left;
			font-size: 1.2em;
			position: fixed;
			top: 50%;
			left: 50%;
			z-index: 99999;
			box-shadow: 0px 0px 20px #999;
			/* CSS3 */
			-moz-box-shadow: 0px 0px 20px #999;
			/* Firefox */
			-webkit-box-shadow: 0px 0px 20px #999;
			/* Safari, Chrome */
			border-radius: 3px 3px 3px 3px;
			-moz-border-radius: 3px;
			/* Firefox */
			-webkit-border-radius: 3px;
			/* Safari, Chrome */;
		}

		img.btn_close {
			/* Position of the close button */
			float: right;
			margin: -28px -28px 0 0;
		}

		fieldset {
			border: none;
		}

		form.signin .textbox label {
			display: block;
			padding-bottom: 7px;
		}

		form.signin .textbox span {
			display: block;
		}

		form.signin p, form.signin span {
			color: #999;
			font-size: 10pt;
			line-height: 18px;
		}

		form.signin .textbox input {
			background: #666666;
			border-bottom: 1px solid #333;
			border-left: 1px solid #000;
			border-right: 1px solid #333;
			border-top: 1px solid #000;
			color: #fff;
			border-radius: 3px 3px 3px 3px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			font: 13px Arial, Helvetica, sans-serif;
			padding: 6px 6px 4px;
			width: 200px;
		}

		form.signin input:-moz-placeholder {
			color: #bbb;
			text-shadow: 0 0 2px #000;
		}

		form.signin input::-webkit-input-placeholder {
			color: #bbb;
			text-shadow: 0 0 2px #000;
		}
		
		.submitbutton {
			-webkit-border-top-left-radius:16px;
			-moz-border-radius-topleft:16px;
			border-top-left-radius:16px;
			-webkit-border-top-right-radius:16px;
			-moz-border-radius-topright:16px;
			border-top-right-radius:16px;
			-webkit-border-bottom-right-radius:16px;
			-moz-border-radius-bottomright:16px;
			border-bottom-right-radius:16px;
			-webkit-border-bottom-left-radius:16px;
			-moz-border-radius-bottomleft:16px;
			border-bottom-left-radius:16px;
			width:200px;
		}

		.button {
			background: -moz-linear-gradient(center top, #f3f3f3, #dddddd);
			background: -webkit-gradient(linear, left top, left bottom, from(#f3f3f3), to(#dddddd));
			background: -o-linear-gradient(top, #f3f3f3, #dddddd);
			filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#f3f3f3', EndColorStr='#dddddd');
			border-color: #000;
			border-width: 1px;
			border-radius: 4px 4px 4px 4px;
			-moz-border-radius: 4px;
			-webkit-border-radius: 4px;
			color: #333;
			cursor: pointer;
			display: inline-block;
			padding: 6px 6px 4px;
			margin-top: 10px;
			font: 12px;
			width: 214px;
		}

		.button:hover {
			background: #ddd;
		}

		.messagediv{
			font-size:15pt;
			color:white;
			color:#c5c5c5;
			font-weight:bold;
		}

		.moremessage{
			font-size:13pt;
			height:100px;
			width:800px;
		}
	</style> 
  <script type="text/javascript" src="jquery-1.6.4.min.js"></script>
  <script>
	  $(document).ready(function() {
			$('a.login-window').click(function() {
  
	      //Getting the variable's value from a link 
	  		var loginBox = $(this).attr('href');
	  		var cont = this.name;
	  		alert(cont);

	  		//Fade in the Popup
	  		$(loginBox).fadeIn(300);
	  
	  		//Set the center alignment padding + border see css style
	  		var popMargTop = ($(loginBox).height() + 24) / 2; 
	  		var popMargLeft = ($(loginBox).width() + 24) / 2; 
	  
	  		$(loginBox).css({ 
	      		'margin-top' : -popMargTop,
	      		'margin-left' : -popMargLeft
	  		});
	  
	  		// Add the mask to body
			  $('body').append('<div id="mask"></div>');
			  $('#mask').fadeIn(300);
	  
			  return false;
			});

			// When clicking on the button close or the mask layer the popup closed
			$('a.close, #mask').live('click', function() { 
				$('#mask , .login-popup').fadeOut(300 , function() {
  				$('#mask').remove();  
				}); 
				return false;
			});
		});
	</script>
  </head>
  <body>
  <div class="header">
		<?PHP echo $fullname; ?>
	</div>
	<br><br>
	<div class="page_logo_container">
		<table border='0' style='position:absolute; top:-2px; height:100%; left:0px'>
			<tr>
				<td style='width:140px; border-right:1px solid black; padding:7px; padding-top:15px;' valign='top'>
					<br>
					<a href='../incnet'><img src='incnet12.png' width='135px'></a>
				</td>
				<td valign='top' style='padding:7px; padding-top:15px;'>
					<br><br>
					<b style='font-size:12pt;'>Hiring: Applications & Results</b>
					<br><br>
					<table border="1">
						<tr style="border:none;">
							<td>App. ID</td>	<td>User ID</td>	<td>Name</td>
							<td>Job</td>			<td>Answer 1</td>	<td>Answer 2</td>
							<td>Answer 3</td>	<td>Extra 1</td>	<td>Extra 2</td>    
<?php
	mysql_select_db('incnet');
	$jobs = array("", "Developer", "Designer", "Celeberation Team");    
	//get information from database ...
	$hiringtable = "SELECT * FROM hiringapplications, coreUsers WHERE hiringapplications.user_id = coreUsers.user_id AND NOT EXISTS (SELECT * FROM hiringresults WHERE hiringapplications.application_id = hiringresults.application_id)";
	$applicationsquery = mysql_query($hiringtable);
	$appCount = 0;
  //write all applications using while
	while($row = mysql_fetch_array($applicationsquery)){
		$mail = $row['email'];
		$jobID = $row['job_id'];
		$job = $jobs[$jobID];
		$application_id = $row["application_id"];
    $user_id = $row["user_id"];
    $username = $row["name"] . " " . $row['lastname'];
    $ans1 = $row["ans1"];
    $ans2 = $row["ans2"];
    $ans3 = $row["ans3"];
    $extra1 = $row["extra1"];
    $extra2 = $row["extra2"];

            
		echo '<tr class="red">
              <td >&nbsp; ' . $application_id . '</td> 
              <td >&nbsp; ' . $user_id . '</td> 
              <td class="app" width="8%">' . $username . '&nbsp;  </td> 
              <td class="app" width="8%">' . $job . '&nbsp; </td> 
              <td class="app" width="13%">' . $ans1 . '&nbsp;  </td> 
              <td class="app" width="13%">' . $ans2 . '&nbsp;  </td>
              <td class="app" width="13%">' . $ans3 . '&nbsp;  </td> 
              <td class="app" width="13%">' . $extra1 . '&nbsp;  </td> 
              <td class="app" width="13%">' . $extra2 . '&nbsp;  </td> 
              <td class="app" width="3%" style="border:none;">
              	<form name="accept' . $appCount . '" method="POST"> 
		            	<input type="hidden" name="name" id="nameAc-' . $appCount . '" value="' . $username . '">
		            	<input type="hidden" name="mail" id="mailAc-' . $appCount . '" value="' . $mail . '">
		            	<a href="#login-box" class="login-window"><input type="button" id="anan" name="buttonaccept-' . $appCount . '" value="Accept" onClick="fillDiv(' . $appCount . ', 1)" class="basic"></a>
              	</form>
              </td> 
            	<td class="app" style="border:none;">
            		<form name="refuse' . $appCount . '" method="POST">
            			<input type="hidden" name="name" id="nameRe-' . $appCount . '" value="' . $username . '">
            			<input type="hidden" name="mail" id="mailRe-' . $appCount . '" value="' . $mail .'">
            			<a href="#login-box" class="login-window"><input type="button" name="buttonrefuse-' . $appCount . '" value="Refuse" onClick="fillDiv(' . $appCount . ', 0)" class="basic"></a>
            		</form>
            	</td>
						</tr>';
		$appCount++;
  }   
?>   
					</table><br><br>
<?PHP
	$refusebutton = $_POST['buttonrefuse'];
  if (isset($refusebutton)){
    $refusequery = 'INSERT INTO hiringresults VALUES ' . $row["application_id"] . ', ' . $row["user_id"] . ', 0';
    mysql_query($refusequery);
   }
?>
		      <b>Resulted Ones:</b>
		    	<table border="1"><tr>
						<td>App. ID</td>
						<td>User ID</td>
						<td>Name</td>
						<td>Job</td>
						<td>Result</td>

<?PHP
	$hiring = 'SELECT hiringresults.application_id, coreusers.user_id, coreusers.username, hiringapplications.job_id, coreusers.username, hiringresults.result FROM hiringresults, hiringapplications, coreusers WHERE hiringapplications.user_id=coreusers.user_id ORDER BY hiringresults.result DESC';
  $hiringquery =  mysql_query($hiring);
  while ($row1 = mysql_fetch_array($hiringquery)){  
		$jobID1 = $row1['job_id'];
		$job1 = $jobs[$jobID1];                        
		$result = $row1['result'];
    if($result == 1){
      echo '
    	  <tr>
        <td width="20px">&nbsp; ' . $row1["application_id"] . '</td>
        <td width="20px">&nbsp;' . $row1["user_id"] . '</td>
        <td width="30%">' . $row1["username"] . '</td>
        <td width="30%">' . $job . '</td>
        <td width="20%"><b>Accepted</b></td>
        </tr>' ;
		} else {
      echo '
        <tr class="refused">
    	  <td>&nbsp ' . $row1["application_id"] . '</td>
        <td>&nbsp ' . $row1["user_id"] . '</td>
    	  <td>' . $row1["username"] . '</td>
        <td>' . $job . '</td>
        <td><b>Refused</b></td>
        </tr>' ;
    }
  }
?>

						</tr>
					</table>
						
				<!--
				
				
				
							-------/> MAIL TEXT
							-------/> HTML CODE FROM MERAL			
							-------/> VARIABLES FOR MAIL
							-------/> MAIL USERNAME-PASSWORD				
							-------/> DEBUG		
							-------/> SQL
				
				
				-->	
			
					<script>
						function fillDiv(count, acceptance){
						
							//Acceptance Arrays
							var acceptances = new Array("Refused", "Accepted");
							var idAcceptance = new Array("Re", "Ac");
							
							//Add name
							nameID = "name" + idAcceptance[acceptance] + count;
							applicantName = getElementById(nameID).value;
							getElementbyId("messageName").value = applicantName;
							
							alert(applicantName);
							
							//Add e-mail address
							mailID = "mail" + idAcceptance[acceptance] + count;
							applicantMail = getElementById(mailID).value;
							getElementbyId("messageMail").value = applicantMail;
							
							//Add mail text
							if (acceptance = 0){
								
								//Mail text for Refused
								mailText = "Hello " + applicantName + "<br>
								 '";
								
							} else if (acceptance = 1){
								
								//Mail text for Accepted
								mailText = "Hello "+ applicantName + "<br>You are hired! From now on, you are a member of "+ team + ". Find and talk with us as soon as possible.<br>See you!<br><br>Inçnet Team<br>";
								
							} else {							
								error = "Error! Acceptance Error";
							}
						}
					</script>	
   
					<div id="login-box" class="login-popup">
				    <a href="#" class="close" style="left:10px;"><img src="close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
    				<form method="post" class="signin">
    					<table border="0">
					      <tr><td class="div">
					        <span class="messagediv">Name:</span>
					        <span style="font-size:15pt;color:#c5c5c5;"><input type='hidden' name='name' id='messageName'></span>
					      </td></tr>  
					      <tr><td class="div">
					        <span class="messagediv">E-mail Address:</span>
					        <span style="font-size:15pt;color:#c5c5c5;"><input type='hidden' name='mail' id='messageMail'></span>
					      </td></tr>  
					      <tr><td class="div">
					        <span class="messagediv" id='messageSubject'>Subject: Your Inçnet Application</span>
					        <span style="font-size:15pt;color:#c5c5c5;"></span>
		  				  </td></tr>  
					      <tr><td class="div">
		    				  <span class="messagediv" id='messageMail'>Mail Text:</span>
		    				  <span style="font-size:15pt;color:#c5c5c5;"><input type='hidden' name='mail' id='messageMail'></span>
		   					</td></tr>
		    				<tr><td class="div"> 
		      				<span class="messagediv">Do you wanna add something?</span>
		   					<td></tr>
		 					  <tr><td>
		    				  <textarea class="moremessage" name="moremessage" placeholder="More Message..."></textarea>
		   					</td></tr>
							   <tr><td class="div">
		      				<button class="submitbutton" type="button" name="send" style="button-radius:50px;">Send!</button>
		    				</td></tr>
   						</table>
 					  </form>
 					</div>
 					  
<?php
  if(isset($_POST["send"])){
  
		//Variables for Mail
		//$user_email = $_POST[];  
  
	  $mail = new PHPMailer();

		$mail->IsSMTP();  // telling the class to use SMTP
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host     = "smtp.gmail.com"; // SMTP server
		$mail->Port = 465;//25 for tevitol??
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->Username = "asdfg"; // SMTP username
		$mail->Password = "asdfg"; // SMTP password

		$mail->From     = "tevitolincnet@gmail.com";
		$mail->AddAddress($user_email);
		$mail->Subject  = $subject;
		$mail->Body     = $mailtext;
		$mail->WordWrap = 100;

		if(!$mail->Send()) {
			echo "<br>error sending notification email. Please contact your helpdesk<br>";
		} else {
			echo "<br>Notification email sent successfully<br>";
		}
			//echo "<hr><hr>$mailtext<hr><hr>"; 
	} 
?>
		
      </table>
    </div>
  </body>
</html>

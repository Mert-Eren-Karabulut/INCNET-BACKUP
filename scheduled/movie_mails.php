<?PHP
	error_reporting(0);

//connect to mysql server
include ("db_connect.php");
if (!$con){
  die('Could not connect: ' . mysql_error());
  }
  
$sql1 = "SELECT * FROM incnet.moviesBorrows";
$query1 = mysql_query($sql1);
while($row1 = mysql_fetch_array($query1)){
	$borrower_id = $row1['borrower_id'];
	$movie_id = $row1['movie_id'];
	$date_given = $row1['date_given'];
	$duration = $row1['duration'];

	$date_lent = $date_given;
	$date_given = explode("-", $date_given);
	
	
	$given_day = $date_given[2];
	$given_month = $date_given[1];
	$given_year = $date_given[0];

	$return_day = $given_day + $duration;

	$return_time = mktime(0,0,0,$given_month,$return_day,$given_year);
	$return_time = date("Y-m-d", $return_time);

	$sql2 = "SELECT name, lastname, email FROM incnet.coreUsers WHERE user_id='$borrower_id'";
	$query2 = mysql_query($sql2);
	while($row2 = mysql_fetch_array($query2)){
		$borrower_name = $row2['name'] . " " . $row2['lastname'];
		$borrower_email = $row2['email'];
	}

	$sql3 = "SELECT title, format FROM incnet.moviesMovies WHERE id='$movie_id'";
	$query3 = mysql_query($sql3);
	while($row3 = mysql_fetch_array($query3)){
		$movie_title = $row3['title'];
		$movie_format = $row3['format'];
	}

	
	$today=date("Y-m-d");
	if ($return_time<$today){
		echo "<b>$borrower_name must return $movie_title($movie_format) on $return_time.<br> Borrower email: $borrower_email<br></b><hr>";
		
			//send mails to the people
			require("class.phpmailer.php");

			$mail = new PHPMailer();

$mail->IsSMTP();  // telling the class to use SMTP
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

$mail->Host     = "smtp.gmail.com"; // SMTP server
$mail->Port = 465;//25 for tevitol??
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "tevitolincnet"; // SMTP username
$mail->Password = "Aa-Bb-Cc-01"; // SMTP password

$mail->From     = "tevitolincnet@gmail.com";
$mail->AddAddress($user_email);

			$mailtext = "
Dear $borrower_name,

Our records indicate that you have borrowed the movie $movie_title in a $movie_format on $date_lent.
The movie was lent to you for $duration days,therefore you should have brought it back on $return_time. Please do so.


--The Movie Archieve
";	



			$mail->Subject  = "Please return your movie";
			$mail->Body     = $mailtext;
			$mail->WordWrap = 100;

			if(!$mail->Send()) {
					echo "<br>error sending notification email. Please contact your helpdesk<br>";
			}
			else {
					echo "<br>Notification email sent successfully<br>";
			}
			echo "<hr><hr>$mailtext<hr><hr>";
			
		} else {
			echo "$borrower_name must return $movie_title($movie_format) on $return_time.<br> Borrower email: $borrower_email<br><hr>";	
		}

}


?>

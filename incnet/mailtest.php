<?PHP
	error_reporting(0);

require("class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();  // telling the class to use SMTP
$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail

$mail->Host     = "10.1.12.11"; // SMTP server
$mail->Port = 25;
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "incnet"; // SMTP username
$mail->Password = "Aa-Bb-Cc-01"; // SMTP password

$mail->From     = "incnet@tevitol.k12.tr";
$mail->AddAddress("aozkardes@tevitol.k12.tr");
$mail->AddAddress("bkearin@tevitol.k12.tr");
$mail->AddAddress("mbayburtlu@tevitol.k12.tr");
$mail->AddAddress("rkaya@tevitol.k12.tr");
$mail->AddAddress("ntekcan@tevitol.k12.tr");
$mail->AddAddress("ulerol@tevitol.k12.tr");

$mail->Subject  = "INCNET new event";
$mail->Body     = "A new event has been added to Incnet and needs your approval.";
$mail->WordWrap = 100;

if(!$mail->Send()) {
      $_SESSION['Error'] ="Message was not sent. Mailer error: " . $mail->ErrorInfo;
}
else {
      $_SESSION['Error'] = "The email was sent successfully.";
}
?>

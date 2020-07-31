<?

	session_start();
	$user_id = $_SESSION['user_id'];
	
	$jpeg_data = file_get_contents('php://input');
	$filename = "uploads/" . $user_id . "-upload.jpg";
	$result = file_put_contents( $filename, $jpeg_data );

?>
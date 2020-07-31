<?php
	
	include("check_token.php");
		
	if($token_arr[2] > time()){
		header("HTTP/1.0 403 Forbidden");
		die('{"error":"Token issue date in the future"}');
	}
	
	if($token_arr[3] < time()){
		header("HTTP/1.0 403 Forbidden");
		die('{"error":"Token expired"}');
	}
	
	$db_addr = "94.73.150.252";
	$db_user = "incnetRoot";
	$db_passwd = "MertEren20";
	$db_name = "incnet";
	
	$user_id = $token_arr[1];
	
	$conn = mysqli_connect($db_addr, $db_user, $db_passwd, $db_name);
	if(mysqli_connect_errno()){
		die("{\"error\":\"Mysql error: \\\"".str_replace("\"", "\\\"", mysqli_connect_error())."\\\"\"}");
	}
	
	mysqli_query($conn, "SET NAMES UTF8");
	
	$sql_user_details = "SELECT * FROM coreusers WHERE user_id=$user_id";
	
	$res = mysqli_query($conn, $sql_user_details) or die("{\"error\":\"Mysql error: \\\"".str_replace("\"", "\\\"", mysqli_error($conn))."\\\", sql: \"$sql_user_details\"\"}");
	$user_details = mysqli_fetch_assoc($res);
	unset($user_details['password']);
	die(json_encode($user_details));
	
	//var_dump($enc_signature);
	/*var_dump($token_arr);
	var_dump(base64_decode($_GET['token']));*/
	/*
	
	*/

/*
if(!openssl_public_decrypt($enc_signature, $dec_signature, $pubkey)) die("Error on line ".__LINE__.": ".openssl_error_string()."<br/><br/><br/><br/><br/><br/><br/> FYI: I only support the following methods: ".var_export(openssl_get_cipher_methods(), true));
	$dec_signature_array = explode(";", $dec_signature);
	$untrusted_user_id = $dec_signature_array[0];
	$issue_date = $dec_signature_array[1];
	$exp_date = $dec_signature_array[2];
	echo $issue_date.";";
	echo time().";";
	echo $exp_date.";";
	var_dump($dec_signature_array);
	var_dump($dec_signature);
	echo"<br/>$pubkey";
*/

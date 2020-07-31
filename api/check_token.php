<?php

	if(!isset($_GET['token'])){
		header("HTTP/1.0 403 Forbidden");
		die("{\"error\":\"No token supplied\"}");
	}
	$ini = parse_ini_file("./keys.ini");
	$pubkey = base64_decode($ini['public_key']);
	$decoded_token = base64_decode($_GET['token']);
	$token_arr = explode(";", $decoded_token);
	$untrusted_signature = base64_decode($token_arr[0]);
	$untrusted_expected_data = $token_arr[1].";".$token_arr[2].";".$token_arr[3];
	$verify_ret = openssl_verify($untrusted_expected_data, $untrusted_signature, $pubkey);	
	
	if($verify_ret != 1){
		if($verify_ret === 0){
			header("HTTP/1.0 403 Forbidden");
			die('{"error":"Signature does not match content. Stop tampering with my tokens."}');
		}else{
			header("HTTP/1.0 500 Internal Server Error");
			die('{"error":"Error encountered while trying to verify signature"}');
		}
	}
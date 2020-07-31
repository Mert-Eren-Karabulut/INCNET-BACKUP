<?php
//echo("<form action=# method=POST><input name=username><input type=password name=password><input type=submit></form>");
/*
$data = "Hello, World!";
echo("data: $data<br/>");

$config = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

$res = openssl_pkey_new($config);
if(!$res) die(openssl_error_string());
openssl_pkey_export($res, $privkey);
$pubkey = openssl_pkey_get_details($res);
$pubkey = $pubkey["key"];

openssl_public_encrypt($data, $ciphertext, $pubkey);
echo("ciphertext: ".htmlspecialchars($ciphertext)."<br/>");
echo("ciphertext size: ".strlen($ciphertext)." b<br/>");
openssl_private_decrypt($ciphertext, $plaintext, $privkey);
echo("plaintext: ".htmlspecialchars($plaintext)."<br/>");
*/
 
if(isset($_GET['token'])){
	header("HTTP/1.0 204");
	die();
}else{
	if(!(isset($_POST['username']) && isset($_POST['password']))){
		header("HTTP/1.0 403 Forbidden");
		die();
	}
	include("../db_connect.php");
	mysql_select_db("incnet");
	$sql = "SELECT password, user_id FROM coreusers WHERE username='".mysql_real_escape_string($_POST['username'])."'";
	$res = mysql_query($sql);
	$row = mysql_fetch_assoc($res);
	if(!$row || $row['password'] != md5($_POST['password'])) die("{\"error\": \"Username or password incorrect.\"}");
	$ini = parse_ini_file("./keys.ini");
	$privkey = base64_decode($ini['private_key']);
	$issue_date = time();
	$exp_date = $issue_date + 24 * 3600;
	//echo $exp_date;
	$data = "$row[user_id];$issue_date;$exp_date";
	openssl_sign($data, $ciphertext, $privkey);
	$token = base64_encode(base64_encode($ciphertext).";$row[user_id];$issue_date;$exp_date");
	die("{\"token\":\"$token\"}");
}

function write_php_ini($array, $file){
    $res = array();
    foreach($array as $key => $val){
        if(is_array($val)){
            $res[] = "[$key]";
            foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
        }
        else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
    }
    safefilerewrite($file, implode("\r\n", $res));
}

function safefilerewrite($fileName, $dataToSave){
    if ($fp = fopen($fileName, 'w')){
        $startTime = microtime(TRUE);
        do{
			$canWrite = flock($fp, LOCK_EX);
           // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
           if(!$canWrite) usleep(round(rand(0, 100)*1000));
        } while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));

        //file was locked so now we can store information
        if ($canWrite){
			fwrite($fp, $dataToSave);
            flock($fp, LOCK_UN);
        } else{
			throw new Exception("Unable to write!");
		}
        fclose($fp);
    }

}


function new_key_pair($path = "./keys.ini"){
	$config = array(
		"digest_alg" => "sha512",
		"private_key_bits" => 512,
		"private_key_type" => OPENSSL_KEYTYPE_RSA,
	);

	$res = openssl_pkey_new($config);
	if(!$res) die(openssl_error_string());
	openssl_pkey_export($res, $privkey);
	$pubkey = openssl_pkey_get_details($res);
	$pubkey = $pubkey["key"];
	write_php_ini(array("public_key" => base64_encode($pubkey), "private_key" => base64_encode($privkey)), $path);
}
